<?php

declare(strict_types=1);

function get_all_facilities(object $pdo)
{
  $query = "SELECT * FROM facility";
  $stmt = $pdo->query($query);
  return $stmt->fetchAll(PDO::FETCH_ASSOC);
}

function get_user_properties(object $pdo, int $userId)
{

  $query = "SELECT p.id, p.name, p.description, p.type, p.streetAddress, p.postalCode, p.city, COUNT(u.id) AS unit_count FROM property p LEFT JOIN unit u ON p.id = u.propertyId WHERE p.userId = :userId GROUP BY p.id, p.name, p.description, p.type;";

  $stmt = $pdo->prepare($query);
  $stmt->bindParam(":userId", $userId, PDO::PARAM_INT);
  $stmt->execute();
  return $stmt->fetchAll(PDO::FETCH_ASSOC);
}

function get_user_property_by_id(object $pdo, int $propertyId)
{
  $query = "SELECT 
              property.id AS property_id,
              property.name AS property_name,
              property.description AS property_description,
              property.type AS property_type,
              property.streetAddress,
              property.city,
              property.postalCode,
              property.userId AS user_id,
              unit.id AS unit_id,
              unit.type AS unit_type,
              unit.numberOfRooms,
              unit.quantity,
              unit.monthlyPrice,
              unit.isAvailable,
              unit.description AS unit_description,
              GROUP_CONCAT(DISTINCT unit_facility.facilityId) AS facility_ids,
              GROUP_CONCAT(DISTINCT CONCAT(unit_images.id, ':', unit_images.image)) AS images
            FROM 
              property
            INNER JOIN 
              unit ON property.id = unit.propertyId
            LEFT JOIN 
              unit_facility ON unit.id = unit_facility.unitId
            LEFT JOIN
              unit_images ON unit.id = unit_images.unitId
            WHERE 
              property.id = :propertyId
            GROUP BY 
              property.id, unit.id
            ORDER BY
              unit.id;";

  $stmt = $pdo->prepare($query);
  $stmt->bindParam(":propertyId", $propertyId, PDO::PARAM_INT);
  $stmt->execute();
  $rows = $stmt->fetchAll(PDO::FETCH_ASSOC);

  // Grouping results
  $property = null;
  $units = [];

  foreach ($rows as $row) {
    // Initialize property data on the first row
    if (!$property) {
      $property = [
        'id' => $row['property_id'],
        'name' => $row['property_name'],
        'description' => $row['property_description'],
        'type' => $row['property_type'],
        'streetAddress' => $row['streetAddress'],
        'city' => $row['city'],
        'postalCode' => $row['postalCode'],
        'userId' => $row['user_id'],
        'units' => []
      ];
    }

    // Initialize unit data
    if (!isset($units[$row['unit_id']])) {
      $units[$row['unit_id']] = [
        'id' => $row['unit_id'],
        'unit_type' => $row['unit_type'],
        'description' => $row['unit_description'],
        'numberOfRooms' => $row['numberOfRooms'],
        'quantity' => $row['quantity'],
        'monthlyPrice' => $row['monthlyPrice'],
        'isAvailable' => $row['isAvailable'],
        'facilities' => [],
        'images' => []
      ];
    }

    // Parse and add facilities
    if (!empty($row['facility_ids'])) {
      $units[$row['unit_id']]['facilities'] = array_map('intval', explode(',', $row['facility_ids']));
    }

    // Parse and add images
    if (!empty($row['images'])) {
      $images = explode(',', $row['images']);
      foreach ($images as $image) {
        [$imageId, $imagePath] = explode(':', $image); // Split image ID and path
        $units[$row['unit_id']]['images'][] = [
          'id' => (int) $imageId,
          'path' => $imagePath
        ];
      }
    }
  }

  // Add units to the property
  $property['units'] = array_values($units);

  return $property;
}

function update_property(object $pdo, int $propertyId, string $name, string $description, string $type, string $streetAddress, string $city, string $postalCode, )
{
  $query = "UPDATE property SET name = :name, description = :description, type = :type, streetAddress = :streetAddress, city = :city, postalCode = :postalCode WHERE id = :propertyId";
  $stmt = $pdo->prepare($query);
  $stmt->bindParam(":name", $name);
  $stmt->bindParam(":description", $description);
  $stmt->bindParam(":type", $type);
  $stmt->bindParam(":propertyId", $propertyId);
  $stmt->bindParam(":streetAddress", $streetAddress);
  $stmt->bindParam(":city", $city);
  $stmt->bindParam(":postalCode", $postalCode);
  $stmt->execute();
}

function update_unit(object $pdo, int $unitId, string $type, int $numberOfRooms, int $quantity, int $monthlyPrice, string $description)
{
  $query = "UPDATE unit SET type = :type, description = :description, numberOfRooms = :numberOfRooms, quantity = :quantity, monthlyPrice = :monthlyPrice WHERE id = :unitId";
  $stmt = $pdo->prepare($query);
  $stmt->bindParam(":unitId", $unitId);
  $stmt->bindParam(":type", $type);
  $stmt->bindParam(":numberOfRooms", $numberOfRooms);
  $stmt->bindParam(":quantity", $quantity);
  $stmt->bindParam(":monthlyPrice", $monthlyPrice);
  $stmt->bindParam(":description", $description);
  $stmt->execute();
}

function update_unit_facilities(object $pdo, int $unitId, array $facilities)
{
  $query = "DELETE FROM unit_facility WHERE unitId = :unitId";
  $stmt = $pdo->prepare($query);
  $stmt->bindParam(":unitId", $unitId);
  $stmt->execute();

  foreach ($facilities as $facilityId) {
    $query = "INSERT INTO unit_facility (unitId, facilityId) VALUES (:unitId, :facilityId)";
    $stmt = $pdo->prepare($query);
    $stmt->bindParam(":unitId", $unitId);
    $stmt->bindParam(":facilityId", $facilityId);
    $stmt->execute();
  }
}

function save_unit_image(object $pdo, int $unitId, string $filePath)
{
  $stmt = $pdo->prepare("INSERT INTO unit_images (unitId, image) VALUES (:unitId, :image)");
  $stmt->bindParam(":unitId", $unitId);
  $stmt->bindParam(":image", $filePath);
  $stmt->execute();
}

function delete_unit_image(object $pdo, int $imageId)
{
  try {
    $pdo->beginTransaction();

    $query = "SELECT image FROM unit_images WHERE id = :imageId";
    $stmt = $pdo->prepare($query);
    $stmt->bindParam(":imageId", $imageId, PDO::PARAM_INT);
    $stmt->execute();

    $image = $stmt->fetch(PDO::FETCH_ASSOC);
    if (!$image) {
      throw new Exception("Image not found in database.");
    }

    $imagePath = $_SERVER['DOCUMENT_ROOT'] . "/studentshelter/uploads" . $image['image'];
    if (!file_exists($imagePath)) {
      throw new Exception("File does not exist at path: $imagePath");
    }

    // Delete the image from the database
    $deleteQuery = "DELETE FROM unit_images WHERE id = :imageId";
    $deleteStmt = $pdo->prepare($deleteQuery);
    $deleteStmt->bindParam(":imageId", $imageId, PDO::PARAM_INT);
    $deleteStmt->execute();

    // Delete the image file
    if (!unlink($imagePath)) {
      throw new Exception("Failed to delete the file at: $imagePath");
    }

    $pdo->commit();
    return ['success' => true, 'message' => 'Image deleted successfully.'];

  } catch (Exception $e) {
    $pdo->rollBack();
    return ['success' => false, 'message' => $e->getMessage()];
  }
}

function delete_property(object $pdo, int $propertyId)
{
  try {
    $pdo->beginTransaction();

    // Retrieve and delete images from the file system
    $fetchImagesQuery = "SELECT ui.image 
                             FROM unit_images ui
                             INNER JOIN unit u ON ui.unitId = u.id
                             WHERE u.propertyId = :propertyId";
    $stmt = $pdo->prepare($fetchImagesQuery);
    $stmt->bindParam(':propertyId', $propertyId, PDO::PARAM_INT);
    $stmt->execute();

    $images = $stmt->fetchAll(PDO::FETCH_COLUMN);

    foreach ($images as $imagePath) {
      if (file_exists($imagePath)) {
        unlink($imagePath);
      }
    }

    // Delete the property (cascades to units, facilities, and images)
    $deletePropertyQuery = "DELETE FROM property WHERE id = :propertyId";
    $stmt = $pdo->prepare($deletePropertyQuery);
    $stmt->bindParam(':propertyId', $propertyId, PDO::PARAM_INT);
    $stmt->execute();

    $pdo->commit();

    return true; // Successful deletion
  } catch (Exception $e) {
    $pdo->rollBack();
    error_log("Failed to delete property: " . $e->getMessage());
    return false;
  }
}

function insert_new_unit(object $pdo, int $propertyId, string $unitType, int $numberOfRooms, int $quantity, int $monthlyPrice, string $description)
{
  $sql = "INSERT INTO unit (propertyId, type, numberOfRooms, quantity, monthlyPrice, description) 
            VALUES (:propertyId, :type, :numberOfRooms, :quantity, :monthlyPrice, :description)";

  $stmt = $pdo->prepare($sql);
  $stmt->execute([
    ':propertyId' => $propertyId,
    ':type' => $unitType,
    ':numberOfRooms' => $numberOfRooms,
    ':quantity' => $quantity,
    ':monthlyPrice' => $monthlyPrice,
    ':description' => $description,
  ]);

  return $pdo->lastInsertId();
}

function add_property(object $pdo, int $userId, string $name, string $description, string $type, string $streetAddress, string $city, string $postalCode): int
{
  $query = "INSERT INTO property (userId, name, description, type, streetAddress, city, postalCode) VALUES (:userId, :name, :description, :type, :streetAddress, :city, :postalCode)";
  $stmt = $pdo->prepare($query);
  $stmt->bindParam(":userId", $userId);
  $stmt->bindParam(":name", $name);
  $stmt->bindParam(":description", $description);
  $stmt->bindParam(":type", $type);
  $stmt->bindParam(":streetAddress", $streetAddress);
  $stmt->bindParam(":city", $city);
  $stmt->bindParam(":postalCode", $postalCode);
  $stmt->execute();
  return (int) $pdo->lastInsertId();
}

function add_unit(object $pdo, int $propertyId, string $type, int $numberOfRooms, int $quantity, int $monthlyPrice, string $description)
{
  $query = "INSERT INTO unit (propertyId, type, numberOfRooms, quantity, isAvailable, monthlyPrice, description) VALUES (:propertyId, :type, :numberOfRooms, :quantity, 1, :monthlyPrice, :description)";
  $stmt = $pdo->prepare($query);
  $stmt->bindParam(":propertyId", $propertyId);
  $stmt->bindParam(":type", $type);
  $stmt->bindParam(":numberOfRooms", $numberOfRooms);
  $stmt->bindParam(":quantity", $quantity);
  $stmt->bindParam(":monthlyPrice", $monthlyPrice);
  $stmt->bindParam(":description", $description);
  $stmt->execute();

  return (int) $pdo->lastInsertId();
}

function add_unit_facility(object $pdo, int $unitId, int $facilityId)
{
  $query = "INSERT INTO unit_facility (unitId, facilityId) VALUES (:unitId, :facilityId)";
  $stmt = $pdo->prepare($query);
  $stmt->bindParam(":unitId", $unitId);
  $stmt->bindParam(":facilityId", $facilityId);
  $stmt->execute();
}

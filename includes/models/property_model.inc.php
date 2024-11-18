<?php

declare(strict_types=1);

function add_property(object $pdo, int $userId, string $name, string $description, string $type): int
{
  $query = "INSERT INTO property (userId, name, description, type) VALUES (:userId, :name, :description, :type)";
  $stmt = $pdo->prepare($query);
  $stmt->bindParam(":userId", $userId);
  $stmt->bindParam(":name", $name);
  $stmt->bindParam(":description", $description);
  $stmt->bindParam(":type", $type);
  $stmt->execute();
  return (int) $pdo->lastInsertId();
}

function add_unit(object $pdo, int $propertyId, string $type, int $numberOfRooms, int $quantity, int $monthlyPrice)
{
  $query = "INSERT INTO unit (propertyId, type, numberOfRooms, quantity, isAvailable, monthlyPrice) VALUES (:propertyId, :type, :numberOfRooms, :quantity, 1, :monthlyPrice)";
  $stmt = $pdo->prepare($query);
  $stmt->bindParam(":propertyId", $propertyId);
  $stmt->bindParam(":type", $type);
  $stmt->bindParam(":numberOfRooms", $numberOfRooms);
  $stmt->bindParam(":quantity", $quantity);
  $stmt->bindParam(":monthlyPrice", $monthlyPrice);
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

function update_property(object $pdo, int $propertyId, string $name, string $description, string $type)
{
  $query = "UPDATE property SET name = :name, description = :description, type = :type WHERE id = :propertyId";
  $stmt = $pdo->prepare($query);
  $stmt->bindParam(":name", $name);
  $stmt->bindParam(":description", $description);
  $stmt->bindParam(":type", $type);
  $stmt->bindParam(":propertyId", $propertyId);
  $stmt->execute();
}

function update_unit(object $pdo, int $unitId, string $type, int $numberOfRooms, int $quantity, int $monthlyPrice)
{
  $query = "UPDATE unit SET type = :type, numberOfRooms = :numberOfRooms, quantity = :quantity, monthlyPrice = :monthlyPrice WHERE id = :unitId";
  $stmt = $pdo->prepare($query);
  $stmt->bindParam(":unitId", $unitId);
  $stmt->bindParam(":type", $type);
  $stmt->bindParam(":numberOfRooms", $numberOfRooms);
  $stmt->bindParam(":quantity", $quantity);
  $stmt->bindParam(":monthlyPrice", $monthlyPrice);
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

function fetch_all_facilities(object $pdo)
{
  $query = "SELECT * FROM facility";
  $stmt = $pdo->query($query);
  return $stmt->fetchAll(PDO::FETCH_ASSOC);
}

function get_user_properties(object $pdo, int $userId)
{

  $query = "SELECT p.id, p.name, p.description, p.type, COUNT(u.id) AS unit_count FROM property p LEFT JOIN unit u ON p.id = u.propertyId WHERE p.userId = :userId GROUP BY p.id, p.name, p.description, p.type;";

  $stmt = $pdo->prepare($query);
  $stmt->bindParam(":userId", $userId, PDO::PARAM_INT);
  $stmt->execute();
  return $stmt->fetchAll(PDO::FETCH_ASSOC);
}

function get_property_by_id(object $pdo, int $propertyId)
{
  $query = "SELECT 
              property.id AS property_id,
              property.name AS property_name,
              property.description AS property_description,
              property.type AS property_type,
              unit.id AS unit_id,
              unit.type AS unit_type,
              unit.numberOfRooms,
              unit.quantity,
              unit.monthlyPrice,
              unit.isAvailable,
              unit_facility.facilityId
            FROM 
              property
            INNER JOIN 
              unit ON property.id = unit.propertyId
            LEFT JOIN 
              unit_facility ON unit.id = unit_facility.unitId
            WHERE 
              property.id = :propertyId
            ORDER BY
              unit.id;
            ";
  $stmt = $pdo->prepare($query);
  $stmt->bindParam(":propertyId", $propertyId, PDO::PARAM_INT);
  $stmt->execute();
  $rows = $stmt->fetchAll(PDO::FETCH_ASSOC);

  // Grouping results
  $property = null;
  $units = [];

  foreach ($rows as $row) {
    // If it's the first row, initialize property data
    if (!$property) {
      $property = [
        'id' => $row['property_id'],
        'name' => $row['property_name'],
        'description' => $row['property_description'],
        'type' => $row['property_type'],
        'units' => []
      ];
    }

    // Check if the unit is already added
    if (!isset($units[$row['unit_id']])) {
      $units[$row['unit_id']] = [
        'id' => $row['unit_id'],
        'type' => $row['unit_type'],
        'numberOfRooms' => $row['numberOfRooms'],
        'quantity' => $row['quantity'],
        'monthlyPrice' => $row['monthlyPrice'],
        'isAvailable' => $row['isAvailable'],
        'facilities' => []
      ];
    }

    // Add facility ID to the unit's facilities array
    if ($row['facilityId']) { // Check if the facility exists
      $units[$row['unit_id']]['facilities'][] = $row['facilityId'];
    }
  }

  // Add units to the property
  $property['units'] = array_values($units);

  return $property;
}

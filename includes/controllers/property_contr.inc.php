<?php

declare(strict_types=1);

function is_property_input_empty(string $name, string $description, string $type)
{
  return empty($name) || empty($description) || empty($type);
}

function is_unit_input_invalid(array $units)
{
  foreach ($units as $unitIndex => $unit) {
    if (empty($unit['description']) || empty($unit['unit_type']) || $unit['numberOfRooms'] < 1 || $unit['quantity'] < 1 || $unit['monthlyPrice'] < 1) {
      return true;
    }

    // Check if the unit has at least one image uploaded (assuming images are passed via $_FILES)
    if (!isset($_FILES['unit_images']['name'][$unitIndex]) || empty($_FILES['unit_images']['tmp_name'][$unitIndex])) {
      return true;
    }
  }
  return false;
}

function is_edit_unit_input_invalid(array $units)
{
  foreach ($units as $unit) {
    if (empty($unit['description']) || empty($unit['unit_type']) || $unit['numberOfRooms'] < 1 || $unit['quantity'] < 1 || $unit['monthlyPrice'] < 1) {
      return true;
    }
  }
  return false;
}

function fetch_facilities(object $pdo)
{
  return fetch_all_facilities($pdo);
}

function create_property(object $pdo, int $userId, string $name, string $description, string $type, array $units)
{
  $pdo->beginTransaction();

  try {
    // Add the property to the database
    $propertyId = add_property($pdo, $userId, $name, $description, $type);

    // Loop through each unit and add it to the database
    foreach ($units as $unitIndex => $unit) {
      $unit['numberOfRooms'] = (int) $unit['numberOfRooms'];
      $unit['quantity'] = (int) $unit['quantity'];
      $unit['monthlyPrice'] = (int) $unit['monthlyPrice'];

      // Add unit to the database
      $unitId = add_unit($pdo, $propertyId, $unit['unit_type'], $unit['numberOfRooms'], $unit['quantity'], $unit['monthlyPrice'], $unit['description']);

      // Handle unit images upload if available
      if (isset($_FILES['unit_images']['name'][$unitIndex])) {
        $uploadDir = '../uploads/unit_images/' . $unitId . '/';
        if (!file_exists($uploadDir)) {
          mkdir($uploadDir, 0777, true);
        }

        // Process the uploaded images for this unit
        foreach ($_FILES['unit_images']['tmp_name'][$unitIndex] as $key => $tmpName) {
          $fileName = uniqid('unit_image_') . '.' . pathinfo($_FILES['unit_images']['name'][$unitIndex][$key], PATHINFO_EXTENSION);
          $filePath = $uploadDir . $fileName;

          // Validate and move the file to the correct directory
          if (move_uploaded_file($tmpName, $filePath)) {
            // Save the image path to the database
            save_unit_image($pdo, $unitId, $filePath);
          } else {
            throw new Exception("Error uploading image for unit " . ($unitIndex + 1));
          }
        }
      }

      // Add facilities to the unit
      if (!empty($unit['facilities'])) {
        foreach ($unit['facilities'] as $facilityId) {
          $facilityId = (int) $facilityId;
          add_unit_facility($pdo, $unitId, $facilityId);
        }
      }
    }

    // Commit the transaction if all operations are successful
    $pdo->commit();
  } catch (Exception $e) {
    // Rollback the transaction if any error occurs
    $pdo->rollBack();
    throw $e;  // Re-throw the exception for handling at a higher level
  }
}

function update_user_property(object $pdo, int $propertyId, string $name, string $description, string $type, array $units)
{
  $pdo->beginTransaction();

  update_property($pdo, $propertyId, $name, $description, $type);

  foreach ($units as $unitIndex => $unit) {
    $unitId = (int) $unit['id'];

    update_unit($pdo, $unitId, $unit['unit_type'], (int) $unit['numberOfRooms'], (int) $unit['quantity'], (int) $unit['monthlyPrice'], $unit['description']);

    if (!empty($unit['facilities'])) {
      update_unit_facilities($pdo, $unitId, $unit['facilities']);
    }

    // Handle new images uploaded for this unit
    if (!empty($_FILES['unit_images']['name'][$unitIndex][0])) {
      $uploadDir = '../uploads/unit_images/' . $unitId . '/';
      if (!file_exists($uploadDir)) {
        mkdir($uploadDir, 0777, true);
      }

      foreach ($_FILES['unit_images']['tmp_name'][$unitIndex] as $key => $tmpName) {
        $fileName = uniqid('unit_image_') . '.' . pathinfo($_FILES['unit_images']['name'][$unitIndex][$key], PATHINFO_EXTENSION);
        $filePath = $uploadDir . $fileName;

        // Validate and move the file to the correct directory
        if (move_uploaded_file($tmpName, $filePath)) {
          // Save the new image path to the database
          save_unit_image($pdo, $unitId, $filePath);
        } else {
          throw new Exception("Error uploading new image for unit " . ($unitIndex + 1));
        }
      }
    }
  }

  $pdo->commit();
}

function fetch_properties(object $pdo, int $userId)
{
  return get_user_properties($pdo, $userId);
}

function fetch_property(object $pdo, int $propertyId)
{
  return get_property_by_id($pdo, $propertyId);
}

function delete_property(object $pdo, int $propertyId)
{
  return delete_property_with_units_and_facilities($pdo, $propertyId);
}

function delete_unit_image(object $pdo, int $imageId)
{
  return delete_unit_image_by_id($pdo, $imageId);
}

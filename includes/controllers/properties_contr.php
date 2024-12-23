<?php

declare(strict_types=1);

require_once "includes/models/property_model.php";

function handleProperties($subpage, $action, $id)
{
  switch ($subpage) {
    case 'add':
      handle_add_property();
      break;

    case 'edit':
      handle_edit_property($id);
      break;

    case '':
      handle_view_properties();
      break;

    case 'delete':
      handle_delete_property($id);
      break;

    case 'delete-unit-image':
      handle_delete_unit_image();
      break;

    default:
      die("Invalid subpage: {$subpage}");
  }
}

function handle_view_properties()
{
  require_once "includes/models/dbh.php";

  $_SESSION["edit_property_data"] = null;
  $_SESSION["edit_property_errors"] = null;

  $userId = $_SESSION['user_id'];
  $properties = get_user_properties($pdo, $userId);

  require_once "includes/views/properties_view.php";
  render_properties($properties);
}

function handle_add_property()
{
  // Redirect to the Add Property page (you can include the form or handle it directly here)
  header("Location: /studentshelter/properties/add");
  exit;
}

function handle_edit_property(int $id)
{
  if (!$id) {
    echo "Invalid property ID.";
    die();
  }

  require_once "includes/models/dbh.php";
  require_once "includes/models/property_model.php";
  require_once "includes/views/properties_view.php";


  if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $userId = $_SESSION['user_id'];
    $name = $_POST['name'];
    $description = $_POST['description'];
    $type = $_POST['type'];
    $streetAddress = $_POST['streetAddress'];
    $city = $_POST['city'];
    $postalCode = $_POST['postalCode'];
    $units = $_POST['units'];

    try {
      // Error handlers
      $errors = validate_edit_property_input(compact("name", "description", "type", "streetAddress", "city", "postalCode", "units"));

      if ($errors) {
        $_SESSION["edit_property_data"] = compact("name", "description", "type", "streetAddress", "city", "postalCode", "units");
        $_SESSION["edit_property_errors"] = $errors;
        header("Location: /studentshelter/properties/edit?id=$id");
        exit();
      }

      update_user_property($pdo, $id, $name, $description, $type, $streetAddress, $city, $postalCode, $units);

      $_SESSION["edit_property_data"] = null;
      $_SESSION["edit_property_errors"] = null;
      header("Location: /studentshelter/properties");
      $pdo = null;
      $stmt = null;
      die();
    } catch (PDOException $e) {
      die("Query failed: " . $e->getMessage());
    }
  } else {
    $property = null;
    $facilities = [];
    $errors = $_SESSION["edit_property_errors"] ?? [];

    if (isset($_SESSION["edit_property_data"])) {
      $property = $_SESSION["edit_property_data"];
    } else {
      $property = get_user_property_by_id($pdo, $id);
      if (!$property) {
        echo "Property not found.";
        die();
      }
      $_SESSION["edit_property_data"] = $property;
    }

    if (isset($_SESSION["facilities"])) {
      $facilities = $_SESSION["facilities"];
    } else {
      $facilities = get_all_facilities($pdo);
      $_SESSION["facilities"] = $facilities;
    }

    render_edit_property_form($id, $property, $facilities, $errors);
  }
}

function validate_edit_property_input(array $input)
{
  $errors = [];

  if (empty($input['name']) || empty($input['description']) || empty($input['type']) || empty($input['streetAddress']) || empty($input['city']) || empty($input['postalCode'])) {
    $errors[] = "Please fill in all property fields.";
  }

  foreach ($input['units'] as $unit) {
    if (empty($unit['description']) || empty($unit['unit_type']) || $unit['numberOfRooms'] < 1 || $unit['quantity'] < 1 || $unit['monthlyPrice'] < 1) {
      $errors[] = "Invalid unit information. Ensure all fields are correctly filled.";
      break;
    }
  }

  // Check if the unit has at least one image uploaded (assuming images are passed via $_FILES)
  // if (!isset($_FILES['unit_images']['name'][$unitIndex]) || empty($_FILES['unit_images']['tmp_name'][$unitIndex])) {
  //   return true;
  // }

  return $errors;
}

function update_user_property(object $pdo, int $propertyId, string $name, string $description, string $type, string $streetAddress, string $city, string $postalCode, array $units)
{
  try {
    $pdo->beginTransaction();

    update_property($pdo, $propertyId, $name, $description, $type, $streetAddress, $city, $postalCode);

    foreach ($units as $unitIndex => $unit) {
      $unitId = isset($unit['id']) ? (int) $unit['id'] : null;

      if ($unitId) {
        // Update existing unit
        update_unit($pdo, $unitId, $unit['unit_type'], (int) $unit['numberOfRooms'], (int) $unit['quantity'], (int) $unit['monthlyPrice'], $unit['description']);
      } else {
        // Insert new unit and get the generated ID
        $unitId = insert_new_unit($pdo, $propertyId, $unit['unit_type'], (int) $unit['numberOfRooms'], (int) $unit['quantity'], (int) $unit['monthlyPrice'], $unit['description']);
      }

      if (!empty($unit['facilities'])) {
        update_unit_facilities($pdo, (int) $unitId, $unit['facilities']);
      }

      // Handle new images uploaded for this unit
      if (!empty($_FILES['unit_images']['name'][$unitIndex][0])) {
        $baseDir = $_SERVER['DOCUMENT_ROOT'] . '/studentshelter/uploads';
        $uploadDir = $baseDir . "/unit_images/$unitId/";

        if (!is_dir($uploadDir)) {
          mkdir($uploadDir, 0777, true);
        }

        $uploadResult = validate_and_upload_unit_images($_FILES['unit_images'], $unitIndex, $uploadDir, $baseDir);

        if ($uploadResult['errors']) {
          throw new Exception("Error uploading images for unit " . ($unitIndex + 1) . ": " . implode(', ', $uploadResult['errors']));
        }

        // Save the new image paths to the database
        foreach ($uploadResult['paths'] as $filePath) {
          save_unit_image($pdo, $unitId, $filePath);
        }
      }
    }

    $pdo->commit();
  } catch (Exception $e) {
    if ($pdo->inTransaction()) {
      $pdo->rollBack();
    }
    throw $e;
  }
}

function validate_and_upload_unit_images(array $files, int $unitIndex, string $uploadDir, string $baseDir)
{
  $errors = [];
  $paths = [];

  $allowedTypes = ['image/jpeg', 'image/png', 'application/pdf'];
  foreach ($files['tmp_name'][$unitIndex] as $key => $tmpName) {
    $fileType = $files['type'][$unitIndex][$key];

    if (!in_array($fileType, $allowedTypes)) {
      $errors[] = "Invalid file type for unit " . ($unitIndex + 1) . " image " . ($key + 1);
      continue;
    }

    $fileName = uniqid('unit_image_') . '.' . pathinfo($files['name'][$unitIndex][$key], PATHINFO_EXTENSION);
    $filePath = $uploadDir . $fileName;

    if (move_uploaded_file($tmpName, $filePath)) {
      $paths[] = str_replace($baseDir, '', $filePath);
    } else {
      $errors[] = "Error uploading unit " . ($unitIndex + 1) . " image " . ($key + 1);
    }
  }

  return ['errors' => $errors, 'paths' => $paths];
}

function handle_delete_property(int $id)
{
  require_once "includes/models/dbh.php";

  if ($id) {
    $success = delete_property($pdo, $id);

    if ($success) {
      header("Location: /studentshelter/properties");
    } else {
      header("Location: /studentshelter/properties");
    }
  }
  die();
}

function handle_delete_unit_image()
{
  require_once "includes/models/dbh.php";

  $redirectUrl = isset($_SERVER['HTTP_REFERER']) ? $_SERVER['HTTP_REFERER'] : '/';

  if (!isset($_GET['id']) || !isset($_SESSION['user_id'])) {
    header(header: "Location: $redirectUrl&error=image_id_missing");
    die();
  }

  $imageId = $_GET['id'];

  if ($imageId) {
    $result = delete_unit_image($pdo, (int) $imageId);

    if ($result['success']) {
      header("Location: $redirectUrl");
      $_SESSION["edit_property_data"] = null;
      $_SESSION["edit_property_errors"] = null;
    } else {
      $_SESSION['edit_property_errors'][] = $result['message'];
      header("Location: $redirectUrl");
    }
  }
  die();
}

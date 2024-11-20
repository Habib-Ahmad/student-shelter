<?php
require_once "dbh.inc.php";
require_once "config_session.inc.php";
require_once "models/property_model.inc.php";
require_once "controllers/property_contr.inc.php";

if ($_SERVER["REQUEST_METHOD"] !== "POST" || !isset($_SESSION["user_id"])) {
  // Redirect to the previous page or the homepage if there's no referrer or if user is not logged in
  $redirectUrl = isset($_SERVER['HTTP_REFERER']) ? $_SERVER['HTTP_REFERER'] : '/';
  header("Location: $redirectUrl");
  die();
}

$userId = $_SESSION['user_id'];
$name = $_POST['name'];
$description = $_POST['description'];
$type = $_POST['type'];
$units = $_POST['units'];
$propertyId = $_SESSION['property_data']["id"];

var_dump($units);

try {
  // Error handlers
  $errors = [];
  if (is_property_input_empty($name, $description, $type)) {
    $errors[] = "Please fill in all property fields.";
  }

  if (is_unit_input_invalid($units)) {
    $errors[] = "Invalid unit information. Ensure all fields are correctly filled.";
  }

  if ($errors) {
    $_SESSION["errors_property"] = $errors;
    $_SESSION["property_data"] = compact("name", "description", "type", "units");
    header("Location: ../properties/edit/?property_id=$propertyId");
    exit();
  }

  update_user_property($pdo, $propertyId, $name, $description, $type, $units);
  header("Location: ../properties/?update_success=true");
  $pdo = null;
  $stmt = null;
  die();
} catch (PDOException $e) {
  die("Query failed: " . $e->getMessage());
}

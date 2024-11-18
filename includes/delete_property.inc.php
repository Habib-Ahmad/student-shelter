<?php
require_once "../includes/dbh.inc.php";
require_once "../includes/config_session.inc.php";
require_once "../includes/models/property_model.inc.php";
require_once "../includes/controllers/property_contr.inc.php";

if (!isset($_GET['property_id']) || !isset($_SESSION['user_id'])) {
  header("Location: ./properties?error=invalid_request");
  die();
}

$propertyId = (int) $_GET['property_id'];
$userId = (int) $_SESSION['user_id'];

// Fetch the property to verify ownership
$property = fetch_property($pdo, $propertyId);

if (!$property || $property['userId'] !== $userId) {
  header("Location: ./properties?error=unauthorized");
  die();
}

if (delete_property($pdo, $propertyId)) {
  header("Location: ../properties?message=property_deleted");
} else {
  header("Location: ../properties?error=deletion_failed");
}
die();

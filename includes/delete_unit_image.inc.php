<?php
require_once './dbh.inc.php';
require_once './config_session.inc.php';
require_once './models/property_model.inc.php';
require_once './controllers/property_contr.inc.php';

$redirectUrl = isset($_SERVER['HTTP_REFERER']) ? $_SERVER['HTTP_REFERER'] : '/';

if (!isset($_GET['image_id']) || !isset($_SESSION['user_id'])) {
  header("Location: $redirectUrl&error=image_id_missing");
  die();
}

$imageId = $_GET['image_id'];

if ($imageId) {
  $success = delete_unit_image($pdo, $imageId);
  if ($success) {
    header("Location: $redirectUrl&message=image_deleted");
  } else {
    header("Location: $redirectUrl&error=image_delete_failed");
  }
}
die();

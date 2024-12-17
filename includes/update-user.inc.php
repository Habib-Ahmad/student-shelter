<?php

if ($_SERVER["REQUEST_METHOD"] !== "POST") {
  header("Location: ../profile");
  die();
}

$phone = $_POST["phone"];

try {
  require_once "dbh.inc.php";
  require_once "config_session.inc.php";
  require_once "models/users_model.inc.php";
  require_once "controllers/users_contr.inc.php";

  // Error handlers
  $errors = [];
  if (empty($phone)) {
    array_push($errors, "Field cannot be empty");
  }

  if (!is_phone_valid($phone)) {
    array_push($errors, "Invalid phone number");
  }

  if ($errors) {
    $_SESSION["errors_profile"] = $errors;
    header("Location: ../profile?error=invalid input");
    die();
  }

  update_user_phone($pdo, $phone, $_SESSION["user_id"]);

  $_SESSION["user_phone"] = $phone;
  $_SESSION["errors_profile"] = null;

  header("Location: ../profile?message=success");
  $pdo = null;
  die();
} catch (PDOException $e) {
  die("Query failed: " . $e->getMessage());
}


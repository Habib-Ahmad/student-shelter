<?php

if ($_SERVER["REQUEST_METHOD"] !== "POST") {
  header("Location: ../profile");
  die();
}

$oldPassword = $_POST["oldPassword"];
$newPassword = $_POST["newPassword"];
$confirmPassword = $_POST["confirmPassword"];

try {
  require_once "dbh.inc.php";
  require_once "config_session.inc.php";
  require_once "models/login_model.inc.php";
  require_once "models/users_model.inc.php";
  require_once "controllers/users_contr.inc.php";

  // Error handlers
  $errors = [];
  if (empty($oldPassword) || empty($newPassword) || empty($confirmPassword)) {
    array_push($errors, "Field cannot be empty");
  }

  $user = get_user($pdo, $_SESSION["user_email"]);

  if (!password_verify($oldPassword, $user["pwd"])) {
    array_push($errors, "Old password is incorrect");
  }

  if ($newPassword !== $confirmPassword) {
    array_push($errors, "Passwords do not match");
  }

  if ($errors) {
    $_SESSION["errors_pwd"] = $errors;
    header("Location: ../profile?error=invalid input");
    die();
  }

  update_user_password($pdo, $_SESSION["user_id"], password_hash($newPassword, PASSWORD_DEFAULT));

  $_SESSION["errors_pwd"] = [];

  header("Location: ../profile?message=success");
  $pdo = null;
  die();
} catch (PDOException $e) {
  die("Query failed: " . $e->getMessage());
}


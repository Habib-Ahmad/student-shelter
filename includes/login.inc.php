<?php

if ($_SERVER["REQUEST_METHOD"] !== "POST") {
  header("Location: ../login");
  die();
}

$email = $_POST["email"];
$password = $_POST["password"];

try {
  require_once "dbh.inc.php";
  require_once "models/login_model.inc.php";
  require_once "controllers/login_contr.inc.php";

  // Error handlers
  $errors = [];
  if (is_login_input_empty($email, $password, )) {
    array_push($errors, "Fill all fields please");
  }

  $result = get_user($pdo, $email);

  if (is_email_wrong($result)) {
    array_push($errors, "Invalid login info!");
  }
  if (!is_email_wrong($result) && is_password_wrong($password, $result["pwd"])) {
    array_push($errors, "Invalid login info!");
  }

  require_once "config_session.inc.php";

  if ($errors) {
    $_SESSION["errors_login"] = $errors;
    header("Location: ../login");
    die();
  }

  $newSessionId = session_create_id();
  $sessionId = $newSessionId . "_" . $result["id"];
  session_id($sessionId);

  $_SESSION["user_id"] = $result["id"];
  $_SESSION["user_email"] = $result["email"];
  $_SESSION["user_firstName"] = $result["firstName"];
  $_SESSION["user_lastName"] = $result["lastName"];
  $_SESSION["user_role"] = $result["userRole"];
  $_SESSION["user_phone"] = $result["phone"];

  $_SESSION["last_regeneration"] = time();

  header("Location: ../");
  $pdo = null;
  $stmt = null;
  die();
} catch (PDOException $e) {
  die("Query failed: " . $e->getMessage());
}

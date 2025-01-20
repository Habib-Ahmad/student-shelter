<?php

declare(strict_types=1);

function handleLogin()
{
  if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    process_login();
  } else {
    render_login_page();
  }
}

function process_login()
{
    $email = filter_input(INPUT_POST, 'email', FILTER_VALIDATE_EMAIL);
    $password = filter_input(INPUT_POST, 'password', FILTER_SANITIZE_FULL_SPECIAL_CHARS);

  // Error handling
  $errors = validate_login_inputs($email, $password);

  if ($errors) {
    $_SESSION['errors_login'] = $errors;
    header("Location: /studentshelter/login");
    die();
  }

  try {
    require_once "includes/models/dbh.php";
    require_once "includes/models/login_model.php";

    $user = get_user($pdo, $email);

    if (is_password_wrong($password, $user["pwd"])) {
      array_push($errors, "Invalid login information");
    }

    if ($errors) {
      $_SESSION["errors_login"] = $errors;
      header("Location: /studentshelter/login");
      die();
    }

    $sessionId = session_create_id();
    session_id($sessionId);

    $_SESSION["user_id"] = $user["id"];
    $_SESSION["user_email"] = $user["email"];
    $_SESSION["user_firstName"] = $user["firstName"];
    $_SESSION["user_lastName"] = $user["lastName"];
    $_SESSION["user_role"] = $user["userRole"];
    $_SESSION["user_phone"] = $user["phone"];
    $_SESSION["user_status"] = $user["status"];

    $_SESSION["last_regeneration"] = time();

    header("Location: /studentshelter/");
    $pdo = null;
    $stmt = null;
    die();
  } catch (PDOException $e) {
    die("Query failed: " . $e->getMessage());
  }
}

function render_login_page()
{
  $errors = $_SESSION['errors_login'] ?? [];

  unset($_SESSION['errors_login']);

  require_once 'includes/views/login_view.php';
  render_login_form($errors);
}

function validate_login_inputs($email, $password)
{
  $errors = [];

  if (empty($email) || empty($password)) {
    $errors[] = "Please fill out all fields.";
  }

  return $errors;
}

function is_password_wrong(string $pwd, $hashedPwd)
{
  return !password_verify($pwd, $hashedPwd);
}
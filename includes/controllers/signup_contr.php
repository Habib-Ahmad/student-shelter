<?php

declare(strict_types=1);

function handleSignup()
{
  require_once 'includes/config_session.php';

  if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    process_signup();
  } else {
    render_signup_page();
  }
}

function process_signup()
{
  $firstName = filter_input(INPUT_POST, 'firstName', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
  $lastName = filter_input(INPUT_POST, 'lastName', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
  $phone = filter_input(INPUT_POST, 'phone', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
  $email = filter_input(INPUT_POST, 'email', FILTER_VALIDATE_EMAIL);
  $password = filter_input(INPUT_POST, 'password', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
  $confirmPassword = filter_input(INPUT_POST, 'confirmPassword', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
  $role = $_POST['role'] ?? null;

  // Error handling
  $errors = validate_signup_inputs($firstName, $lastName, $phone, $email, $password, $confirmPassword, $role);

  if ($errors) {
    $_SESSION['errors_signup'] = $errors;
    $_SESSION['signup_data'] = compact('firstName', 'lastName', 'email', 'phone', 'role');
    header("Location: /studentshelter/signup");
    die();
  }

  try {
    require_once 'includes/models/dbh.php';
    require_once 'includes/models/signup_model.php';

    $pdo->beginTransaction();

    $userId = create_user($pdo, $firstName, $lastName, $email, $phone, $password, $role);

    $pdo->commit();

    $sessionId = session_create_id();
    session_id($sessionId);

    $_SESSION["user_id"] = $userId;
    $_SESSION["user_email"] = $email;
    $_SESSION["user_firstName"] = $firstName;
    $_SESSION["user_lastName"] = $lastName;
    $_SESSION["user_role"] = $role;
    $_SESSION["user_phone"] = $phone;
    $_SESSION["user_status"] = "pending";
    $_SESSION["errors_signup"] = null;

    $_SESSION["last_regeneration"] = time();

    header("Location: /studentshelter");
    die();
  } catch (Exception $e) {
    if (isset($pdo) && $pdo->inTransaction()) {
      $pdo->rollBack();
    }
    die("Error processing signup: " . $e->getMessage());
  }
}

function render_signup_page()
{
  $errors = $_SESSION['errors_signup'] ?? [];
  $formData = $_SESSION['signup_data'] ?? [];

  unset($_SESSION['errors_signup']);
  unset($_SESSION['signup_data']);

  require_once 'includes/views/signup_view.php';
  render_signup_form($errors, $formData);
}

function validate_signup_inputs(string $firstName, string $lastName, string $phone, string $email, string $password, string $confirmPassword, string $role)
{
  $errors = [];

  if (empty($firstName) || empty($lastName) || empty($phone) || empty($email) || empty($password) || empty($confirmPassword) || empty($role)) {
    $errors[] = "Please fill out all fields.";
  }
  if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
    $errors[] = "Invalid email format.";
  }
  if ($password !== $confirmPassword) {
    $errors[] = "Passwords do not match.";
  }
  if (!in_array($role, ['student', 'landlord'])) {
    $errors[] = "Invalid role.";
  }

  return $errors;
}

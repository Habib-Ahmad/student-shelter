<?php

declare(strict_types=1);

function handleSignup()
{
  if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    process_signup();
  } else {
    render_signup_page();
  }
}

function process_signup()
{
  $firstName = $_POST['firstName'] ?? null;
  $lastName = $_POST['lastName'] ?? null;
  $phone = $_POST['phone'] ?? null;
  $email = $_POST['email'] ?? null;
  $password = $_POST['password'] ?? null;
  $confirmPassword = $_POST['confirmPassword'] ?? null;
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

    // Handle document uploads for students
    if ($role === 'student') {
      $baseDir = $_SERVER['DOCUMENT_ROOT'] . '/studentshelter/uploads';
      $uploadDir = $baseDir . "/user_documents/$userId/";

      if (!is_dir($uploadDir))
        mkdir($uploadDir, 0777, true);

      $result = validate_and_upload_documents($_FILES, $uploadDir, $baseDir);
      if ($result['errors']) {
        $pdo->rollBack();
        $_SESSION['errors_signup'] = $result['errors'];
        $_SESSION['signup_data'] = compact('firstName', 'lastName', 'email', 'phone', 'role');
        header("Location: /studentshelter/signup");
        exit;
      }

      save_user_documents($pdo, $userId, $result['paths']);
    }

    $pdo->commit();

    $sessionId = session_create_id();
    session_id($sessionId);

    $_SESSION["user_id"] = $userId;
    $_SESSION["user_email"] = $email;
    $_SESSION["user_firstName"] = $firstName;
    $_SESSION["user_lastName"] = $lastName;
    $_SESSION["user_role"] = $role;
    $_SESSION["user_phone"] = $phone;
    $_SESSION["status"] = "pending";
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

function validate_and_upload_documents(array $files, string $uploadDir, string $baseDir)
{
  $errors = [];
  $paths = [];

  // Required files
  $requiredFiles = ['validId', 'studentProof'];
  foreach ($requiredFiles as $fileKey) {
    if (empty($files[$fileKey]['name'])) {
      $errors[] = ucfirst($fileKey) . " is required.";
    }
  }

  if (!$errors) {
    $allowedTypes = ['image/jpeg', 'image/png', 'application/pdf'];
    foreach ($requiredFiles as $fileKey) {
      if (!in_array($files[$fileKey]['type'], $allowedTypes)) {
        $errors[] = "Invalid file type for " . ucfirst($fileKey) . ".";
      }
    }

    if (!$errors) {
      foreach ($requiredFiles as $fileKey) {
        $filePath = $uploadDir . uniqid($fileKey . '_') . '.' . pathinfo($files[$fileKey]['name'], PATHINFO_EXTENSION);

        if (move_uploaded_file($files[$fileKey]['tmp_name'], $filePath)) {
          $paths[$fileKey] = str_replace($baseDir, '', $filePath);
        } else {
          $errors[] = "Error uploading " . ucfirst($fileKey) . ".";
        }
      }
    }
  }

  return ['errors' => $errors, 'paths' => $paths];
}

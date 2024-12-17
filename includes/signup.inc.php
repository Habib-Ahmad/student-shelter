<?php

if ($_SERVER["REQUEST_METHOD"] !== "POST") {
  header("Location: ../signup");
  die();
}

$firstName = $_POST["firstName"];
$lastName = $_POST["lastName"];
$phone = $_POST["phone"];
$email = $_POST["email"];
$password = $_POST["password"];
$confirmPassword = $_POST["confirmPassword"];
$role = $_POST["role"];

try {
  require_once "dbh.inc.php";
  require_once "models/signup_model.inc.php";
  require_once "controllers/signup_contr.inc.php";

  // Error handlers
  $errors = [];
  if (is_input_empty($firstName, $lastName, $phone, $email, $password, $confirmPassword, $role)) {
    array_push($errors, "Fill all fields please");
  }
  if (is_email_invalid($email)) {
    array_push($errors, "E-mail is invalid");
  }
  if (is_email_registered($pdo, $email)) {
    array_push($errors, "E-mail is already registered");
  }
  if (do_pwds_not_match($password, $confirmPassword)) {
    array_push($errors, "Passwords do not match");
  }
  if (is_role_invalid($role)) {
    array_push($errors, "Invalid role (options: 'student', 'landlord')");
  }

  require_once "config_session.inc.php";

  if ($errors) {
    $_SESSION["errors_signup"] = $errors;

    $signupData = [
      "firstName" => $firstName,
      "lastName" => $lastName,
      "email" => $email,
      "phone" => $phone,
      "password" => $password,
      "confirmPassword" => $confirmPassword,
      "role" => $role,
    ];
    $_SESSION["signup_data"] = $signupData;

    header("Location: ../signup");
    die();
  }

  // Begin transaction
  $pdo->beginTransaction();

  // Create the user
  $userId = create_user($pdo, $firstName, $lastName, $email, $phone, $password, $role);

  // Save document paths (only for students)
  if ($role === 'student') {
    $uploadDir = "../uploads/$userId/";

    if (!is_dir($uploadDir)) {
      mkdir($uploadDir, 0777, true);
    }

    $result = validate_and_upload_documents($_FILES, $uploadDir);

    if ($result['errors']) {
      // Rollback on document upload failure
      $pdo->rollBack();
      array_push($errors, ...$result['errors']);
      $_SESSION["errors_signup"] = $errors;
      header("Location: ../signup");
      die();
    }

    // Save document paths
    $validIdPath = $result['paths']['validId'];
    $studentProofPath = $result['paths']['studentProof'];

    save_user_document($pdo, $userId, 'Valid ID', $validIdPath);
    save_user_document($pdo, $userId, 'Proof of Student', $studentProofPath);
  }

  // Commit transaction
  $pdo->commit();

  header("Location: ../?signup=success");
  $pdo = null;
  die();
} catch (PDOException $e) {
  if ($pdo->inTransaction()) {
    $pdo->rollBack();
  }
  die("Query failed: " . $e->getMessage());
}

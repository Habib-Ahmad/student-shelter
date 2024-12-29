<?php

declare(strict_types=1);

function handleProfile($subpage, $action, $id)
{
  if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    switch ($subpage) {
      case null:
        handle_profile_update((int) $id);
        break;

      case 'password':
        handle_password_update($id);
        break;

      case 'documents':
        handle_documents_upload($id);
        break;

      default:
        header("Location: /studentshelter/profile?message=Invalid+request");
        die();
    }
  } else {
    render_profile_page();
  }
}

function render_profile_page()
{
  require_once 'includes/views/profile_view.php';
  render_profile_form();
}

function handle_profile_update(int $id)
{
  $role = $_SESSION['user_role'];
  $phone = $_POST['phone'] ?? '';
  $firstName = $role !== 'student' ? ($_POST['firstName'] ?? '') : $_SESSION['user_firstName'];
  $lastName = $role !== 'student' ? ($_POST['lastName'] ?? '') : $_SESSION['user_lastName'];

  $errors = [];
  if ($role !== 'student') {
    if (empty($firstName) || empty($lastName) || empty($phone)) {
      array_push($errors, "Fields cannot be empty");
    }
  } else {
    if (empty($phone)) {
      array_push($errors, "Field cannot be empty");
    }
  }

  if ($errors) {
    $_SESSION['errors_profile'] = $errors;
    header("Location: /studentshelter/profile?message=invalid+input");
    die();
  }


  try {
    require_once 'includes/models/dbh.php';
    require_once 'includes/models/profile_model.php';

    update_user($pdo, $id, $firstName, $lastName, $phone);

    $_SESSION['user_firstName'] = $firstName;
    $_SESSION['user_lastName'] = $lastName;
    $_SESSION['user_phone'] = $phone;

    $pdo = null;
    $_SESSION['errors_profile'] = null;

    header("Location: /studentshelter/profile?message=Profile+Updated+Successfully");
    die();
  } catch (PDOException $e) {
    die("Query failed: " . $e->getMessage());
  }
}

function handle_password_update($id)
{
  $oldPassword = $_POST['oldPassword'] ?? '';
  $newPassword = $_POST['newPassword'] ?? '';
  $confirmPassword = $_POST['confirmPassword'] ?? '';

  $errors = [];

  // Validation
  if (empty($oldPassword) || empty($newPassword) || empty($confirmPassword)) {
    $errors[] = "All fields are required.";
  }
  if ($newPassword !== $confirmPassword) {
    $errors[] = "New passwords do not match.";
  }
  if (strlen($newPassword) < 6) {
    $errors[] = "New password must be at least 6 characters.";
  }

  if ($errors) {
    $_SESSION['errors_pwd'] = $errors;
    header("Location: /studentshelter/profile");
    die();
  }

  try {
    require_once 'includes/models/dbh.php';
    require_once 'includes/models/profile_model.php';

    // Verify the old password
    $user = get_user_by_id($pdo, $id); // Fetch user data
    if (!password_verify($oldPassword, $user['pwd'])) {
      $_SESSION['errors_pwd'] = ["Old password is incorrect."];
      header("Location: /studentshelter/profile");
      die();
    }

    // Hash the new password
    $hashedPassword = password_hash($newPassword, PASSWORD_DEFAULT);

    // Update password in the database
    update_password($pdo, $id, $hashedPassword);

    $pdo = null;
    $_SESSION['errors_pwd'] = null;

    header("Location: /studentshelter/profile?message=Password+Updated+Successfully");
    die();
  } catch (PDOException $e) {
    die("Query failed: " . $e->getMessage());
  }
}

function handle_documents_upload($id)
{
  $baseDir = $_SERVER['DOCUMENT_ROOT'] . '/studentshelter/uploads';
  $uploadDir = $baseDir . "/user_documents/$id/";

  if (!is_dir($uploadDir))
    mkdir($uploadDir, 0777, true);

  $result = validate_and_upload_documents($_FILES, $uploadDir, $baseDir);
  if ($result['errors']) {
    $_SESSION['errors_docs'] = $result['errors'];
    header("Location: /studentshelter/profile?message=Document+Upload+Failed");
    die();
  }

  try {
    require_once 'includes/models/dbh.php';
    require_once 'includes/models/profile_model.php';

    save_user_documents($pdo, $id, $result['paths']);
    update_user_status($pdo, $id, 'in review');
    $_SESSION['user_status'] = 'in review';

    $pdo = null;
    $_SESSION['errors_docs'] = null;

    header("Location: /studentshelter/profile?message=Documents+Uploaded+Successfully");
    die();
  } catch (PDOException $e) {
    die("Query failed: " . $e->getMessage());
  }
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
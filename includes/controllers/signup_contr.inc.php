<?php

declare(strict_types=1);

function is_input_empty(string $firstName, string $lastName, string $email, string $phone, string $password, string $confirmPassword, string $role)
{
  return empty($firstName) || empty($lastName) || empty($email) || empty($phone) || empty($password) || empty($confirmPassword) || empty($role);
}

function is_email_invalid(string $email)
{
  return !filter_var($email, FILTER_VALIDATE_EMAIL);
}

function is_email_registered(object $pdo, string $email)
{
  return get_email($pdo, $email);
}

function do_pwds_not_match(string $password, string $confirmPassword)
{
  return $password !== $confirmPassword;
}

function is_role_invalid(string $role)
{
  return $role !== "student" && $role !== "landlord";
}

function create_user(object $pdo, string $firstName, string $lastName, string $email, string $phone, string $password, string $role)
{
  return set_user($pdo, $firstName, $lastName, $email, $phone, $password, $role);
}

function validate_and_upload_documents(array $files, string $uploadDir): array
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
          $paths[$fileKey] = $filePath;
        } else {
          $errors[] = "Error uploading " . ucfirst($fileKey) . ".";
        }
      }
    }
  }

  return ['errors' => $errors, 'paths' => $paths];
}

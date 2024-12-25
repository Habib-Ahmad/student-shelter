<?php

declare(strict_types=1);

function handle_image_uploads(array $files, string $uploadDir, array $allowedTypes = ['image/jpeg', 'image/png', 'application/pdf'], string $prefix = 'file_')
{
  $errors = [];
  $paths = [];

  // Ensure the upload directory exists
  if (!is_dir($uploadDir)) {
    mkdir($uploadDir, 0777, true);
  }

  foreach ($files['tmp_name'] as $key => $tmpName) {
    if (empty($tmpName)) {
      continue;
    }

    $fileType = $files['type'][$key];
    if (!in_array($fileType, $allowedTypes)) {
      $errors[] = "Invalid file type for " . $files['name'][$key];
      continue;
    }

    $fileName = uniqid($prefix) . '.' . pathinfo($files['name'][$key], PATHINFO_EXTENSION);
    $filePath = $uploadDir . $fileName;

    if (move_uploaded_file($tmpName, $filePath)) {
      $paths[] = $filePath; // Store the full path
    } else {
      $errors[] = "Error uploading " . $files['name'][$key];
    }
  }

  return ['errors' => $errors, 'paths' => $paths];
}

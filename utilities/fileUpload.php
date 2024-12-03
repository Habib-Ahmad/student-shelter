<?php
function validate_and_upload_files(array $files, string $uploadDir, array $allowedExtensions = ['jpg', 'jpeg', 'png', 'pdf'], int $maxFileSize = 5 * 1024 * 1024): array
{
  $errors = [];
  $uploadedPaths = [];

  // Ensure the upload directory exists
  if (!is_dir($uploadDir)) {
    mkdir($uploadDir, 0777, true);
  }

  // Loop through each file
  foreach ($files['name'] as $index => $name) {
    if ($files['error'][$index] !== UPLOAD_ERR_OK) {
      $errors[] = "Error uploading file: $name";
      continue;
    }

    $fileSize = $files['size'][$index];
    $tmpName = $files['tmp_name'][$index];
    $extension = strtolower(pathinfo($name, PATHINFO_EXTENSION));

    // Validate file size
    if ($fileSize > $maxFileSize) {
      $errors[] = "File too large: $name (max size: " . ($maxFileSize / (1024 * 1024)) . "MB)";
      continue;
    }

    // Validate file extension
    if (!in_array($extension, $allowedExtensions)) {
      $errors[] = "Invalid file type: $name (allowed: " . implode(', ', $allowedExtensions) . ")";
      continue;
    }

    // Generate a unique file name to avoid conflicts
    $uniqueName = uniqid('upload_') . ".$extension";
    $filePath = $uploadDir . $uniqueName;

    // Move the file to the upload directory
    if (move_uploaded_file($tmpName, $filePath)) {
      $uploadedPaths[] = $filePath;
    } else {
      $errors[] = "Failed to move uploaded file: $name";
    }
  }

  return [
    'errors' => $errors,
    'paths' => $uploadedPaths,
  ];
}

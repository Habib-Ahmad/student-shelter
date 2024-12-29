<?php

declare(strict_types=1);

function update_user(object $pdo, int $id, string $firstName, string $lastName, string $phone)
{
  $sql = "UPDATE users SET firstName = :firstName, lastName = :lastName, phone = :phone WHERE id = :id";
  $stmt = $pdo->prepare($sql);
  $stmt->execute(['firstName' => $firstName, 'lastName' => $lastName, 'phone' => $phone, 'id' => $id]);
}

function get_user_by_id(object $pdo, int $id)
{
  $query = "SELECT * FROM users WHERE id = :id;";
  $stmt = $pdo->prepare($query);
  $stmt->bindParam(":id", $id);
  $stmt->execute();

  $result = $stmt->fetch(PDO::FETCH_ASSOC);
  return $result;
}

function update_password(object $pdo, int $id, string $password)
{
  $query = "UPDATE users SET pwd = :password WHERE id = :id";
  $stmt = $pdo->prepare($query);
  $stmt->bindParam(':id', $id, PDO::PARAM_INT);
  $stmt->bindParam(':password', $password, PDO::PARAM_STR);
  $stmt->execute();
}

function save_user_documents(object $pdo, int $userId, array $documentPaths)
{
  $documentNames = [
    'validId' => 'Valid ID',
    'studentProof' => 'Student Proof',
  ];

  // Fetch existing documents for the user
  $stmt = $pdo->prepare("SELECT document_path FROM user_documents WHERE userId = ?");
  $stmt->execute([$userId]);
  $existingDocuments = $stmt->fetchAll(PDO::FETCH_ASSOC);

  // Delete existing files from the file system
  foreach ($existingDocuments as $doc) {
    $filePath = $_SERVER['DOCUMENT_ROOT'] . '/studentshelter/uploads' . $doc['document_path'];
    if (file_exists($filePath)) {
      unlink($filePath);
    }
  }

  // Remove old database records
  $stmt = $pdo->prepare("DELETE FROM user_documents WHERE userId = ?");
  $stmt->execute([$userId]);

  // Insert new documents
  $stmt = $pdo->prepare("INSERT INTO user_documents (userId, name, document_path) VALUES (?, ?, ?)");
  foreach ($documentPaths as $type => $path) {
    $name = $documentNames[$type] ?? ucfirst($type); // Fallback to ucfirst if no mapping exists
    $stmt->execute([$userId, $name, $path]);
  }
}

function update_user_status(object $pdo, int $userId, string $status)
{
  $stmt = $pdo->prepare("UPDATE users SET status = ? WHERE id = ?");
  $stmt->execute([$status, $userId]);
}

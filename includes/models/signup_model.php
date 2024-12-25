<?php

declare(strict_types=1);

function create_user(object $pdo, string $firstName, string $lastName, string $email, string $phone, string $password, string $role)
{
  $hashedPassword = password_hash($password, PASSWORD_DEFAULT);
  $stmt = $pdo->prepare("INSERT INTO users (firstName, lastName, email, phone, pwd, userRole) VALUES (?, ?, ?, ?, ?, ?)");
  $stmt->execute([$firstName, $lastName, $email, $phone, $hashedPassword, $role]);
  return $pdo->lastInsertId();
}

function save_user_documents(object $pdo, int $userId, array $documentPaths)
{
  $documentNames = [
    'validId' => 'Valid ID',
    'studentProof' => 'Student Proof',
  ];

  $stmt = $pdo->prepare("INSERT INTO user_documents (userId, name, document_path) VALUES (?, ?, ?)");
  foreach ($documentPaths as $type => $path) {
    $name = $documentNames[$type] ?? ucfirst($type); // Fallback to ucfirst if no mapping exists
    $stmt->execute([$userId, $name, $path]);
  }
}

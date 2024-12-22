<?php

function create_user($pdo, $firstName, $lastName, $email, $phone, $password, $role)
{
  $hashedPassword = password_hash($password, PASSWORD_DEFAULT);
  $stmt = $pdo->prepare("INSERT INTO users (firstName, lastName, email, phone, pwd, userRole) VALUES (?, ?, ?, ?, ?, ?)");
  $stmt->execute([$firstName, $lastName, $email, $phone, $hashedPassword, $role]);
  return $pdo->lastInsertId();
}

function save_user_documents($pdo, $userId, $documentPaths)
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

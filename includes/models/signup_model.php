<?php

declare(strict_types=1);

function create_user(object $pdo, string $firstName, string $lastName, string $email, string $phone, string $password, string $role)
{
  $hashedPassword = password_hash($password, PASSWORD_DEFAULT);
  $stmt = $pdo->prepare("INSERT INTO users (firstName, lastName, email, phone, pwd, userRole) VALUES (?, ?, ?, ?, ?, ?)");
  $stmt->execute([$firstName, $lastName, $email, $phone, $hashedPassword, $role]);
  return $pdo->lastInsertId();
}

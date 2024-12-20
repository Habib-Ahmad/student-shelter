<?php

declare(strict_types=1);

function get_email(object $pdo, string $email)
{
  $query = "SELECT email FROM users WHERE email = :email;";
  $stmt = $pdo->prepare($query);
  $stmt->bindParam(":email", $email);
  $stmt->execute();

  $result = $stmt->fetch(PDO::FETCH_ASSOC);
  return $result;
}

function set_user(object $pdo, string $firstName, string $lastName, string $email, string $phone, string $password, string $role)
{
  $query = "INSERT INTO users (firstName, lastName, email, phone, pwd, userRole) VALUES (:firstName, :lastName, :email, :phone, :pwd, :userRole);";
  $stmt = $pdo->prepare($query);

  $options = [
    "cost" => 12,
  ];
  $hashedPassword = password_hash($password, PASSWORD_BCRYPT, $options);

  $stmt->bindParam(":firstName", $firstName);
  $stmt->bindParam(":lastName", $lastName);
  $stmt->bindParam(":email", $email);
  $stmt->bindParam(":phone", $phone);
  $stmt->bindParam(":pwd", $hashedPassword);
  $stmt->bindParam(":userRole", $role);
  $stmt->execute();

  return $pdo->lastInsertId();
}

function save_user_document(PDO $pdo, int $userId, string $name, string $path)
{
  $stmt = $pdo->prepare("INSERT INTO user_documents (userId, name, document_path) VALUES (:userId, :name, :document_path)");
  $stmt->bindParam(":userId", $userId);
  $stmt->bindParam(":name", $name);
  $stmt->bindParam(":document_path", $path);
  $stmt->execute();
}

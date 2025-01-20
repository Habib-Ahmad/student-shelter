<?php

declare(strict_types=1);

function get_user(object $pdo, string $email)
{
  $query = "SELECT * FROM users WHERE email = :email;";
  $stmt = $pdo->prepare($query);
  $stmt->bindParam(":email", $email);
  $stmt->execute();

  $result = $stmt->fetch(PDO::FETCH_ASSOC);
  return $result;
}

function create_password_reset(object $pdo, int $userId, string $token)
{
  $sql = "INSERT INTO password_resets (user_id, token) VALUES (:user_id, :token)";
  $stmt = $pdo->prepare($sql);
  $stmt->execute(['user_id' => $userId, 'token' => $token]);
  return $stmt->rowCount() === 1;
}

function get_password_reset(object $pdo, string $token)
{
  $query = "SELECT * FROM password_resets WHERE token = :token;";
  $stmt = $pdo->prepare($query);
  $stmt->bindParam(":token", $token);
  $stmt->execute();

  $result = $stmt->fetch(PDO::FETCH_ASSOC);
  return $result;
}

function update_user_password($pdo, $user_id, $password)
{
  $hashed_password = password_hash($password, PASSWORD_DEFAULT);
  $stmt = $pdo->prepare('UPDATE users SET pwd = :pwd WHERE id = :id');
  $stmt->execute(['pwd' => $hashed_password, 'id' => $user_id]);
  return $stmt->rowCount() === 1;
}

function delete_password_reset($pdo, $token)
{
  $stmt = $pdo->prepare('DELETE FROM password_resets WHERE token = :token');
  $stmt->execute(['token' => $token]);
  return $stmt->rowCount() === 1;
}

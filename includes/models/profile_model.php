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


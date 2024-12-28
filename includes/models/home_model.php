<?php

declare(strict_types=1);

function get_all_properties(object $pdo)
{
  $query = "SELECT u.id, p.name, u.description, CONCAT(p.type, ', ', u.type) AS type, u.numberOfRooms, u.monthlyPrice, p.streetAddress, p.city, p.postalCode FROM unit u LEFT JOIN property p ON u.propertyId=p.id;";
  $stmt = $pdo->query($query);
  return $stmt->fetchAll(PDO::FETCH_ASSOC);
}

function add_to_favorites(object $pdo, int $userId, int $unitId)
{
  $query = "INSERT INTO favorites (userId, unitId) VALUES (:userId, :unitId)";
  $stmt = $pdo->prepare($query);
  $stmt->bindParam(":userId", $userId);
  $stmt->bindParam(":unitId", $unitId);
  return $stmt->execute();
}

function remove_from_favorites(object $pdo, int $userId, int $unitId)
{
  $query = "DELETE FROM favorites WHERE userId = :userId AND unitId = :unitId";
  $stmt = $pdo->prepare($query);
  $stmt->bindParam(":userId", $userId);
  $stmt->bindParam(":unitId", $unitId);
  return $stmt->execute();
}

function is_property_favorite(object $pdo, int $userId, int $unitId)
{
  $query = "SELECT COUNT(*) FROM favorites WHERE userId = :userId AND unitId = :unitId";
  $stmt = $pdo->prepare($query);
  $stmt->bindParam(":userId", $userId);
  $stmt->bindParam(":unitId", $unitId);
  $stmt->execute();
  return $stmt->fetchColumn() > 0;
}
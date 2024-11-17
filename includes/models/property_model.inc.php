<?php

declare(strict_types=1);

function add_property(object $pdo, int $userId, string $name, string $description, string $type): int
{
  $query = "INSERT INTO property (userId, name, description, type) VALUES (:userId, :name, :description, :type)";
  $stmt = $pdo->prepare($query);
  $stmt->bindParam(":userId", $userId);
  $stmt->bindParam(":name", $name);
  $stmt->bindParam(":description", $description);
  $stmt->bindParam(":type", $type);
  $stmt->execute();
  return (int) $pdo->lastInsertId();
}

function add_unit(object $pdo, int $propertyId, string $type, int $numberOfRooms, int $quantity, int $monthlyPrice)
{
  $query = "INSERT INTO unit (propertyId, type, numberOfRooms, quantity, isAvailable, monthlyPrice) VALUES (:propertyId, :type, :numberOfRooms, :quantity, 1, :monthlyPrice)";
  $stmt = $pdo->prepare($query);
  $stmt->bindParam(":propertyId", $propertyId);
  $stmt->bindParam(":type", $type);
  $stmt->bindParam(":numberOfRooms", $numberOfRooms);
  $stmt->bindParam(":quantity", $quantity);
  $stmt->bindParam(":monthlyPrice", $monthlyPrice);
  $stmt->execute();

  return (int) $pdo->lastInsertId();
}

function add_unit_facility(object $pdo, int $unitId, int $facilityId)
{
  $query = "INSERT INTO unit_facility (unitId, facilityId) VALUES (:unitId, :facilityId)";
  $stmt = $pdo->prepare($query);
  $stmt->bindParam(":unitId", $unitId);
  $stmt->bindParam(":facilityId", $facilityId);
  $stmt->execute();
}

function fetch_all_facilities(object $pdo)
{
  $query = "SELECT * FROM facility";
  $stmt = $pdo->query($query);
  return $stmt->fetchAll(PDO::FETCH_ASSOC);
}
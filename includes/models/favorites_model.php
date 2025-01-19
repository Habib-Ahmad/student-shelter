<?php

declare(strict_types=1);

function get_user_favorites(object $pdo, int $userId)
{
  $sql = "SELECT favorites.id, monthlyPrice, name, unit.type, streetAddress, city, postalCode, unit.id as unitId FROM favorites LEFT JOIN unit ON favorites.unitId = unit.id LEFT JOIN property ON unit.propertyId = property.id WHERE favorites.userId = :userId";
  $stmt = $pdo->prepare($sql);
  $stmt->bindParam(':userId', $userId, PDO::PARAM_INT);
  $stmt->execute();

  return $stmt->fetchAll();
}
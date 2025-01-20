<?php

declare(strict_types=1);

function get_all_properties(object $pdo)
{
  $query = "
        SELECT 
            u.id, 
            p.name, 
            u.description, 
            CONCAT(p.type, ', ', u.type) AS type, 
            u.numberOfRooms, 
            u.monthlyPrice, 
            p.streetAddress, 
            p.city, 
            p.postalCode,
            GROUP_CONCAT(ui.image) AS images
        FROM 
            unit u
        LEFT JOIN 
            property p ON u.propertyId = p.id
        LEFT JOIN 
            unit_images ui ON u.id = ui.unitId
        GROUP BY 
            u.id, p.name, p.type, u.type, u.numberOfRooms, u.monthlyPrice, p.streetAddress, p.city, p.postalCode;
    ";
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

function get_filtered_properties($pdo, $city = null, $maxBudget = null, $type = null, $numberOfRooms = null)
{
  $query = "SELECT u.id, p.name, u.description, CONCAT(p.type, ', ', u.type) AS type, u.numberOfRooms, u.monthlyPrice, p.streetAddress, p.city, p.postalCode 
              FROM unit u 
              LEFT JOIN property p ON u.propertyId = p.id";

  $conditions = [];
  $parameters = [];

  if ($city) {
    $conditions[] = "p.city LIKE :city";
    $parameters[':city'] = "%$city%";
  }
  if ($maxBudget) {
    $conditions[] = "u.monthlyPrice <= :maxBudget";
    $parameters[':maxBudget'] = $maxBudget;
  }
  if ($type) {
    $conditions[] = "p.type LIKE :type";
    $parameters[':type'] = "%$type%";
  }
  if ($numberOfRooms) {
    $conditions[] = "u.numberOfRooms = :numberOfRooms";
    $parameters[':numberOfRooms'] = $numberOfRooms;
  }

  if (!empty($conditions)) {
    $query .= " WHERE " . implode(" AND ", $conditions);
  }

  $stmt = $pdo->prepare($query);
  $stmt->execute($parameters);

  return $stmt->fetchAll(PDO::FETCH_ASSOC);
}

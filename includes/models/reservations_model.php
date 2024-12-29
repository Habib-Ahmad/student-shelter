<?php

declare(strict_types=1);

function get_user_reservations(object $pdo, int $id)
{
  $query = 'SELECT 
              reservation.*, 
              CONCAT(property.name, ", ", unit.type) AS property
            FROM 
              reservation
            INNER JOIN 
              unit ON reservation.unitId = unit.id
            INNER JOIN 
              property ON unit.propertyId = property.id
            WHERE 
              reservation.userId = :id
            ORDER BY 
              reservation.created_at DESC;';
  $stmt = $pdo->prepare($query);
  $stmt->bindParam(':id', $id, PDO::PARAM_INT);
  $stmt->execute();

  return $stmt->fetchAll();
}
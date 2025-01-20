<?php

declare(strict_types=1);

function get_user_favorites(object $pdo, int $userId)
{
  $sql = "
        SELECT 
            favorites.id, 
            monthlyPrice, 
            name, 
            unit.type, 
            streetAddress, 
            city, 
            postalCode, 
            unit.id AS unitId,
            GROUP_CONCAT(unit_images.image) AS images
        FROM 
            favorites
        LEFT JOIN 
            unit ON favorites.unitId = unit.id
        LEFT JOIN 
            property ON unit.propertyId = property.id
        LEFT JOIN 
            unit_images ON unit.id = unit_images.unitId
        WHERE 
            favorites.userId = :userId
        GROUP BY 
            favorites.id, monthlyPrice, name, unit.type, streetAddress, city, postalCode, unit.id
    ";
  $stmt = $pdo->prepare($sql);
  $stmt->bindParam(':userId', $userId, PDO::PARAM_INT);
  $stmt->execute();

  return $stmt->fetchAll(PDO::FETCH_ASSOC);
}

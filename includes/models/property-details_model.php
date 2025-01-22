<?php

declare(strict_types=1);

function get_property_details_by_id(object $pdo, int $id)
{
  $query = "SELECT 
              property.id AS property_id,
              property.name AS property_name,
              property.description AS property_description,
              property.type AS property_type,
              property.streetAddress,
              property.city,
              property.postalCode,
              property.userId AS user_id,
              unit.id AS unit_id,
              unit.type AS unit_type,
              unit.numberOfRooms,
              unit.quantity,
              unit.monthlyPrice,
              unit.isAvailable,
              unit.description AS unit_description,
              GROUP_CONCAT(DISTINCT unit_facility.facilityId) AS facility_ids,
              GROUP_CONCAT(DISTINCT CONCAT(unit_images.id, ':', unit_images.image)) AS images,
              users.email AS landlord_email
            FROM 
              property
            INNER JOIN 
              unit ON property.id = unit.propertyId
            LEFT JOIN
              unit_facility ON unit.id = unit_facility.unitId
            LEFT JOIN
              unit_images ON unit.id = unit_images.unitId
            INNER JOIN
              users ON property.userId = users.id
            WHERE 
              unit.id = :unitId
            GROUP BY
              property.id, unit.id, users.email
            ORDER BY
              unit.id;";
  $stmt = $pdo->prepare($query);
  $stmt->bindParam(":unitId", $id, PDO::PARAM_INT);
  $stmt->execute();
  $rows = $stmt->fetchAll(PDO::FETCH_ASSOC);
  return $rows;
}

function create_reservation(object $pdo, int $unitId, int $userId, string $startDate, string $endDate)
{
  $query = "INSERT INTO reservation (unitId, userId, startDate, endDate) VALUES (:unitId, :userId, :startDate, :endDate);";
  $stmt = $pdo->prepare($query);
  $stmt->bindParam(":unitId", $unitId, PDO::PARAM_INT);
  $stmt->bindParam(":userId", $userId, PDO::PARAM_INT);
  $stmt->bindParam(":startDate", $startDate, PDO::PARAM_STR);
  $stmt->bindParam(":endDate", $endDate, PDO::PARAM_STR);
  $stmt->execute();
}

function get_reservations_by_unit_id(object $pdo, int $unitId)
{
  $query = "SELECT * FROM reservation WHERE unitId = :unitId AND isConfirmed = 1;";
  $stmt = $pdo->prepare($query);
  $stmt->bindParam(":unitId", $unitId, PDO::PARAM_INT);
  $stmt->execute();
  $rows = $stmt->fetchAll(PDO::FETCH_ASSOC);
  return $rows;
}

function get_3_random_properties(object $pdo, int $id)
{
  $query = "SELECT u.id, p.name, u.description, CONCAT(p.type, ', ', u.type) AS type, u.numberOfRooms, u.monthlyPrice, p.streetAddress, p.city, p.postalCode FROM unit u LEFT JOIN property p ON u.propertyId=p.id WHERE u.id != :id ORDER BY RAND() LIMIT 3;";
  $stmt = $pdo->prepare($query);
  $stmt->bindParam(":id", $id, PDO::PARAM_INT);
  $stmt->execute();
  return $stmt->fetchAll(PDO::FETCH_ASSOC);
}

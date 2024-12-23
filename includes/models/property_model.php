<?php

declare(strict_types=1);

function get_all_properties(object $pdo)
{
  $query = "SELECT u.id, p.name, u.description, CONCAT(p.type, ', ', u.type) AS type, u.numberOfRooms, u.monthlyPrice, p.streetAddress, p.city, p.postalCode FROM unit u LEFT JOIN property p ON u.propertyId=p.id;";
  $stmt = $pdo->query($query);
  return $stmt->fetchAll(PDO::FETCH_ASSOC);
}

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
              GROUP_CONCAT(DISTINCT CONCAT(unit_images.id, ':', unit_images.image)) AS images
            FROM 
              property
            INNER JOIN 
              unit ON property.id = unit.propertyId
            LEFT JOIN
              unit_facility ON unit.id = unit_facility.unitId
            LEFT JOIN
              unit_images ON unit.id = unit_images.unitId
            WHERE 
              unit.id = :unitId
            GROUP BY
              property.id, unit.id
            ORDER BY
              unit.id;";
  $stmt = $pdo->prepare($query);
  $stmt->bindParam(":unitId", $id, PDO::PARAM_INT);
  $stmt->execute();
  $rows = $stmt->fetchAll(PDO::FETCH_ASSOC);
  return $rows;
}

function get_all_facilities(object $pdo)
{
  $query = "SELECT * FROM facility";
  $stmt = $pdo->query($query);
  return $stmt->fetchAll(PDO::FETCH_ASSOC);
}
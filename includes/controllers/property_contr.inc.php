<?php

declare(strict_types=1);

function is_property_input_empty(string $name, string $description, string $type)
{
  return empty($name) || empty($description) || empty($type);
}

function is_unit_input_invalid(array $units)
{
  foreach ($units as $unit) {
    if (empty($unit['unit_type']) || $unit['numberOfRooms'] <= 1 || $unit['quantity'] <= 1 || $unit['monthlyPrice'] <= 1) {
      return true;
    }
  }
  return false;
}

function fetch_facilities(object $pdo)
{
  return fetch_all_facilities($pdo);
}

function create_property(object $pdo, int $userId, string $name, string $description, string $type, array $units)
{
  $pdo->beginTransaction();

  $propertyId = add_property($pdo, $userId, $name, $description, $type);

  foreach ($units as $unit) {
    $unit['numberOfRooms'] = (int) $unit['numberOfRooms'];
    $unit['quantity'] = (int) $unit['quantity'];
    $unit['monthlyPrice'] = (int) $unit['monthlyPrice'];

    $unitId = add_unit($pdo, $propertyId, $unit['unit_type'], $unit['numberOfRooms'], $unit['quantity'], $unit['monthlyPrice']);

    if (!empty($unit['facilities'])) {
      foreach ($unit['facilities'] as $facilityId) {
        $facilityId = (int) $facilityId;
        add_unit_facility($pdo, $unitId, $facilityId);
      }
    }
  }

  $pdo->commit();
}
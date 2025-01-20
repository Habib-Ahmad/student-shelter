<?php

declare(strict_types=1);

function get_landlord_reservations(object $pdo, int $landlordId)
{
  $stmt = $pdo->prepare(
    'SELECT reservation.id, reservation.startDate, reservation.endDate, reservation.status, reservation.created_at, users.firstName, users.lastName, users.email, users.phone
     FROM reservation
     JOIN unit ON reservation.unitId = unit.id
     JOIN property ON unit.propertyId = property.id
     JOIN users ON reservation.userId = users.id
     WHERE property.userId = ? 
     ORDER BY FIELD(reservation.status, "pending") DESC, reservation.created_at DESC;'
  );

  $stmt->execute([$landlordId]);
  return $stmt->fetchAll();
}

function update_reservation_status(object $pdo, int $reservationId, string $status)
{
  $allowedStatuses = ['pending', 'accepted', 'rejected', 'cancelled'];

  if (!in_array($status, $allowedStatuses)) {
    return false;
  }

  $stmt = $pdo->prepare('UPDATE reservation SET status = ? WHERE id = ?');
  return $stmt->execute([$status, $reservationId]);
}

function get_reservation_by_id(object $pdo, int $reservationId)
{
  $stmt = $pdo->prepare('SELECT * FROM reservation WHERE id = ?');
  $stmt->execute([$reservationId]);
  return $stmt->fetch();
}

function get_user_by_id(object $pdo, int $userId)
{
  $stmt = $pdo->prepare('SELECT * FROM users WHERE id = ?');
  $stmt->execute([$userId]);
  return $stmt->fetch();
}

function get_property_by_reservation_id(object $pdo, int $reservationId)
{
  $stmt = $pdo->prepare(
    'SELECT property.name
     FROM property
     JOIN unit ON property.id = unit.propertyId
     JOIN reservation ON unit.id = reservation.unitId
     WHERE reservation.id = ?'
  );

  $stmt->execute([$reservationId]);
  return $stmt->fetch();
}

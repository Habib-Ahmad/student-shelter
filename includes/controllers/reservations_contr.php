<?php

declare(strict_types=1);

function handleReservations($subpage, $action, $id)
{
  require_once 'includes/models/dbh.php';
  require_once 'includes/models/reservations_model.php';
  require_once 'includes/models/manage-reservations_model.php';

  switch ($subpage) {
    case 'cancel':
      if (!$id) {
        header('Location: /studentshelter/reservations?message=Missing+reservation+ID');
        die();
      }

      // Check current status before attempting to cancel
      $reservation = get_reservation_by_id($pdo, (int) $id);
      if ($reservation['status'] !== 'pending') {
        header('Location: /studentshelter/reservations?message=Only+pending+reservations+can+be+cancelled');
        die();
      }

      $success = update_reservation_status($pdo, (int) $id, 'cancelled');
      if ($success) {
        // send mail to user
        $user = get_user_by_id($pdo, $reservation['userId']);
        $property = get_property_by_reservation_id($pdo, (int) $id);
        $subject = 'Reservation Cancelled';
        $message = "Hello {$user['firstName']},<br><br>Your reservation for the property {$property['name']} has been cancelled. You can try again with another property.<br><br>Thank you!";
        send_email($user['email'], $subject, $message);
      }
      die();

    default:
      $userId = $_SESSION['user_id'];
      $reservations = get_user_reservations($pdo, $userId);
      require_once 'includes/views/reservations_view.php';
      break;
  }
}

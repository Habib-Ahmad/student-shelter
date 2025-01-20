<?php

declare(strict_types=1);

function handleManageReservations($subpage, $action, $id)
{
  require_once 'includes/models/dbh.php';
  require_once 'includes/models/manage-reservations_model.php';
  require_once 'functions/send_mail.php';

  switch ($subpage) {
    case 'accept':
      if (!$id) {
        header('Location: /studentshelter/manage-reservations?message=Missing+reservation+ID');
        die();
      }

      // Check current status before updating
      $reservation = get_reservation_by_id($pdo, (int) $id);
      if ($reservation['status'] !== 'pending') {
        header('Location: /studentshelter/manage-reservations?message=Reservation+no+longer+pending');
        die();
      }

      $success = update_reservation_status($pdo, (int) $id, 'accepted');
      if ($success) {
        // send mail to user
        $user = get_user_by_id($pdo, $reservation['userId']);
        $property = get_property_by_reservation_id($pdo, (int) $id);
        $subject = 'Reservation Accepted';
        $message = "Hello {$user['firstName']},<br><br>Your reservation for the property {$property['name']} has been accepted. You can now proceed with the payment.<br><br>Thank you!";
        send_email($user['email'], $subject, $message);

        header('Location: /studentshelter/manage-reservations?message=Reservation+confirmed+successfully');
      } else {
        header('Location: /studentshelter/manage-reservations?message=Failed+to+confirm+reservation');
      }
      die();

    case 'reject':
      if (!$id) {
        header('Location: /studentshelter/manage-reservations?message=Missing+reservation+ID');
        die();
      }

      // Check current status before updating
      $reservation = get_reservation_by_id($pdo, (int) $id);
      if ($reservation['status'] !== 'pending') {
        header('Location: /studentshelter/manage-reservations?message=Reservation+no+longer+pending');
        die();
      }

      $success = update_reservation_status($pdo, (int) $id, 'rejected');
      if ($success) {
        // send mail to user
        $user = get_user_by_id($pdo, $reservation['userId']);
        $property = get_property_by_reservation_id($pdo, (int) $id);
        $subject = 'Reservation Rejected';
        $message = "Hello {$user['firstName']},<br><br>Your reservation for the property {$property['name']} has been rejected. Please try again with another property.<br><br>Thank you!";
        send_email($user['email'], $subject, $message);

        header('Location: /studentshelter/manage-reservations?message=Reservation+rejected+successfully');
      } else {
        header('Location: /studentshelter/manage-reservations?message=Failed+to+reject+reservation');
      }
      die();

    default:
      $userId = $_SESSION['user_id'];
      render_manage_reservations_page($userId);
      break;
  }
}

function render_manage_reservations_page(int $userId)
{
  require 'includes/models/dbh.php';
  require_once 'includes/models/manage-reservations_model.php';
  require_once 'includes/views/manage-reservations_view.php';

  $reservations = get_landlord_reservations($pdo, $userId);

  render_reservation_table($reservations);
}

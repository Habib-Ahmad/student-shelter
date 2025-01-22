<?php

declare(strict_types=1);

function handlePropertyDetails($subpage = null, $action = null, $id = null)
{
  require_once 'includes/models/dbh.php';
  require_once 'includes/models/property_model.php';
  require_once 'includes/models/property-details_model.php';
  require_once 'includes/models/home_model.php';

  if (!$id) {
    die("Invalid property ID.");
  }

  switch ($subpage) {
    case 'make-booking':
      handle_create_reservation($pdo, $id);
      break;

    default:
      $property = get_property_details_by_id($pdo, $id);
      $facilities = get_all_facilities($pdo);
      $similarProperties = get_3_random_properties($pdo, $id);

      if (!$property) {
        die("Property not found.");
      }
      require_once 'includes/views/property-details_view.php';
  }
}

function handle_create_reservation(object $pdo, int $unitId)
{
  require_once 'includes/models/property-details_model.php';
  require_once 'functions/send_mail.php';

  if (!isset($_SESSION['user_id'])) {
    die("You must be logged in to make a reservation.");
  }

  $userId = $_SESSION['user_id'];
  $startDate = $_POST['check-in'];
  $endDate = $_POST['check-out'];

  if (!$startDate || !$endDate) {
    $_SESSION['error_booking'] = "Please select a check-in and check-out date.";
    header("Location: /studentshelter/property-details?id=$unitId");
    die();
  }

  // check if property is available
  $property = get_property_details_by_id($pdo, $unitId);
  if (!$property[0]['isAvailable']) {
    $_SESSION['error_booking'] = "This property is not available for booking.";
    header("Location: /studentshelter/property-details?id=$unitId");
    die();
  }

  // check if property is available for the selected dates
  $reservations = get_reservations_by_unit_id($pdo, $unitId);
  foreach ($reservations as $reservation) {
    if (
      ($startDate >= $reservation['startDate'] && $startDate <= $reservation['endDate']) ||
      ($endDate >= $reservation['startDate'] && $endDate <= $reservation['endDate'])
    ) {
      $_SESSION['error_booking'] = "This property is not available for booking on the selected dates.";
      header("Location: /studentshelter/property-details?id=$unitId");
      die();
    }
  }

  create_reservation($pdo, $unitId, $userId, $startDate, $endDate);
  header("Location: /studentshelter/property-details?id=$unitId&message=Request made successfully. Check your email for confirmation.");

  // Send confirmation emails
  $studentEmail = $_SESSION['user_email'];
  $landlordEmail = $property[0]['landlord_email'];
  $studentName = $_SESSION['user_firstName'];

  $studentSubject = "Booking Confirmation";
  $studentBody = "Dear $studentName,<br><br>Your booking request for the property <b>{$property[0]['property_name']}</b> has been received.<br>
                <b>Requested Check-in:</b> $startDate<br>
                <b>Requested Check-out:</b> $endDate<br><br>
                The landlord will review your request and notify you once it has been accepted or declined.<br>
                Thank you for choosing Student Shelter.";

  $landlordSubject = "New Booking Notification";
  $landlordBody = "Dear Landlord,<br><br>You have a new booking for your property <b>{$property[0]['property_name']}</b><br><br>
                     Please log in to your account for more details.";

  send_email($studentEmail, $studentSubject, $studentBody);
  send_email($landlordEmail, $landlordSubject, $landlordBody);

  die();
}

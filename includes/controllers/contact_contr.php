<?php

function handleContact()
{
  $messageSent = false;

  if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $name = filter_input(INPUT_POST, 'name', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
    $email = filter_input(INPUT_POST, 'email', FILTER_VALIDATE_EMAIL);
    $message = filter_input(INPUT_POST, 'message', FILTER_SANITIZE_FULL_SPECIAL_CHARS);

    if ($name && $email && $message) {
      // TODO: Send the email
      $messageSent = true; // Simulating successful submission
    }
  }

  require_once 'includes/views/contact_view.php';
}

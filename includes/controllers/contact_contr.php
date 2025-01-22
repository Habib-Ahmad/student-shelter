<?php

function handleContact()
{
  require_once 'functions/send_mail.php';

  $messageSent = false;

  if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $name = filter_input(INPUT_POST, 'name', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
    $email = filter_input(INPUT_POST, 'email', FILTER_VALIDATE_EMAIL);
    $message = filter_input(INPUT_POST, 'message', FILTER_SANITIZE_FULL_SPECIAL_CHARS);

    if ($name && $email && $message) {
      $subject = 'New Contact Form Submission';
      $message = "Name: $name<br><br>Email: $email<br><br>$message";
      $messageSent = send_email('', $subject, $message);

      if ($messageSent) {
        $name = $email = $message = '';

        header('Location: /studentshelter/contact?message=Message+sent+successfully');
        die();
      } else {
        header('Location: /studentshelter/contact?message=Failed+to+send+message');
        die();
      }
    }
  }

  require_once 'includes/views/contact_view.php';
}

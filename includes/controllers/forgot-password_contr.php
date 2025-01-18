<?php

function handleForgotPassword()
{
  if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    require_once "includes/models/dbh.php";
    require_once "includes/models/login_model.php";
    require_once "functions/send_mail.php";

    if (!isset($_POST['email'])) {
      header('Location: /studentshelter/forgot-password?message=Email+is+required');
      die();
    }

    $email = $_POST['email'];
    $user = get_user($pdo, $email);
    if (!$user) {
      header('Location: /studentshelter/forgot-password?message=No+user+found+with+this+email');
      die();
    }

    $token = bin2hex(random_bytes(32));
    $success = create_password_reset($pdo, $user['id'], $token);
    if ($success) {
      $subject = 'Password Reset';
      $message = "Hello {$user['firstName']},<br><br>You have requested to reset your password. Click the link below to reset it:<br><br><a href='http://localhost/studentshelter/reset-password?token={$token}'>Reset Password</a><br><br>If you did not request this, please ignore this email.<br><br>Thank you!";
      send_email($user['email'], $subject, $message);

      header('Location: /studentshelter/forgot-password?message=Password+reset+link+sent+to+your+email');
    } else {
      header('Location: /studentshelter/forgot-password?message=Failed+to+send+password+reset+link');
    }
    die();
  }

  render_forgot_password_page();
}

function render_forgot_password_page()
{
  require_once "includes/views/forgot-password_view.php";
  render_forgot_password_form();
}

<?php

function handleResetPassword()
{
  if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    require_once "includes/models/dbh.php";
    require_once "includes/models/login_model.php";
    require_once "functions/send_mail.php";

    if (!isset($_POST['password']) || !isset($_POST['confirm_password'])) {
      header('Location: /studentshelter/reset-password?message=Password+is+required');
      die();
    }

    $password = $_POST['password'];
    $confirm_password = $_POST['confirm_password'];
    $token = $_GET['token'];

    if ($password !== $confirm_password) {
      header('Location: /studentshelter/reset-password?token=' . $token . '&message=Passwords+do+not+match');
      die();
    }

    $reset = get_password_reset($pdo, $token);
    if (!$reset) {
      header('Location: /studentshelter/reset-password?message=Invalid+token');
      die();
    }

    $success = update_user_password($pdo, $reset['user_id'], $password);
    if ($success) {
      delete_password_reset($pdo, $token);
      header('Location: /studentshelter/login?message=Password+reset+successfully');
    } else {
      header('Location: /studentshelter/reset-password?token=' . $token . '&message=Failed+to+reset+password');
    }
    die();
  }

  render_reset_password_page();
}

function render_reset_password_page()
{
  require_once "includes/views/reset-password_view.php";
  render_reset_password_form();
}
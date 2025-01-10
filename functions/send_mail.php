<?php

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require_once 'vendor/src/PHPMailer.php';
require_once 'vendor/src/Exception.php';
require_once 'vendor/src/SMTP.php';
require_once 'functions/load_env.php';

load_env(__DIR__ . '/../.env');

function send_email(string $to, string $subject, string $body): bool
{
  $mail = new PHPMailer(true);

  try {
    // Server settings
    $mail->SMTPDebug = 2;
    $mail->isSMTP();
    $mail->Host = getenv('SMTP_HOST');
    $mail->SMTPAuth = true;
    $mail->Username = getenv('SMTP_USERNAME');
    $mail->Password = getenv('SMTP_PASSWORD');
    $mail->SMTPSecure = getenv('SMTP_SECURE');
    $mail->Port = getenv('SMTP_PORT');

    // Recipients
    $mail->setFrom(getenv('SMTP_USERNAME'), 'Student Shelter');
    // $mail->addAddress($to);
    $mail->addAddress('aaha63894@eleve.isep.fr');

    // Content
    $mail->isHTML(true);
    $mail->Subject = $subject;
    $mail->Body = $body;

    $mail->send();
    return true;
  } catch (Exception $e) {
    error_log("Mail Error: " . $mail->ErrorInfo);
    echo "Message could not be sent. Mailer Error: {$mail->ErrorInfo}";
    return false;
  }
}
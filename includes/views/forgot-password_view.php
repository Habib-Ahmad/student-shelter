<?php

declare(strict_types=1);

function render_forgot_password_form()
{
  ?>
  <!DOCTYPE html>
  <html lang="en">

  <head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="icon" type="image/png" href="/studentShelter/favicon.png">
    <link rel="stylesheet" type="text/css" href="css/login.css">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <title>Student Shelter</title>
  </head>

  <body>
    <div class="form-container">
      <a href="/studentshelter/"><img src="assets/S_logo.PNG" alt="Logo" class="logo" /></a>
      <h1>Forgot Password</h1>

      <p class="desc">Enter your email to receive a password reset link</p>

      <form action="/studentshelter/forgot-password" method="post">
        <div class="form-group">
          <label for="email">Email:</label>
          <input type="email" id="email" name="email" placeholder="Enter your email" required />
        </div>

        <button type="submit" class="btn">Send Reset Link</button>
      </form>
    </div>
  </body>

  <?php
  if (isset($_GET['message'])) {
    echo "<script>
        alert('{$_GET['message']}');
        const url = new URL(window.location.href);
        url.searchParams.delete('message');
        window.history.replaceState({}, document.title, url);
      </script>";
  }
  ?>

  </html>
  <?php
}

<?php

declare(strict_types=1);

function render_reset_password_form()
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
      <h1>Reset Password</h1>

      <form action="/studentshelter/reset-password?token=<?php echo $_GET['token'] ?? ''; ?>" method="post">
        <div class="form-group">
          <label for="password">Password:</label>
          <input type="password" id="password" name="password" placeholder="Enter your new password" required />
        </div>

        <div class="form-group">
          <label for="confirm_password">Confirm Password:</label>
          <input type="password" id="confirm_password" name="confirm_password" placeholder="Confirm your new password"
            required />
        </div>
        <button type="submit" class="btn">Reset Password</button>
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

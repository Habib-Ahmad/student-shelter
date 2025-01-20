<?php

function render_login_form($errors)
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
      <h1>Login</h1>

      <form action="/studentshelter/login" method="post">


        <!-- Email -->
        <div class="form-group">
          <label for="email">Email:</label>
          <input type="email" id="email" name="email" placeholder="Enter your email" required />
        </div>

        <!-- Password -->
        <div class="form-group password">
          <label for="password">Password:</label>
          <input type="password" id="password" name="password" placeholder="Enter your password" required />
          <a class="forgot-pwd" href="/studentshelter/forgot-password">Forgot password?</a>
        </div>


        <button type="submit" class="btn">Login</button>
        <?php if ($errors): ?>
          <div class="error-list">
            <?php foreach ($errors as $error): ?>
              <p><?php echo $error; ?></p>
            <?php endforeach; ?>
          </div>
        <?php endif; ?>
      </form>

      <p class="register">Don't have an account? <a href="/studentshelter/signup">Sign up</a></p>
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

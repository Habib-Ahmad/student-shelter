<?php require_once "../includes/config_session.inc.php" ?>
<?php require_once "../includes/views/login_view.inc.php" ?>
<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link rel="icon" type="image/png" href="/studentShelter/favicon.png">
  <link rel="stylesheet" href="../css/login.css">
  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
  <title>Student Shelter</title>
</head>

<body>
  <div class="form-container">
    <a href="/studentshelter/"><img src="../assets/S_logo.PNG" alt="Logo" class="logo" /></a>
    <h1>Login</h1>
    <form action="../includes/login.inc.php" method="post">
      <div class="form-group">
        <label for="email">Email:</label>
        <input type="email" id="email" name="email" placeholder="Enter Email" required>
      </div>

      <div class="form-group">
        <label for="password">Password:</label>
        <input type="password" id="password" name="password" placeholder="Enter Password" required>
      </div>
      <button type="submit">Login</button>
      <?php check_login_errors() ?>

      <p class="register">Don't have an account? <a href="../signup">Register</a></p>
    </form>
  </div>
</body>

</html>
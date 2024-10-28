<?php require_once '../partials/header.php'; ?>
<?php require_once "../includes/config_session.inc.php" ?>
<?php require_once "../includes/views/login_view.inc.php" ?>

<link rel="stylesheet" href="./login.css">

<h1>Login</h1>
<form action="../includes/login.inc.php" method="post">
  <label for="email">Email:</label>
  <input type="email" id="email" name="email">

  <label for="password">Password:</label>
  <input type="password" id="password" name="password">

  <button>Submit</button>
</form>

<?php check_login_errors() ?>

<?php require_once '../partials/footer.php'; ?>
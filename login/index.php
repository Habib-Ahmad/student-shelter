<?php require_once '../partials/header.php'; ?>
<?php require_once "../includes/config_session.inc.php" ?>
<?php require_once "../includes/views/login_view.inc.php" ?>

<div class="form-container">
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
  </form>
</div>

<?php check_login_errors() ?>

<?php require_once '../partials/footer.php'; ?>
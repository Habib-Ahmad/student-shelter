<?php require_once '../partials/header.php'; ?>
<?php require_once "../includes/config_session.inc.php" ?>
<?php require_once "../includes/views/signup_view.inc.php" ?>

<link rel="stylesheet" href="./signup.css">

<h1>Sign Up</h1>
<form action="../includes/signup.inc.php" method="post">
  <?php signup_inputs(); ?>
</form>

<?php check_signup_errors() ?>

<?php require_once '../partials/footer.php'; ?>
<?php require_once './partials/header.php'; ?>
<?php require_once "./includes/config_session.inc.php" ?>
<?php require_once "./includes/views/login_view.inc.php" ?>
<?php require_once "./includes/views/property_view.inc.php" ?>

<main>
  <h1>Welcome to Student Shelter!</h1>

  <?php if (isset($_SESSION["user_id"])): ?>
    <p>Welcome back, <?php output_fullname(); ?>!</p>

    <form action="./includes/logout.inc.php" method="post">
      <button>Logout</button>
    </form>
  <?php endif; ?>

  <?php list_all_properties(); ?>
</main>

<?php require_once 'partials/footer.php'; ?>
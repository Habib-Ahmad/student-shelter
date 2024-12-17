<?php require_once '../../partials/header.php'; ?>
<?php require_once "../../includes/config_session.inc.php" ?>
<?php require_once "../../includes/views/property_view.inc.php" ?>

<script>
  // Pass PHP facilities array to JavaScript
  const facilities = <?= json_encode($_SESSION["facilities"]); ?>;
</script>

<h1 class="page-heading">Add New Property</h1>

<form action="../../includes/add_property.inc.php" method="post" enctype="multipart/form-data">
  <?php add_property_inputs(); ?>

  <button type="button" onclick="addUnit()">Add Unit</button>
  <br />
  <br />
  <br />
  <button type="submit" name="submit">Create Property</button>
</form>

<script src="../script.js"></script>
<?php check_add_property_errors(); ?>

<?php require_once '../../partials/footer.php'; ?>
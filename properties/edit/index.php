<?php
require_once '../../partials/header.php';
require_once '../../includes/config_session.inc.php';
require_once "../../includes/views/property_view.inc.php"
  ?>

<script>
  // Pass PHP facilities array to JavaScript
  const facilities = <?= json_encode($_SESSION["facilities"]); ?>;
</script>

<h1 class="page-heading">Edit property</h1>

<form action="../../includes/edit_property.inc.php" method="post" enctype="multipart/form-data">
  <?php edit_property_inputs(); ?>

  <button type="button" class="page-end-button" onclick="addUnit()">Add Unit</button>
  <br />
  <button name="submit" class="page-end-button">Update Property</button>
</form>

<script src="../script.js"></script>

<?php require_once '../../partials/footer.php'; ?>
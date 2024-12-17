<?php
require_once '../partials/header.php';
require_once '../includes/views/admin_view.inc.php';
?>

<div class="container">
  <h2>Admin Panel</h2>

  <h3>Students</h3>
  <?php
  list_students();
  ?>
</div>


<script src="./admin.js"></script>

<?php
require_once '../partials/footer.php';
?>
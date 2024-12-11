<?php
require_once '../partials/header.php';
require_once '../includes/views/admin_view.inc.php';
?>

<div class="container">
  <h1>Admin</h1>
  <p>Welcome to the admin panel</p>

  <h2>Students</h2>
  <?php
  list_students();
  ?>
</div>


<script src="./admin.js"></script>

<?php
require_once '../partials/footer.php';
?>
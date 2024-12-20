<?php require_once '../includes/config_session.inc.php' ?>
<?php require_once "../includes/views/signup_view.inc.php" ?>
<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link rel="icon" type="image/png" href="/studentShelter/favicon.png">
  <link rel="stylesheet" href="../css/signup.css">
  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
  <title>Student Shelter</title>
</head>
<div>
  <form action="../includes/signup.inc.php" method="post" enctype="multipart/form-data">
    <?php signup_inputs(); ?>
  </form>
</div>

<script src="./script.js"></script>
<script>
  document.addEventListener('DOMContentLoaded', () => {
    setupRoleToggle();
  });
</script>
</body>

</html>
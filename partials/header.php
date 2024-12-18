<?php
require_once $_SERVER['DOCUMENT_ROOT'] . '/studentShelter/includes/config_session.inc.php';
require_once $_SERVER['DOCUMENT_ROOT'] . '/studentShelter/functions/get_css_file.php';
$css_file = get_css_file();
?>

<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link rel="stylesheet" href="/studentShelter/css/main.css">
  <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css" rel="stylesheet">
  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
  <link href="https://fonts.googleapis.com/css2?family=Cherry+Cream+Soda&display=swap" rel="stylesheet">
  <?php if ($css_file): ?>
    <link rel="stylesheet" href="<?php echo $css_file; ?>">
  <?php endif; ?>
  <title>Student Shelter</title>
</head>

<body>
  <!-- Beginning navbar section-->
<nav class="navbar">
    <div class="logo">
      <img src="<?php echo $_SERVER['DOCUMENT_ROOT'] ?>  '/assets/S_logo.PNG'?>" alt="Logo" />
    </div>
    <ul>
        <li><a href="/studentShelter">Home</a></li>
        <li><a href="/studentShelter/login">Login</a></li>
        <li><a href="/studentShelter/signup">Signup</a></li>
        <?php if (isset($_SESSION['user_role']) && $_SESSION['user_role'] === 'landlord'): ?>
          <li><a href="/studentShelter/properties">Properties</a></li>
        <?php endif; ?>
        <?php if (isset($_SESSION['user_role']) && $_SESSION['user_role'] === 'admin'): ?>
          <li><a href="/studentShelter/admin">Admin</a></li>
        <?php endif; ?>
      </ul>
    <div class="nav-actions">
      <a href="#rent" class="rent-button">Login</a>
    </div>
    <div class="hamburger-menu">
      <span></span>
      <span></span>
      <span></span>
    </div>
</nav>
<!-- End of  navbar section-->





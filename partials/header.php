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
  <link rel="icon" type="image/png" href="/studentShelter/favicon.png">
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
  <div class="project-wrapper">
    <!-- Beginning navbar section-->
    <header>
      <nav class="navbar">
        <div class="logo">
          <a href="/studentshelter">
            <img src="/studentshelter/assets/S_logo.PNG" alt="Logo" />
          </a>
        </div>
        <ul class="nav-links">
          <li><a href="/studentshelter">Home</a></li>
          <li><a href="/studentshelter/profile">Profile</a></li>
          <!-- <?php if (isset($_SESSION['user_role']) && $_SESSION['user_role'] === 'student'): ?>
            <li><a href="/studentshelter/profile">Profile</a></li>
            <?php endif; ?> -->
          <?php if (isset($_SESSION['user_role']) && $_SESSION['user_role'] === 'landlord'): ?>
            <li><a href="/studentShelter/properties">My Properties</a></li>
          <?php endif; ?>
          <?php if (isset($_SESSION['user_role']) && $_SESSION['user_role'] === 'admin'): ?>
            <li><a href="/studentShelter/admin">Admin</a></li>
          <?php endif; ?>
          <li><a href="/studentshelter/contact">Contact Us</a></li>
          <li><a href="/studentshelter/faq">FAQ</a></li>
        </ul>
        <div class="nav-actions">
          <a href="/studentshelter/login" class="rent-button">Login</a>
        </div>
        <div class="hamburger-menu">
          <span></span>
          <span></span>
          <span></span>
        </div>
      </nav>
    </header>
    <!-- End of  navbar section-->
    <div class="content-wrapper">
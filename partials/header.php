<?php
require_once $_SERVER['DOCUMENT_ROOT'] . '/studentShelter/includes/config_session.php';
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
          <li><a href="/studentshelter/about">About Us</a></li>
          <?php if (isset($_SESSION['user_role']) && $_SESSION['user_role'] === 'admin'): ?>
            <li><a href="/studentshelter/admin">Admin</a></li>
          <?php endif; ?>
          <li><a href="/studentshelter/faq">FAQ</a></li>
          <li><a href="/studentshelter/contact">Contact Us</a></li>
        </ul>

        <div class="nav-actions">
          <?php if (isset($_SESSION['user_id'])): ?>
            <!-- User is logged in -->
            <div class="user-dropdown">
              <!-- <img src="/studentShelter/uploads/profile_pictures/<?php echo $_SESSION['user_id']; ?>.jpg"
                alt="Profile Picture" class=""> -->
              <img src="https://encrypted-tbn0.gstatic.com/images?q=tbn:ANd9GcRDwmG52pVI5JZfn04j9gdtsd8pAGbqjjLswg&s"
                alt="Profile Picture" class="profile-picture">
              <span><?php echo htmlspecialchars($_SESSION['user_firstName']) . ' ' . htmlspecialchars($_SESSION['user_lastName']); ?></span>
              <div class="dropdown-menu">
                <a href="/studentshelter/profile">Profile</a>
                <a href="/studentshelter/favorites">Favorites</a>
                <?php
                if (isset($_SESSION['user_role']) && $_SESSION['user_role'] === 'student') {
                  echo '<a href="/studentshelter/reservations">My Reservations</a>';
                }
                if (isset($_SESSION['user_role']) && $_SESSION['user_role'] === 'landlord') {
                  echo '<a href="/studentshelter/manage-reservations">Manage Reservations</a>';
                }
                ?>
                <a href="/studentshelter/logout">Logout</a>
              </div>
            </div>
          <?php else: ?>
            <!-- User is not logged in -->
            <a href="/studentshelter/login" class="rent-button">Login</a>
          <?php endif; ?>
        </div>

        <div class="hamburger-menu">
          <span></span>
          <span></span>
          <span></span>
        </div>
      </nav>
    </header>
    <!-- End of  navbar section-->
    <div class="content-wrapper"></div>
    <script src="/studentshelter/js/main.js"></script>

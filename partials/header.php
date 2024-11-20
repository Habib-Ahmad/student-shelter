<?php
require_once $_SERVER['DOCUMENT_ROOT'] . '/studentshelter/functions/get_css_file.php';
$css_file = get_css_file();
?>

<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link rel="stylesheet" href="/studentshelter/css/main.css">
  <?php if ($css_file): ?>
    <link rel="stylesheet" href="<?php echo $css_file; ?>">
  <?php endif; ?>
  <title>Student Shelter</title>
</head>

<body>
  <header>
    <div>Logo</div>
    <nav>
      <ul>
        <li><a href="/studentshelter">Home</a></li>
        <li><a href="/studentshelter/login">Login</a></li>
        <li><a href="/studentshelter/signup">Signup</a></li>
        <li><a href="/studentshelter/properties">Properties</a></li>
      </ul>
    </nav>
  </header>
<?php
require_once '../partials/header.php';
require_once "../includes/views/property_view.inc.php";
?>

<h1>My Properties</h1>

<?php list_user_properties(); ?>

<a href="./add"><button>Add New</button></a>

<?php require_once '../partials/footer.php'; ?>
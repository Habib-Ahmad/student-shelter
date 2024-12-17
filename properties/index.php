<?php
require_once '../partials/header.php';
require_once "../includes/views/property_view.inc.php";
?>

<h1 class="page-heading">My Properties</h1>

<?php list_user_properties(); ?>

<a href="./add"><button class="page-end-button">Add New</button></a>

<script src="./script.js"></script>

<?php require_once '../partials/footer.php'; ?>
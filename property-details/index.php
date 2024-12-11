<?php
require_once '../partials/header.php';
require_once '../includes/config_session.inc.php';
require_once '../includes/views/property_view.inc.php';
?>

<h1>Property Details</h1>
<?php get_property_details(); ?>

<?php
require_once '../partials/footer.php';
?>
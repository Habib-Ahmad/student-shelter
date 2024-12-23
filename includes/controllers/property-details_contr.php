<?php

declare(strict_types=1);

function handlePropertyDetails($subpage = null, $action = null, $id = null)
{
  require_once 'includes/models/dbh.php';
  require_once 'includes/models/property_model.php';

  if (!$id) {
    die("Invalid property ID.");
  }

  $property = get_property_details_by_id($pdo, $id);
  $facilities = get_all_facilities($pdo);

  if (!$property) {
    die("Property not found.");
  }

  require_once 'includes/views/property-details_view.php';
}

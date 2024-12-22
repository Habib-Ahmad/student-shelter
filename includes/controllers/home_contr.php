<?php


function handleHome($subpage, $action, $id)
{
  require_once 'includes/models/dbh.php';
  require_once 'includes/models/property_model.inc.php';
  require_once 'includes/views/home_view.php';

  $properties = fetch_all_properties($pdo);
  render_home_page($properties);
}

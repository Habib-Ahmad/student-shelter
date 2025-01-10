<?php

function handleFavorites($subpage, $action, $id)
{
  require_once 'includes/models/dbh.php';
  require_once 'includes/models/property_model.php';
  require_once 'includes/views/favorites_view.php';

  $properties = get_all_properties($pdo);
  render_home_page($properties);
}
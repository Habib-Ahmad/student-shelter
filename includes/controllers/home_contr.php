<?php

declare(strict_types=1);

function handleHome($subpage, $action, $id)
{
  require_once 'includes/models/dbh.php';
  require_once 'includes/models/home_model.php';
  require_once 'includes/views/home_view.php';

  switch ($subpage) {
    case 'search':
      // handle_search($pdo);
      break;

    case 'add-to-favorites':
      handle_add_to_favorites($pdo, $id);
      break;

    default:
      $properties = get_all_properties($pdo);
      render_home_page($pdo, $properties);
      break;
  }
}

function handle_add_to_favorites(object $pdo, int $propertyId)
{
  require_once 'includes/models/home_model.php';

  if (!isset($_SESSION['user_id'])) {
    header("Location: /studentshelter/login");
    die();
  }

  $userId = $_SESSION['user_id'];
  $isFavorite = is_property_favorite($pdo, $userId, $propertyId);

  if ($isFavorite) {
    remove_from_favorites($pdo, $userId, $propertyId);
  } else {
    add_to_favorites($pdo, $userId, $propertyId);
  }

  // Add scroll parameter to the redirect URL if present
  $scroll = isset($_GET['scroll']) ? (int) $_GET['scroll'] : 0;
  header("Location: /studentshelter?scroll=$scroll");
  die();
}

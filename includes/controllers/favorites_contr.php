<?php

function handleFavorites($subpage, $action, $id)
{
  $userId = $_SESSION['user_id'];

  if (!isset($userId)) {
    header("Location: /studentshelter/login");
    die();
  }

  switch ($subpage) {
    case 'remove':
      handle_remove_favorite($id);
      break;
    default:
      handle_render_favorites($userId);
      break;
  }
}

function handle_remove_favorite($id)
{
  require_once 'includes/models/dbh.php';
  require_once 'includes/models/home_model.php';

  $userId = $_SESSION['user_id'];
  remove_from_favorites($pdo, $userId, $id);

  header("Location: /studentshelter/favorites");
  die();
}

function handle_render_favorites($userId)
{
  require_once 'includes/models/dbh.php';
  require_once 'includes/models/favorites_model.php';
  require_once 'includes/models/home_model.php';
  require_once 'includes/views/favorites_view.php';

  $favorites = get_user_favorites($pdo, $userId);
  render_favorites($pdo, $favorites);
}

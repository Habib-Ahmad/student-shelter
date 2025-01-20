<?php

function handleFavorites($subpage, $action, $id)
{
  // $userId = $_SESSION['user_id'];

  // if (!isset($userId)) {
  //   header("Location: /studentshelter/login");
  //   die();
  // }

  switch ($subpage) {
    case 'remove':
      handle_remove_favorite($id);
      break;
    default:
      handle_render_favorites(1);
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


  $favorites = [
    [
        "id" => 10,
        "monthlyPrice" => "861.00",
        "name" => "Abraham Mcdowell Lodges",
        "type" => "Multiple-bedrooms",
        "streetAddress" => "8 Rue Francis de Croisset",
        "city" => "Paris",
        "postalCode" => "75018",
        "unitId" => 4,
    ],
    [
        "id" => 11,
        "monthlyPrice" => "192.00",
        "name" => "Elton Walters",
        "type" => "Multiple-bedrooms",
        "streetAddress" => "Autem doloremque nos",
        "city" => "Enim esse est deseru",
        "postalCode" => "Quis aliquip officia",
        "unitId" => 20,
    ],
    [
        "id" => 12,
        "monthlyPrice" => "347.00",
        "name" => "Elton Walters",
        "type" => "Shared Room",
        "streetAddress" => "Autem doloremque nos",
        "city" => "Enim esse est deseru",
        "postalCode" => "Quis aliquip officia",
        "unitId" => 18,
    ],
];

  render_favorites($pdo, $favorites);
}

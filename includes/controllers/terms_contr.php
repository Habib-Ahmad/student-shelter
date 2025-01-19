<?php

function handleTerms($subpage, $action, $id)
{
  require_once 'includes/models/dbh.php';
  require_once 'includes/models/terms_model.php';

  switch ($subpage) {
    case 'add':
      if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        $title = $_POST['title'] ?? '';
        $description = $_POST['description'] ?? '';

        if ($title && $description) {
          add_term($pdo, $title, $description);
          header('Location: /studentshelter/terms');
          die();
        }
      }
      require_once 'includes/views/terms_view.php';
      render_terms_form();
      break;

    case 'edit':
      if ($id) {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
          $title = $_POST['title'] ?? '';
          $description = $_POST['description'] ?? '';

          if ($title && $description) {
            update_term($pdo, $id, $title, $description);
            header('Location: /studentshelter/terms');
            die();
          }
        }

        $term = get_term_by_id($pdo, $id);
        require_once 'includes/views/terms_view.php';
        render_terms_form($term);
      }
      break;

    case 'delete':
      if ($id) {
        delete_term($pdo, $id);
        header('Location: /studentshelter/terms');
        die();
      }
      break;

    default:
      $terms = get_terms($pdo);
      require_once 'includes/views/terms_view.php';
      render_terms($terms);
      break;
  }
}

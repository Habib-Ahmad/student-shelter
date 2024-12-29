<?php

function handleLegal($subpage, $action, $id)
{
  require_once 'includes/models/dbh.php';
  require_once 'includes/models/legal_model.php';

  switch ($subpage) {
    case 'add':
      if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        $title = $_POST['title'] ?? '';
        $description = $_POST['description'] ?? '';

        if ($title && $description) {
          add_legal_clause($pdo, $title, $description);
          header('Location: /studentshelter/legal');
          die();
        }
      }
      require_once 'includes/views/legal_view.php';
      render_legal_form();
      break;

    case 'edit':
      if ($id) {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
          $title = $_POST['title'] ?? '';
          $description = $_POST['description'] ?? '';

          if ($title && $description) {
            update_legal_clause($pdo, $id, $title, $description);
            header('Location: /studentshelter/legal');
            die();
          }
        }

        $legalClause = get_legal_clause_by_id($pdo, $id);
        require_once 'includes/views/legal_view.php';
        render_legal_form($legalClause);
      }
      break;

    case 'delete':
      if ($id) {
        delete_legal_clause($pdo, $id);
        header('Location: /studentshelter/legal');
        die();
      }
      break;

    default:
      $legalClauses = get_legal_clauses($pdo);
      require_once 'includes/views/legal_view.php';
      render_legal($legalClauses);
      break;
  }
}

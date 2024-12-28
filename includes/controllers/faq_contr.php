<?php

require_once 'includes/models/faq_model.php';
require_once 'includes/views/faq_view.php';

function handleFaq($subpage = null, $action = null, $id = null)
{
  require_once 'includes/models/dbh.php';

  switch ($subpage) {
    case 'add':
      if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        $title = $_POST['title'] ?? '';
        $description = $_POST['description'] ?? '';
        add_faq($pdo, $title, $description);
        header('Location: /studentshelter/faq');
        die();
      }
      break;

    case 'edit':
      if ($_SESSION['user_role'] === 'admin' && $id) {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
          $title = $_POST['title'] ?? '';
          $description = $_POST['description'] ?? '';
          update_faq($pdo, $id, $title, $description);
          header('Location: /studentshelter/faq');
          die();
        } else {
          $faq = get_faq_by_id($pdo, $id);
          render_faq_edit($faq);
          return;
        }
      }
      break;

    case 'delete':
      if ($_SESSION['user_role'] === 'admin' && $id && $_SERVER['REQUEST_METHOD'] === 'POST') {
        delete_faq($pdo, $id);
        header('Location: /studentshelter/faq');
        die();
      }
      break;

    default:
      $faqs = get_all_faqs($pdo);
      render_faq_list($faqs);
      break;
  }
}

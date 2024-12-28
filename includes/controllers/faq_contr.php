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
        addFaq($pdo, $title, $description);
        header('Location: /studentshelter/faq');
        die();
      }
      break;

    case 'edit':
      if ($_SESSION['user_role'] === 'admin' && $id) {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
          $title = $_POST['title'] ?? '';
          $description = $_POST['description'] ?? '';
          updateFaq($pdo, $id, $title, $description);
          header('Location: /studentshelter/faq');
          die();
        } else {
          $faq = getFaqById($pdo, $id);
          renderFaqEdit($faq);
          return;
        }
      }
      break;

    case 'delete':
      if ($_SESSION['user_role'] === 'admin' && $id && $_SERVER['REQUEST_METHOD'] === 'POST') {
        deleteFaq($pdo, $id);
        header('Location: /studentshelter/faq');
        die();
      }
      break;

    default:
      $faqs = getAllFaqs($pdo);
      renderFaqList($faqs);
      break;
  }
}

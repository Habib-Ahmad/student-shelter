<?php

declare(strict_types=1);

function handleAdmin($subpage, $action, $id)
{
  require_once 'includes/models/dbh.php';
  require_once 'includes/models/admin_model.php';

  if (!$id) {
    header('Location: /studentshelter/admin?error=Missing+student+ID');
    die();
  }

  switch ($subpage) {
    case 'verify':
      $success = update_student_status($pdo, (int) $id, 'verified');
      if ($success) {
        header('Location: /studentshelter/admin?message=Student+verified+successfully');
      } else {
        header('Location: /studentshelter/admin?error=Failed+to+verify+student');
      }
      die();

    case 'reject':
      $success = update_student_status($pdo, (int) $id, 'rejected');
      if ($success) {
        header('Location: /studentshelter/admin?message=Student+rejected+successfully');
      } else {
        header('Location: /studentshelter/admin?error=Failed+to+reject+student');
      }
      die();

    default:
      render_admin_page();
      break;
  }
}

function render_admin_page()
{
  require 'includes/models/dbh.php';
  require_once 'includes/models/admin_model.php';
  require_once 'includes/views/admin_view.php';

  $students = get_students($pdo);

  render_student_table($students);
}

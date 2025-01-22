<?php

declare(strict_types=1);

function handleLogout()
{
  require_once $_SERVER['DOCUMENT_ROOT'] . '/studentshelter/includes/config_session.php';

  session_unset();
  session_destroy();
  session_regenerate_id(true);
  header("Location: /studentshelter/");
  die();
}

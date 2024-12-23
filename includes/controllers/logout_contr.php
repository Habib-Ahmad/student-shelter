<?php

declare(strict_types=1);

function handleLogout()
{
  session_unset();
  session_destroy();
  session_regenerate_id(true);
  header("Location: /studentshelter/");
  die();
}

<?php

declare(strict_types=1);

function get_all_users(object $pdo)
{
  return get_students($pdo);
}

function verify_student(object $pdo, int $id)
{
  verify_user($pdo, $id);
}

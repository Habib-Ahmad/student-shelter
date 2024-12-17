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

function update_user_phone(object $pdo, int $id, string $phone)
{
  update_user($pdo, $id, $phone);
}

function is_phone_valid(string $phone)
{
  return preg_match("/^(?:\+33|0)[0-9]{9}$/", $phone);
}

function update_user_password(object $pdo, int $id, string $password)
{
  change_password($pdo, $id, $password);
}
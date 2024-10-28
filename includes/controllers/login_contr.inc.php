<?php

declare(strict_types=1);

function is_login_input_empty(string $email, string $password)
{
  return empty($email) || empty($password);
}

function is_email_wrong(bool|array $result)
{
  return !$result;
}

function is_password_wrong(string $pwd, $hashedPwd)
{
  return !password_verify($pwd, $hashedPwd);
}

<?php

declare(strict_types=1);

function is_input_empty(string $firstName, string $lastName, string $email, string $phone, string $password, string $confirmPassword, string $role)
{
  return empty($firstName) || empty($lastName) || empty($email) || empty($phone) || empty($password) || empty($confirmPassword) || empty($role);
}

function is_email_invalid(string $email)
{
  return !filter_var($email, FILTER_VALIDATE_EMAIL);
}

function is_email_registered(object $pdo, string $email)
{
  return get_email($pdo, $email);
}

function do_pwds_not_match(string $password, string $confirmPassword)
{
  return $password !== $confirmPassword;
}

function is_role_invalid(string $role)
{
  return $role !== "student" && $role !== "landlord";
}

function create_user(object $pdo, string $firstName, string $lastName, string $email, string $phone, string $password, string $role)
{
  set_user($pdo, $firstName, $lastName, $email, $phone, $password, $role);
}
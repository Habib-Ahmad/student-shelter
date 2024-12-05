<?php

declare(strict_types=1);

function output_fullname()
{
  if (isset($_SESSION["user_id"])) {
    $firstName = $_SESSION["user_firstName"];
    $lastName = $_SESSION["user_lastName"];
    echo "You are logged in as $firstName $lastName";
  }
}

function check_login_errors()
{

  if (isset($_SESSION["errors_login"])) {
    $errors = $_SESSION["errors_login"];

    echo "<br />";
    echo "<p class='error-msg'>{$errors[0]}</p>";

    unset($_SESSION["errors_login"]);
  }
}

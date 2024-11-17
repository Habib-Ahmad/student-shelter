<?php
function get_css_file()
{
  $current_page = basename(dirname($_SERVER['PHP_SELF']));
  $css_file = "";
  $BASEURL = "/studentshelter/css/";

  switch ($current_page) {
    case 'signup':
      $css_file = "{$BASEURL}signup.css";
      break;
    case 'login':
      $css_file = "{$BASEURL}login.css";
      break;
    case 'properties':
    case 'add':
      $css_file = "{$BASEURL}property.css";
      break;

    default:
      break;
  }

  return $css_file;
}
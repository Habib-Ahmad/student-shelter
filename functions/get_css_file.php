<?php
function get_css_file()
{
  $current_page = basename(dirname($_SERVER['PHP_SELF']));
  $css_file = "";
  $BASEURL = "/studentShelter/css/";

  switch ($current_page) {
    case 'studentShelter':
      $css_file = "{$BASEURL}main.css";
      break;
    case 'signup':
      $css_file = "{$BASEURL}signup.css";
      break;
    case 'login':
      $css_file = "{$BASEURL}login.css";
      break;
    case 'profile':
      $css_file = "{$BASEURL}profile.css";
      break;
    case 'properties':
    case 'add':
    case 'edit':
      $css_file = "{$BASEURL}property.css";
      break;
    case 'property-details':
      $css_file = "{$BASEURL}property-details.css";
      break;
    default:
      break;
  }

  return $css_file;
}
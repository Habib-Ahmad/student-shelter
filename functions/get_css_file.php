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
    case 'contact':
      $css_file = "{$BASEURL}contact.css";
      break;
    case 'faq':
      $css_file = "{$BASEURL}faq.css";
      break;
    case 'terms_conditions':
      $css_file = "{$BASEURL}terms_conditions.css";
      break;
    case 'legal':
      $css_file = "{$BASEURL}legal.css";
      break;
    case 'property-details':
      $css_file = "{$BASEURL}property-details.css";
      break;
    default:
      break;
  }

  return $css_file;
}

<?php
function get_css_file()
{
  $current_page = basename(parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH));
  $css_file = "";
  $BASEURL = "/studentshelter/css/";

  switch ($current_page) {
    case 'studentshelter':
      $css_file = "{$BASEURL}home.css";
      break;
    case 'about':
      $css_file = "{$BASEURL}about.css";
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
    case 'terms':
      $css_file = "{$BASEURL}terms.css";
      break;
    case 'legal':
      $css_file = "{$BASEURL}legal.css";
      break;
    case 'property-details':
      $css_file = "{$BASEURL}property-details.css";
      break;
    case 'admin':
      $css_file = "{$BASEURL}admin.css";
      break;
    case 'favorites':
      $css_file = "{$BASEURL}favorites.css";
      break;
    default:
      break;
  }

  return $css_file;
}

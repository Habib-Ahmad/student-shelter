<?php
function get_css_file()
{
  $url = $_SERVER['REQUEST_URI'];
  $current_page = parse_url(explode('/', $url)[2], PHP_URL_PATH);
  $css_file = "";
  $BASEURL = "/studentshelter/css/";

  switch ($current_page) {
    case 'studentshelter':
      $css_file = "{$BASEURL}home.css";
      break;
    case 'about':
      $css_file = "/studentShelter/css/about.css";
      break;
    case 'profile':
      $css_file = "/studentShelter/css/profile.css";
      break;
    case 'property-details':
      $css_file = "/studentShelter/css/property-details.css";
      break;
    case 'properties':
    case 'properties/edit':
    case 'properties/add':
      $css_file = "/studentShelter/css/property.css";
      break;
    case 'faq':
    case 'faq/edit':
      $css_file = "/studentShelter/css/faq.css";
      break;
    case 'contact':
      $css_file = "/studentShelter/css/contact.css";
      break;
    case 'terms':
    case 'terms/edit':
    case 'terms/add':
      $css_file = "/studentShelter/css/terms.css";
      break;
    case 'legal':
    case 'legal/edit':
    case 'legal/add':
      $css_file = "/studentShelter/css/legal.css";
      break;
    case 'favorites':
      $css_file = "/studentShelter/css/favorites.css";
      break;
    case 'admin':
      $css_file = "/studentShelter/css/admin.css";
      break;
    case 'manage-reservations':
    case 'reservations':
      $css_file = "/studentShelter/css/manage-reservations.css";
      break;
    default:
      break;
  }

  return $css_file;
}

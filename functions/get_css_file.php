<?php
function get_css_file()
{
  $current_page = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);

  // Remove '/studentshelter' from the path
  $relative_path = str_replace('/studentshelter', '', $current_page);

  // Split the remaining path into parts
  $path_parts = explode('/', trim($relative_path, '/'));

  // Get the first and second parts if they exist
  $page = $path_parts[0] ?? '';
  $subpage = $path_parts[1] ?? '';

  $concatenated = $page . ($subpage ? "/$subpage" : '');

  // Default CSS file
  $css_file = "/studentShelter/css/default.css";

  switch ($concatenated) {
    case '':
      $css_file = "/studentShelter/css/home.css";
      break;
    case 'about':
      $css_file = "/studentShelter/css/about.css";
      break;
    case 'profile':
      $css_file = "/studentShelter/css/profile.css";
      break;
    case 'property':
    case 'property/edit':
    case 'property/add':
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
    default:
      break;
  }

  return $css_file;
}
<?php
require_once 'includes/config_session.php';

$baseFolder = "/studentshelter/";

$requestUri = $_SERVER['REQUEST_URI'];
$request = str_replace($baseFolder, '', parse_url($requestUri, PHP_URL_PATH));
$request = trim($request, '/');

$parts = explode('/', $request);

$page = $parts[0] ? $parts[0] : 'home';
$id = null;

// Check for query string in the URL
if (isset($_GET['id'])) {
  $id = (int) $_GET['id']; // Safely cast to an integer
} else {
  // Fallback to extracting numeric values from the URI if not a query string
  foreach ($parts as $key => $part) {
    if (is_numeric($part)) {
      $id = (int) $part;
      unset($parts[$key]);
      break;
    }
  }
}

$subpage = $parts[1] ?? null;
$action = $parts[2] ?? null;

$controllerFile = "includes/controllers/{$page}_contr.php";

if (file_exists($controllerFile)) {
  require_once $controllerFile;

  $controllerFunction = "handle" . ucfirst(str_replace('-', '', $page));
  if (function_exists($controllerFunction)) {
    $controllerFunction($subpage, $action, $id);
  } else {
    die("Invalid request: Controller function '$controllerFunction' not found.");
  }
} else {
  die("Page not found.");
}

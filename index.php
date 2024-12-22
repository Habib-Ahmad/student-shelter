<?php
require_once 'includes/config_session.inc.php';

$baseFolder = "/studentshelter/";

$requestUri = $_SERVER['REQUEST_URI'];
$request = str_replace($baseFolder, '', $requestUri);
$request = trim($request, '/');

$parts = explode('/', $request);

$page = $parts[0] ? $parts[0] : 'home';

$subpage = null;
$action = null;
$id = null;

foreach ($parts as $key => $part) {
  if (is_numeric($part)) {
    $id = (int) $part;
    unset($parts[$key]);
    break;
  }
}

$subpage = $parts[1] ?? null;
$action = $parts[2] ?? null;

$controllerFile = "includes/controllers/{$page}_contr.php";

if (file_exists($controllerFile)) {
  require_once $controllerFile;


  $controllerFunction = "handle" . ucfirst($page);
  if (function_exists($controllerFunction)) {
    $controllerFunction($subpage, $action, $id);
  } else {
    die("Invalid request: Controller function '$controllerFunction' not found.");
  }
} else {
  die("Page not found.");
}

<?php

ini_set("session.use_only_cookies", 1);
ini_set("session.use_strict_mode", 1);

// Adjust secure flag based on environment (localhost usually uses HTTP)
$isSecure = isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on';

// Set cookie parameters
session_set_cookie_params([
  "lifetime" => 1800, // 30 minutes
  "domain" => "localhost",
  "path" => "/",
  "secure" => $isSecure, // Adjust based on HTTPS
  "httponly" => true, // Prevent JavaScript access
]);

session_start();

// Define regeneration interval (30 minutes)
$interval = 60 * 60;

if (!isset($_SESSION["last_regeneration"]) || (time() - $_SESSION["last_regeneration"] >= $interval)) {
  regenerate_session_id();
}

// Function to regenerate session ID
function regenerate_session_id()
{
  session_regenerate_id(true); // Securely regenerate session ID
  $_SESSION["last_regeneration"] = time();
}
?>
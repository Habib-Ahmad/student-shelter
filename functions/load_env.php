<?php

function load_env(string $filePath)
{
  if (!file_exists($filePath)) {
    throw new Exception(".env file not found at: $filePath");
  }

  $lines = file($filePath, FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES);
  foreach ($lines as $line) {
    if (strpos(trim($line), '#') === 0) {
      continue; // Skip comments
    }

    [$key, $value] = explode('=', $line, 2);
    putenv(trim($key) . '=' . trim($value));
  }
}

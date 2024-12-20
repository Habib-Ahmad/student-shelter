<?php

declare(strict_types=1);

require_once './dbh.inc.php';
require_once './models/users_model.inc.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
  header('Content-Type: application/json');
  $input = json_decode(file_get_contents('php://input'), true);

  if (!isset($input['action'], $input['id']) || !is_numeric($input['id'])) {
    echo json_encode(['success' => false, 'message' => 'Invalid input']);
    exit;
  }

  $action = $input['action'];
  $id = (int) $input['id'];

  try {
    if ($action === 'verify') {
      verify_user($pdo, $id);
      echo json_encode(['success' => true]);
    } elseif ($action === 'reject' && isset($input['reason'])) {
      $reason = $input['reason'];
      // reject_user($pdo, $id, $reason);
      echo json_encode(['success' => true]);
    } else {
      echo json_encode(['success' => false, 'message' => 'Invalid action or missing reason']);
    }
  } catch (Exception $e) {
    echo json_encode(['success' => false, 'message' => $e->getMessage()]);
  }
}
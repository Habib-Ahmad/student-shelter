<?php

declare(strict_types=1);

require_once 'includes/config_session.php';

function get_all_faqs(object $pdo)
{
  $stmt = $pdo->query("SELECT * FROM faq ORDER BY id ASC");
  return $stmt->fetchAll(PDO::FETCH_ASSOC);
}

function get_faq_by_id(object $pdo, int $id)
{
  $stmt = $pdo->prepare("SELECT * FROM faq WHERE id = ?");
  $stmt->execute([$id]);
  return $stmt->fetch(PDO::FETCH_ASSOC);
}

function add_faq(object $pdo, string $title, string $description)
{
  $stmt = $pdo->prepare("INSERT INTO faq (title, description) VALUES (?, ?)");
  $stmt->execute([$title, $description]);
}

function update_faq(object $pdo, int $id, string $title, string $description)
{
  $stmt = $pdo->prepare("UPDATE faq SET title = ?, description = ? WHERE id = ?");
  $stmt->execute([$title, $description, $id]);
}

function delete_faq(object $pdo, int $id)
{
  $stmt = $pdo->prepare("DELETE FROM faq WHERE id = ?");
  $stmt->execute([$id]);
}

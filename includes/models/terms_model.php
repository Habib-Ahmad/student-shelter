<?php

function get_terms(object $pdo)
{
  $query = "SELECT * FROM terms ORDER BY id ASC";
  $stmt = $pdo->prepare($query);
  $stmt->execute();

  return $stmt->fetchAll(PDO::FETCH_ASSOC);
}

function get_term_by_id(object $pdo, int $id)
{
  $query = "SELECT * FROM terms WHERE id = ?";
  $stmt = $pdo->prepare($query);
  $stmt->execute([$id]);

  return $stmt->fetch(PDO::FETCH_ASSOC);
}

function add_term(object $pdo, string $title, string $description)
{
  $query = "INSERT INTO terms (title, description) VALUES (?, ?)";
  $stmt = $pdo->prepare($query);
  $stmt->execute([$title, $description]);
}

function update_term(object $pdo, int $id, string $title, string $description)
{
  $query = "UPDATE terms SET title = ?, description = ? WHERE id = ?";
  $stmt = $pdo->prepare($query);
  $stmt->execute([$title, $description, $id]);
}

function delete_term(object $pdo, int $id)
{
  $query = "DELETE FROM terms WHERE id = ?";
  $stmt = $pdo->prepare($query);
  $stmt->execute([$id]);
}

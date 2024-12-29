<?php

function get_legal_clauses(object $pdo)
{
  $query = "SELECT * FROM legal ORDER BY id ASC";
  $stmt = $pdo->prepare($query);
  $stmt->execute();

  return $stmt->fetchAll(PDO::FETCH_ASSOC);
}

function get_legal_clause_by_id(object $pdo, int $id)
{
  $query = "SELECT * FROM legal WHERE id = ?";
  $stmt = $pdo->prepare($query);
  $stmt->execute([$id]);

  return $stmt->fetch(PDO::FETCH_ASSOC);
}

function add_legal_clause(object $pdo, string $title, string $description)
{
  $query = "INSERT INTO legal (title, description) VALUES (?, ?)";
  $stmt = $pdo->prepare($query);
  $stmt->execute([$title, $description]);
}

function update_legal_clause(object $pdo, int $id, string $title, string $description)
{
  $query = "UPDATE legal SET title = ?, description = ? WHERE id = ?";
  $stmt = $pdo->prepare($query);
  $stmt->execute([$title, $description, $id]);
}

function delete_legal_clause(object $pdo, int $id)
{
  $query = "DELETE FROM legal WHERE id = ?";
  $stmt = $pdo->prepare($query);
  $stmt->execute([$id]);
}

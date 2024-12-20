<?php

declare(strict_types=1);

function get_students(object $pdo)
{
  $sql = "SELECT 
      users.id AS id,
      firstName,
      lastName,
      email,
      status,
      users.created_at AS signupDate,
      GROUP_CONCAT(CONCAT(user_documents.name, ':', user_documents.document_path) SEPARATOR ', ') AS documents
    FROM 
      users
    LEFT JOIN 
      user_documents ON users.id = user_documents.userId
    WHERE 
      users.userRole = 'student'
    GROUP BY 
      users.id
    ORDER BY
      FIELD(status, 'pending', 'in review', 'verified'),
      signupDate ASC;";
  $stmt = $pdo->prepare($sql);
  $stmt->execute();
  return $stmt->fetchAll();
}

function verify_user(object $pdo, int $id)
{
  $query = "UPDATE users SET status = 'verified' WHERE id = :id";
  $stmt = $pdo->prepare($query);
  $stmt->bindParam(':id', $id, PDO::PARAM_INT);
  $stmt->execute();
}

function update_user(object $pdo, int $id, string $phone)
{
  $query = "UPDATE users SET phone = :phone WHERE id = :id";
  $stmt = $pdo->prepare($query);
  $stmt->bindParam(':id', $id, PDO::PARAM_INT);
  $stmt->bindParam(':phone', $phone, PDO::PARAM_STR);
  $stmt->execute();
}

function change_password(object $pdo, int $id, string $password)
{
  $query = "UPDATE users SET pwd = :password WHERE id = :id";
  $stmt = $pdo->prepare($query);
  $stmt->bindParam(':id', $id, PDO::PARAM_INT);
  $stmt->bindParam(':password', $password, PDO::PARAM_STR);
  $stmt->execute();
}

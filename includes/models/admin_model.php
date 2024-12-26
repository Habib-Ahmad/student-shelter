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

function update_student_status(object $pdo, int $id, string $status)
{
  $allowedStatuses = ['pending', 'in review', 'verified'];

  if (!in_array($status, $allowedStatuses, true)) {
    return false;
  }

  $query = "UPDATE users SET status = :status WHERE id = :id";
  $stmt = $pdo->prepare($query);
  $stmt->bindParam(':status', $status, PDO::PARAM_STR);
  $stmt->bindParam(':id', $id, PDO::PARAM_INT);
  $stmt->execute();

  return $stmt->rowCount() === 1;
}

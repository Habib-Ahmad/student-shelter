<?php

declare(strict_types=1);

function list_students()
{
  require_once '../includes/dbh.inc.php';
  require_once '../includes/models/users_model.inc.php';

  $students = get_students($pdo);

  if (count($students) === 0) {
    echo '<p>No students found</p>';
    return;
  } else {
    ?>
    <table>
      <thead>
        <tr>
          <th>First Name</th>
          <th>Last Name</th>
          <th>Email</th>
          <th>Status</th>
          <th>Signup Date</th>
          <th>Documents</th>
          <th>Actions</th>
        </tr>
      </thead>
      <tbody>
        <?php
        foreach ($students as $student) {
          ?>
          <tr>
            <td><?php echo $student['firstName']; ?></td>
            <td><?php echo $student['lastName']; ?></td>
            <td><?php echo $student['email']; ?></td>
            <td><?php echo $student['status']; ?></td>
            <td><?php echo $student['signupDate']; ?></td>
            <td><?php echo $student['documents']; ?></td>
            <td><button class="verify-btn" data-id="<?php echo $student['id']; ?>">Verify</button>
              <button class="reject-btn" data-id="<?php echo $student['id']; ?>">Reject</button>
            </td>
          </tr>
          <?php
        }
        ?>
      </tbody>
    </table>
    <?php
  }
}
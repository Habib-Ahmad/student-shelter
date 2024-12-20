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
    <table class="admin-table">
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
            <td>
              <?php
              if ($student['status'] === 'verified') {
                echo '<span style="color: green; font-weight: bold;">Verified</span>';
              } elseif ($student['status'] === 'in review') {
                echo '<span style="color: orange; font-weight: bold;">Waiting for Re-upload</span>';
              } elseif ($student['status'] === 'rejected') {
                echo '<span style="color: red; font-weight: bold;">Rejected</span>';
              } else {
                echo '<span style="color: orange; font-weight: bold;">' . htmlspecialchars($student['status']) . '</span>';
              }
              ?>
            </td>
            <td><?php echo $student['signupDate']; ?></td>
            <td>
              <?php
              if ($student['documents']) {
                $documents = explode(', ', $student['documents']);
                foreach ($documents as $document) {
                  list($name, $path) = explode(':', $document);
                  // Link directly to the file, assuming it is publicly accessible
                  echo '<a href="' . htmlspecialchars($path) . '" target="_blank">'
                    . htmlspecialchars($name) . '</a><br>';
                }
              } else {
                echo 'No documents';
              }
              ?>
            </td>
            <td>
              <?php
              if ($student['status'] === 'verified' || $student['status'] === 'rejected') {
                echo "N/A";
              } else {
                ?>
                <button class="verify-btn" data-id="<?php echo $student['id']; ?>">Verify</button>
                <button class="reject-btn" data-id="<?php echo $student['id']; ?>">Rework</button>
                <?php
              }
              ?>
          </tr>
          <?php
        }
        ?>
      </tbody>
    </table>
    <?php
  }
}
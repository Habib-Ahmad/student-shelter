<?php

declare(strict_types=1);

function render_student_table(array $students)
{
  require_once 'partials/header.php';

  if (count($students) === 0) {
    echo '<p>No students found</p>';
    return;
  } else {
    ?>
    <div class="container">
      <h2>Admin Panel</h2>

      <h3>Students</h3>

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
                    // Create an absolute path for the document
                    $absolutePath = "/studentshelter/uploads/" . ltrim($path, '/');
                    echo '<a href="' . htmlspecialchars($absolutePath) . '" target="_blank">'
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
                  <a href="/studentshelter/admin/verify?id=<?= $student['id'] ?>" class="verify-btn"
                    onclick="return confirm('Are you sure you want to verify this student?')">Verify</a>
                  <a href="/studentshelter/admin/reject?id=<?= $student['id'] ?>" class="reject-btn"
                    onclick="return confirm('Are you sure you want to reject this student?')">Reject</a>
                  <?php
                }
                ?>
              </td>
            </tr>
            <?php
          }
          ?>
        </tbody>
      </table>
    </div>

    <?php
    if (isset($_GET['message'])) {
      echo "<script>alert('{$_GET['message']}');</script>";
    }

    if (isset($_GET['error'])) {
      echo "<script>alert('{$_GET['error']}');</script>";
    }
  }
  require_once 'partials/footer.php';
}

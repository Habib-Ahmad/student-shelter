<?php

declare(strict_types=1);

function render_reservation_table(array $reservations)
{
  require_once 'partials/header.php';
  ?>
  <section class="reservations">
    <div class="container">
      <h1>Manage Reservations</h1>
      <p>
        Welcome to your reservations dashboard! Here, you can view all the reservation requests for your properties,
        including details about the student, property, start and end dates, and status. You can accept or reject
        reservations directly from here. If you have any questions or need assistance, feel free to contact us.
      </p>

      <div class="table-container">
        <?php if (empty($reservations)): ?>
          <p>You have no upcoming reservations at this time.</p>
        <?php else: ?>
          <table class="reservations-table">
            <thead>
              <tr>
                <th>Student Name</th>
                <th>Email</th>
                <th>Phone</th>
                <th>Start Date</th>
                <th>End Date</th>
                <th>Created At</th>
                <th>Status</th>
                <th>Actions</th>
              </tr>
            </thead>
            <tbody>
              <?php foreach ($reservations as $reservation): ?>
                <tr>
                  <td><?= htmlspecialchars($reservation['firstName']) . ' ' . htmlspecialchars($reservation['lastName']); ?>
                  </td>
                  <td><?= htmlspecialchars($reservation['email']); ?></td>
                  <td><?= htmlspecialchars($reservation['phone']); ?></td>
                  <td><?= htmlspecialchars($reservation['startDate']); ?></td>
                  <td><?= htmlspecialchars($reservation['endDate']); ?></td>
                  <td><?= htmlspecialchars($reservation['created_at']); ?></td>
                  <td><?php
                  if ($reservation['status'] === 'accepted') {
                    echo '<span style="color: green; font-weight: bold;">Accepted</span>';
                  } elseif ($reservation['status'] === 'cancelled') {
                    echo '<span style="color: maroon; font-weight: bold;">Cancelled</span>';
                  } elseif ($reservation['status'] === 'rejected') {
                    echo '<span style="color: red; font-weight: bold;">Rejected</span>';
                  } else {
                    echo '<span style="color: orange; font-weight: bold;">' . 'Pending' . '</span>';
                  }
                  ?>
                  </td>
                  <td>
                    <div class="actions">
                      <?php if ($reservation['status'] === 'pending'): ?>
                        <a href="manage-reservations/accept?id=<?= $reservation['id']; ?>"
                          onclick="return confirm('Are you sure you want to accept this request')" class="accept-btn">Accept</a>
                        <a href="manage-reservations/reject?id=<?= $reservation['id']; ?>"
                          onclick="return confirm('Are you sure you want to reject this request')" class="reject-btn">Reject</a>
                      <?php else: ?>
                        <span>N/A</span>
                      <?php endif; ?>
                    </div>
                  </td>
                </tr>
              <?php endforeach; ?>
            </tbody>
          </table>
        <?php endif; ?>
      </div>
    </div>
  </section>
  <?php
  if (isset($_GET['message'])) {
    echo "<script>
        alert('{$_GET['message']}');
        const url = new URL(window.location.href);
        url.searchParams.delete('message');
        window.history.replaceState({}, document.title, url);
      </script>";
  }
  require_once 'partials/footer.php';
}

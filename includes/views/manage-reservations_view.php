<?php

declare(strict_types=1);

function render_reservation_table(array $reservations)
{
  require_once 'partials/header.php';
  ?>
  <section class="reservations">
    <div class="container">
      <h1>My Reservations</h1>
      <p>
        Welcome to your reservations dashboard! Here, you can view all your upcoming reservations, including details about
        the property, start and end dates, and more. If you have any questions or need assistance, feel free to
        contact us.
      </p>
      <div class="reservations-list">
        <?php if (empty($reservations)): ?>
          <p>You have no upcoming reservations at this time.</p>
        <?php else: ?>
          <table>
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
                  <td><?= htmlspecialchars($reservation['status']); ?></td>
                  <td>
                    <?php if ($reservation['status'] === 'pending'): ?>
                      <a href="manage-reservations/accept?id=<?= $reservation['id']; ?>"
                        onclick="return confirm('Are you sure you want to accept this request')">Accept</a>
                      <a href="manage-reservations/reject?id=<?= $reservation['id']; ?>"
                        onclick="return confirm('Are you sure you want to reject this request')">Reject</a>
                    <?php else: ?>
                      <span>N/A</span>
                    <?php endif; ?>
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
  require_once 'partials/footer.php';
}

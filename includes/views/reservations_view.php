<?php require_once 'partials/header.php'; ?>

<section class="reservations">
  <div class="container">
    <h1>My Reservations</h1>
    <p>
      Welcome to your reservations dashboard! Here, you can view all your upcoming reservations, including details about
      the property, start and end dates, and more. If you have any questions or need assistance, feel free to
      contact us.
    </p>

    <div class="table-container">
      <?php if (empty($reservations)): ?>
        <p>You have no reservations.</p>
      <?php else: ?>
        <table class="reservations-table">
          <thead>
            <tr>
              <th>Property</th>
              <th>Start Date</th>
              <th>End Date</th>
              <th>Status</th>
              <th>Created At</th>
              <th>Actions</th>
            </tr>
          </thead>
          <tbody>
            <?php foreach ($reservations as $reservation): ?>
              <tr>
                <td>
                  <a href="/studentshelter/property-details?id=<?= $reservation['unitId']; ?>" class="property-link">
                    <?= $reservation['property']; ?>
                  </a>
                </td>
                <td><?= $reservation['startDate']; ?></td>
                <td><?= $reservation['endDate']; ?></td>
                <td><?= $reservation['created_at']; ?></td>
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

  <?php require_once 'partials/footer.php'; ?>
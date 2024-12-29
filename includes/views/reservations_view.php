<?php require_once 'partials/header.php'; ?>

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
        <p>You have no reservations.</p>
      <?php else: ?>
        <table>
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
                  <a href="/studentshelter/property-details?id=<?= $reservation['unitId']; ?>">
                    <?= $reservation['property']; ?>
                  </a>
                </td>
                <td><?= $reservation['startDate']; ?></td>
                <td><?= $reservation['endDate']; ?></td>
                <td><?= $reservation['created_at']; ?></td>
                <td><?= $reservation['status']; ?></td>
                <td>
                  <?php if ($reservation['status'] === 'pending'): ?>
                    <a href="/studentshelter/reservations/cancel?id=<?= $reservation['id']; ?>"
                      onclick="return confirm('Are you sure you want to cancel this request')">Cancel</a>
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

  <?php require_once 'partials/footer.php'; ?>
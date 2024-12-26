<?php require_once 'partials/header.php'; ?>

<div class="container">
  <div class="main-content">
    <div class="details">
      <div class="main-image">
        <img src="/studentshelter/assets/Picture1.png" alt="Room Image">
      </div>

      <div class="property-details">
        <h2 id="property-name"><?php echo htmlspecialchars($property[0]["property_name"]); ?></h2>
        <h2 id="property-price">$<?php echo htmlspecialchars($property[0]["monthlyPrice"]); ?>/month</h2>
      </div>

      <div class="property-description">
        <h2>Description</h2>
        <p>
          <?php echo htmlspecialchars($property[0]["unit_description"]); ?>
        </p>
      </div>

      <div class="facilities">
        <h3>Facilities</h3>
        <ul>
          <?php
          $facilityIds = explode(",", $property[0]["facility_ids"]);
          foreach ($facilities as $facility) {
            if (in_array($facility["id"], $facilityIds)) {
              echo "<li>" . htmlspecialchars($facility["name"]) . "</li>";
            }
          }
          ?>
        </ul>
      </div>

      <div class="landlord-rules">
        <h3>Landlord Rules</h3>
        <ul>
          <li>No Smoking</li>
          <li>Pets Not Allowed</li>
          <li>Overnight Guests Allowed</li>
        </ul>
      </div>

      <div class="availability">
        <h3>Availability</h3>
        <p>Available from: January 12, 2025</p>
        <p>Maximum stay: 12 months</p>
        <p>Calendar updated: Today</p>
      </div>
    </div>

    <div class="booking-request">
      <h3>Booking Request</h3>
      <label for="check-in">Check-in:</label>
      <input type="date" id="check-in">

      <label for="check-out">Check-out:</label>
      <input type="date" id="check-out">

      <?php if (isset($_SESSION['user_id'])) {
        if (isset($_SESSION['user_role']) && $_SESSION['user_role'] != 'student') {
          echo "<button disabled>Landlords cannot book</button>";
        } else {
          if (isset($_SESSION['user_status']) && $_SESSION['user_status'] === 'verified') {
            echo "<button onclick='makeBooking()'>Make Booking</button>";
          } else {
            echo "<button disabled>Awaiting Verfication</button>";
          }
        }
      } else {
        echo "<a href='../login'>Login</a>";
      }
      ?>

    </div>
  </div>

  <div class="similar-properties">
    <h2>Similar Properties</h2>
    <div class="cards">
      <div class="card">
        <img src="/studentshelter/assets/ss2.jpeg" alt="Property 1">
        <p>Room 7 in Casa Monteiro | $700/Month</p>
      </div>
      <div class="card">
        <img src="/studentshelter/assets/ss3.jpeg" alt="Property 2">
        <p>Room 8 in Casa Monteiro | $700/Month</p>
      </div>
      <div class="card">
        <img src="/studentshelter/assets/ss4.jpeg" alt="Property 3">
        <p>Room 9 in Casa Monteiro | $700/Month</p>
      </div>
      <div class="card">
        <img src="/studentshelter/assets/ss4.jpeg" alt="Property 3">
        <p>Room 9 in Casa Monteiro | $700/Month</p>
      </div>
    </div>
  </div>
</div>

<script src="/studentshelter/js/property-details.js"></script>

<?php require_once 'partials/footer.php'; ?>
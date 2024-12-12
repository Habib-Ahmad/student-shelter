<?php
require_once "../partials/header.php";
require_once "../includes/config_session.inc.php";
require_once "../includes/views/users_view.inc.php";
?>

<script src="./profile.js"></script>

<div class="horizontal-nav">
  <button onclick="scrollToSection('profile-edit')">Profile</button>
  <button onclick="scrollToSection('password')">Password</button>
  <button onclick="scrollToSection('my-documents')">Documents</button>
  <button onclick="scrollToSection('bookings')">Bookings</button>
  <button onclick="scrollToSection('favorites')">Favorites</button>
  <button onclick="scrollToSection('FAQ')">FAQ</button>
</div>

<section class="profile-edit">
  <div class="container">
    <h2 class="title">Profile</h2>
    <form action="../includes/update-user.inc.php" method="post">
      <div class="user-details">
        <div class="input-box">
          <label for="first-name" class="details">First name</label>
          <input id="first-name" type="text" placeholder="Enter your first name" name="firstName"
            value="<?php echo $_SESSION['user_firstName'] ?? ''; ?>" disabled />
        </div>
        <div class="input-box">
          <label for="last-name" class="details">Last name</label>
          <input id="last-name" type="text" placeholder="Enter your last name" name="lastName"
            value="<?php echo $_SESSION['user_lastName'] ?? ''; ?>" disabled />
        </div>
        <div class="input-box">
          <label for="email-id" class="details">E-mail</label>
          <input id="email-id" type="email" placeholder="Enter your email" name="email"
            value="<?php echo $_SESSION['user_email'] ?? ''; ?>" disabled />
        </div>
        <div class="input-box">
          <label for="phone-number" class="details">Phone number</label>
          <input id="phone-number" type="tel" placeholder="Enter your phone number" name="phone"
            value="<?php echo $_SESSION['user_phone'] ?? ''; ?>" />
        </div>
      </div>
      <div class="button">
        <button type="submit">Update</button>
      </div>

      <?php
      if (isset($_GET["error"]) && isset($_SESSION["errors_profile"])) {
        echo "<p class='error-message'>" . $_SESSION['errors_profile'][0] . "</p>";
      }
      ?>
    </form>
  </div>
</section>
<br>

<section id="password">
  <div class="container">
    <h2 class="title">Change Password</h2>
    <form action="#">
      <div class="user-details">
        <div class="input-box">
          <label for="old-password" class="details">Old password</label>
          <input id="old-password" type="password" placeholder="Enter your password" required />
        </div>
        <div class="input-box">
          <label for="new-password" class="details">New password</label>
          <input id="new-password" type="password" placeholder="Enter your password" required />
        </div>
        <div class="input-box">
          <label for="confirm-password" class="details">Confirm new password</label>
          <input id="confirm-password" type="password" placeholder="Confirm your password" required />
        </div>
      </div>
      <div class="button">
        <button type="submit">Update</button>
      </div>
    </form>
  </div>
</section>
<br>

<section id="my-documents">
  <div class="container">
    <h2 class="title">Documents</h2>
    <form>
      <div class="adding-documents">
        <div class="input-box">
          <label for="fileinput" class="details">Upload Documents</label>
          <input type="file" id="fileinput" multiple />
          <button type="button" onclick="uploadFiles()">Upload</button>
        </div>
        <div class="file-list">
          <h3>Uploaded Files</h3>
          <ul id="fileList">
            <!-- Uploaded files will be listed here -->
          </ul>
        </div>
      </div>
    </form>
  </div>
</section>
<br>
<section id="bookings">
  <div class="container">
    <h2 class="title">Previous Booking History</h2>
    <table class="booking-table">
      <thead>
        <tr>
          <th>S.No</th>
          <th>Booking Name</th>
          <th>Time Stayed</th>
          <th>Location</th>
        </tr>
      </thead>
      <tbody>
        <tr>
          <td>1</td>
          <td>Cozy Apartment</td>
          <td>3 Months</td>
          <td>Paris, France</td>
        </tr>
        <tr>
          <td>2</td>
          <td>Luxury Suite</td>
          <td>2 Weeks</td>
          <td>Nice, France</td>
        </tr>
        <tr>
          <td>3</td>
          <td>Budget Studio</td>
          <td>1 Month</td>
          <td>Lyon, France</td>
        </tr>
      </tbody>
    </table>
  </div>
</section>
<br>

<section id="favorites">
  <h2 class="title">FAVORITES</h2><br>
  <div class="container1">
    <!-- 3 Columns Section -->
    <div class="property_columns">
      <div class="property_column">
        <img src="./assets/image.jpg" alt="apart-1">
        <h3>Room 1</h3>
        <p>This is the description for the first item. It gives some insight into what this column is about.</p>
        <label class="like-button">
          <input type="checkbox" name="like-room-1">
          <span>FAV</span>
        </label>
      </div>

      <div class="property_column">
        <img src="./assets/image (1).jpg" alt="apart-2">
        <h3>Room 2</h3>
        <p>This is the description for the second item. It provides more detailed information.</p>
        <label class="like-button">
          <input type="checkbox" name="like-room-2">
          <span>FAV</span>
        </label>
      </div>

      <div class="property_column">
        <img src="./assets/image (2).jpg" alt="apart-3">
        <h3>Room 3</h3>
        <p>This is the description for the third item. It offers additional context.</p>
        <label class="like-button">
          <input type="checkbox" name="like-room-3">
          <span>FAV</span>
        </label>
      </div>
    </div>
    <!-- 3 Columns Section -->
    <div class="property_columns">
      <div class="property_column">
        <img src="./assets/image (3).jpg" alt="apart-1">
        <h3>Room 1</h3>
        <p>This is the description for the first item. It gives some insight into what this column is about.</p>
        <label class="like-button">
          <input type="checkbox" name="like-room-4">
          <span>FAV</span>
        </label>
      </div>

      <div class="property_column">
        <img src="./assets/image (4).jpg" alt="apart-2">
        <h3>Room 2</h3>
        <p>This is the description for the second item. It provides more detailed information.</p>
        <label class="like-button">
          <input type="checkbox" name="like-room-5">
          <span>FAV</span>
        </label>
      </div>

      <div class="property_column">
        <img src="./assets/image (5).jpg" alt="apart-3">
        <h3>Room 3</h3>
        <p>This is the description for the third item. It offers additional context.</p>
        <label class="like-button">
          <input type="checkbox" name="like-room-6">
          <span>FAV</span>
        </label>
      </div>
    </div>
  </div>
</section>

<?php require_once "../partials/footer.php"; ?>
<?php

declare(strict_types=1);

function signup_inputs()
{
  $firstName = $_SESSION["signup_data"]["firstName"] ?? '';
  $lastName = $_SESSION["signup_data"]["lastName"] ?? '';
  $email = $_SESSION["signup_data"]["email"] ?? '';
  $phone = $_SESSION["signup_data"]["phone"] ?? '';
  $role = $_SESSION["signup_data"]["role"] ?? 'student';
  ?>
  <div class="form-container">
    <a href="/studentshelter/"><img src="../assets/S_logo.PNG" alt="Logo" class="logo" /></a>

    <h1>Registration Form</h1>
    <form action="../includes/signup.inc.php" method="POST" enctype="multipart/form-data">
      <!-- First Name -->
      <div class="form-group">
        <label for="firstName">First Name:</label>
        <input type="text" id="firstName" name="firstName" placeholder="Enter your first Name" required
          value="<?php echo htmlspecialchars($firstName); ?>" />
      </div>

      <!-- Last Name -->
      <div class="form-group">
        <label for="lastName">Last Name:</label>
        <input type="text" id="lastName" name="lastName" placeholder="Enter your last Name" required
          value="<?php echo htmlspecialchars($lastName); ?>" />
      </div>

      <!-- Email -->
      <div class="form-group">
        <label for="email">Email:</label>
        <input type="email" id="email" name="email" placeholder="Enter your email" required
          value="<?php echo htmlspecialchars($email); ?>" />
      </div>

      <!-- Password -->
      <div class="form-group">
        <label for="password">Password:</label>
        <input type="password" id="password" name="password" placeholder="*********" required />
      </div>

      <!-- Confirm Password -->
      <div class="form-group">
        <label for="confirmPassword">Confirm Password:</label>
        <input type="password" id="confirmPassword" name="confirmPassword" placeholder="*********" required />
      </div>

      <!-- Phone -->
      <div class="form-group">
        <label for="phone">Phone:</label>
        <input type="tel" id="phone" name="phone" placeholder="Enter your mobile number" required
          value="<?php echo htmlspecialchars($phone); ?>" />
      </div>

      <!-- Role Selection -->
      <div>
        Register as:
        <label>
          <input type="radio" name="role" value="student" <?php echo ($role === 'student') ? 'checked' : ''; ?> required
            onclick="toggleUploadSections()" />
          Student
        </label>
        <label>
          <input type="radio" name="role" value="landlord" <?php echo ($role === 'landlord') ? 'checked' : ''; ?> required
            onclick="toggleUploadSections()" />
          Landlord
        </label>
      </div>

      <!-- File Uploads for Students -->
      <div class="form-group">
        <label class="form-label">Valid ID:</label>
        <div class="file-input-wrapper">
          <label for="validId" class="file-upload-label">Choose file</label>
          <input type="file" id="validId" name="validId" class="file-upload-input" required>
          <span id="fileName2" class="file-name">No file chosen</span>
        </div>
      </div>

      <div id="studentUploadSections">
        <div class="form-group">
          <label class="form-label">Student Proof:</label>
          <div class="file-input-wrapper">
            <label for="studentProof" class="file-upload-label">Choose file</label>
            <input type="file" id="studentProof" name="studentProof" class="file-upload-input" required>
            <span id="fileName1" class="file-name">No file chosen</span>
          </div>
        </div>
      </div>

      <button type="submit" class="btn-register">Register</button>
      <?php check_signup_errors(); ?>
    </form>

    <div class="form-footer">
      <p>Already registered? <a href="/studentshelter/login">Login here</a></p>
    </div>
  </div>
  <?php
}

function check_signup_errors()
{

  if (isset($_SESSION["errors_signup"])) {
    $errors = $_SESSION["errors_signup"];

    echo "<br />";
    echo "<p class='error-msg'>{$errors[0]}</p>";

    unset($_SESSION["errors_signup"]);
  }
}

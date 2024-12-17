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

    <img src="../assets/S_logo.png" alt="Logo" class="form-logo">

    <h1>Registration Form</h1>
    <form action="/submit" method="POST">
      <div class="form-group">
        <label for="firstName">First Name:</label>
        <input
          type="text"
          id="firstName"
          name="firstName"
          placeholder="Enter your first Name"
          required
          value="<?php echo htmlspecialchars($firstName); ?>" />
      </div>

      <div class="form-group">
        <label for="last Name">Last Name:</label>
        <input
          type="text"
          id="last Name"
          name="last Name"
          placeholder="Enter your last Name"
          required
          value="<?php echo htmlspecialchars($lastName); ?>" />
      </div>

      <div class="form-group">
        <label for="email">Email:</label>
        <input
          type="email"
          id="email"
          name="email"
          placeholder="Enter your email"
          required
          value="<?php echo htmlspecialchars($email); ?>" />
      </div>
      <div class="form-group">
        <label for="password">Password:</label>
        <input
          type="password"
          id="password"
          name="password"
          placeholder="*********"
          required />
      </div>

      <div class="form-group">
        <label for="confirmpassword">Confirm Password:</label>
        <div class="input-container">
          <input
            type="password"
            id="password"
            name="Confirmpassword"
            placeholder="*********"
            required />
          <i class="bx bxs-lock-alt"></i>
        </div>
      </div>

      <div class="form-group">
        <label for="phone">Phone:</label>
        <div class="input-container">
          <input
            type="tel"
            id="phone"
            name="phone"
            placeholder="Enter your mobile number"
            pattern="[+]{1}[0-9]{1,14}"
            required
            value="<?php echo htmlspecialchars($phone); ?>" />
        </div>
        <br />
        <div>
          Register as:
          <label>
            <input type="radio" name="role" value="student" <?php echo ($role === 'student') ? 'checked' : ''; ?> required />
            Student
          </label>
          <label>
            <input type="radio" name="role" value="landlord" <?php echo ($role === 'landlord') ? 'checked' : ''; ?> required />
            Landlord
          </label>
        </div>
        </br>


        <div class="form-group">
          <label class="form-label">StudentProof:</label>
          <div class="file-input-wrapper">
            <label for="fileInput" class="file-upload-label">Choose file</label>
            <input type="file" id="fileInput" class="file-upload-input" required>
            <span id="fileName" class="file-name">No file chosen</span>
          </div>
        </div>

        <div class="form-group">
          <label class="form-label">Valid Proof:</label>
          <div class="file-input-wrapper">
            <label for="fileInput" class="file-upload-label">Choose file</label>
            <input type="file" id="fileInput" class="file-upload-input" required>
            <span id="fileName" class="file-name">No file chosen</span>
          </div>
        </div>


        <button type="submit" class="btn-register">Register</button>
    </form>
    <div class="form-footer">
      <p>Already registered? <a href="login.html">Login here</a></p>
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

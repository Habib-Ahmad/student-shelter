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

  <label for="firstName">First Name:</label>
  <input type="text" id="firstName" name="firstName" value="<?php echo htmlspecialchars($firstName); ?>">

  <label for="lastName">Last Name:</label>
  <input type="text" id="lastName" name="lastName" value="<?php echo htmlspecialchars($lastName); ?>">

  <label for="email">Email:</label>
  <input type="email" id="email" name="email" value="<?php echo htmlspecialchars($email); ?>">

  <label for="password">Password:</label>
  <input type="password" id="password" name="password"> <!-- No value for security reasons -->

  <label for="confirmPassword">Confirm Password:</label>
  <input type="password" id="confirmPassword" name="confirmPassword"> <!-- No value for security reasons -->

  <label for="phone">Phone:</label>
  <input type="tel" id="phone" name="phone" value="<?php echo htmlspecialchars($phone); ?>">

  <label>Role:</label>
  <div class="role">
    <input type="radio" id="student" name="role" value="student" <?php echo ($role === 'student') ? 'checked' : ''; ?>>
    <label for="student">Student</label>

    <input type="radio" id="landlord" name="role" value="landlord" <?php echo ($role === 'landlord') ? 'checked' : ''; ?>>
    <label for="landlord">Landlord</label>
  </div>

  <div id="student-documents">
    <label for="validId">Valid ID:</label>
    <input type="file" id="validId" name="validId" accept=".pdf,.jpg,.jpeg,.png" required>

    <label for="studentProof">Proof of Student:</label>
    <input type="file" id="studentProof" name="studentProof" accept=".pdf,.jpg,.jpeg,.png" required>
  </div>

  <button>Submit</button>
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
<?php

function render_signup_form($errors, $formData)
{
  $firstName = $formData['firstName'] ?? '';
  $lastName = $formData['lastName'] ?? '';
  $phone = $formData['phone'] ?? '';
  $email = $formData['email'] ?? '';
  $role = $formData['role'] ?? 'student';
  ?>

  <!DOCTYPE html>
  <html lang="en">

  <head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="icon" type="image/png" href="/studentShelter/favicon.png">
    <link rel="stylesheet" href="css/signup.css">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <title>Student Shelter</title>
  </head>

  <body>
    <div class="form-container">
      <a href="/studentshelter/"><img src="assets/S_logo.PNG" alt="Logo" class="logo" /></a>
      <h1>Sign Up</h1>

      <form action="/studentshelter/signup" method="post" enctype="multipart/form-data">

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
        <div class="form-group">
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
        <div id="studentUploadSections">
          <div class="form-group">
            <label class="form-label">Valid ID:</label>
            <div class="file-input-wrapper">
              <label for="validId" class="file-upload-label">Choose file</label>
              <input type="file" id="validId" name="validId" class="file-upload-input">
              <span id="fileName2" class="file-name">No file chosen</span>
            </div>
          </div>

          <div class="form-group">
            <label class="form-label">Student Proof:</label>
            <div class="file-input-wrapper">
              <label for="studentProof" class="file-upload-label">Choose file</label>
              <input type="file" id="studentProof" name="studentProof" class="file-upload-input">
              <span id="fileName1" class="file-name">No file chosen</span>
            </div>
          </div>
        </div>

        <button type="submit" class="btn-register">Register</button>
        <?php if ($errors): ?>
          <ul class="error-list">
            <?php foreach ($errors as $error): ?>
              <li><?= htmlspecialchars($error) ?></li>
            <?php endforeach; ?>
          </ul>
        <?php endif; ?>
      </form>

      <div class="form-footer">
        <p>Already registered? <a href="/studentshelter/login">Login</a></p>
      </div>
    </div>

    <script src="/studentshelter/js/signup.js"></script>
  </body>

  </html>
  <?php
}

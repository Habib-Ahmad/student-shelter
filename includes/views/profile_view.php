<?php

declare(strict_types=1);

function render_profile_form()
{
  require_once 'partials/header.php';

  $id = $_SESSION['user_id'] ?? '';
  $role = $_SESSION['user_role'] ?? '';
  $status = $_SESSION['user_status'] ?? '';

  ?>
  <section class="profile">
    <div class="container">
      <h2 class="title">Profile</h2>
      <form action="/studentshelter/profile?id=<?= $id ?>" method="post">
        <div class="user-details">
          <div class="input-box">
            <img
              src="https://png.pngtree.com/png-vector/20220709/ourmid/pngtree-businessman-user-avatar-wearing-suit-with-red-tie-png-image_5809521.png"
              alt="profile" class="profile-image" />
          </div>

          <div class="input-box">
            <label for="first-name" class="details">First name</label>
            <input id="first-name" type="text" placeholder="Enter your first name" name="firstName"
              value="<?php echo $_SESSION['user_firstName'] ?? ''; ?>" <?php echo $role === 'student' ? 'disabled' : ''; ?> />
          </div>
          <div class="input-box">
            <label for="last-name" class="details">Last name</label>
            <input id="last-name" type="text" placeholder="Enter your last name" name="lastName"
              value="<?php echo $_SESSION['user_lastName'] ?? ''; ?>" <?php echo $role === 'student' ? 'disabled' : ''; ?> />
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
        if (isset($_SESSION["errors_profile"])) {
          echo "<p class='error-message'>" . $_SESSION['errors_profile'][0] . "</p>";
        }
        ?>
      </form>
    </div>

    <div>
      <div id="password">
        <div class="container">
          <h2 class="title">Change Password</h2>
          <form action="/studentshelter/profile/password?id=<?= $id ?>" method="post" autocomplete="off">
            <div class="user-details">
              <div class="input-box">
                <label for="old-password" class="details">Old password</label>
                <input id="old-password" type="password" placeholder="Enter your password" name="oldPassword" />
              </div>
              <div class="input-box">
                <label for="new-password" class="details">New password</label>
                <input id="new-password" type="password" placeholder="Enter your password" name="newPassword" />
              </div>
              <div class="input-box">
                <label for="confirm-password" class="details">Confirm new password</label>
                <input id="confirm-password" type="password" placeholder="Confirm your password" name="confirmPassword" />
              </div>
            </div>
            <div class="button">
              <button type="submit">Update</button>
            </div>
            <?php
            if (isset($_SESSION["errors_pwd"])) {
              echo "<p class='error-message'>" . $_SESSION['errors_pwd'][0] . "</p>";
            }
            ?>
          </form>
        </div>
      </div>
      <br />
      <br />

      <?php if ($role === 'student' && $status === 'pending'): ?>
        <div id="my-documents">
          <div class="container">
            <h2 class="title">Upload Documents</h2>
            <form action="/studentshelter/profile/documents?id=<?= $id ?>" method="post" enctype="multipart/form-data">
              <div id="studentUploadSections">
                <div class="form-group">
                  <label class="form-label">Valid ID:</label>
                  <div class="file-input-wrapper">
                    <label for="validId" class="file-upload-label">Choose file</label>
                    <input type="file" id="validId" name="validId" class="file-upload-input">
                    <span id="fileName2" class="file-name">No file chosen</span>
                  </div>
                </div>
                <br />

                <div class="form-group">
                  <label class="form-label">Student Proof:</label>
                  <div class="file-input-wrapper">
                    <label for="studentProof" class="file-upload-label">Choose file</label>
                    <input type="file" id="studentProof" name="studentProof" class="file-upload-input">
                    <span id="fileName1" class="file-name">No file chosen</span>
                  </div>
                </div>
              </div>
              <div class="button">
                <button type="submit">Upload</button>
              </div>
              <?php
              if (isset($_SESSION["errors_docs"])) {
                echo "<p class='error-message'>" . $_SESSION['errors_docs'][0] . "</p>";
              }
              ?>
            </form>
          </div>
        </div>
      <?php endif; ?>
    </div>
  </section>
  <script src="/studentshelter/js/profile.js"></script>
  <?php

  require_once 'partials/footer.php';
}

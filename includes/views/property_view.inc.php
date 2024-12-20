<?php

declare(strict_types=1);

function check_add_property_errors()
{
  if (isset($_SESSION["errors_property"])) {
    $errors = $_SESSION["errors_property"];

    echo "<br />";
    echo "<p class='error-msg'>{$errors[0]}</p>";

    unset($_SESSION["errors_property"]);
  }
}

function add_property_inputs()
{
  require_once "../../includes/dbh.inc.php";
  require_once "../../includes/config_session.inc.php";
  require_once "../../includes/models/property_model.inc.php";
  require_once "../../includes/controllers/property_contr.inc.php";

  $name = $_SESSION["property_data"]["name"] ?? '';
  $description = $_SESSION["property_data"]["description"] ?? '';
  $type = $_SESSION["property_data"]["type"] ?? '';
  $streetAddress = $_SESSION["property_data"]["streetAddress"] ?? '';
  $city = $_SESSION["property_data"]["city"] ?? '';
  $postalCode = $_SESSION["property_data"]["postalCode"] ?? '';
  $units = $_SESSION["property_data"]["units"] ?? [
    [
      'unit_type' => '',
      'numberOfRooms' => '',
      'quantity' => '',
      'monthlyPrice' => '',
      'facilities' => []
    ]
  ];

  if (!isset($_SESSION["facilities"])) {
    $_SESSION["facilities"] = fetch_facilities($pdo);
  }
  $facilities = $_SESSION["facilities"];
  ?>

  <div class="property-form">
    <h3 class="form-selection-title">Property Information</h3>

    <label for="name" class="form-label">Property Name:</label>
    <input type="text" id="name" name="name" class="form-input" value="<?php echo htmlspecialchars($name) ?>">

    <label for="description" class="form-label">Description:</label>
    <textarea id="description" name="description"
      class="form-input"><?php echo htmlspecialchars($description); ?></textarea>

    <label for="type" class="form-label">Property Type:</label>
    <select id="type" name="type" class="form-input">
      <option value="" disabled <?php echo $type === '' ? 'selected' : ''; ?>>Select Property Type</option>
      <option value="Apartment" <?php echo $type === 'Apartment' ? 'selected' : ''; ?>>Apartment</option>
      <option value="Hostel" <?php echo $type === 'Hostel' ? 'selected' : ''; ?>>Hostel</option>
      <option value="Shared House" <?php echo $type === 'Shared House' ? 'selected' : ''; ?>>Shared House</option>
    </select>



    <label for="streetAddress" class="form-label">Street Address:</label>
    <input type="text" id="streetAddress" name="streetAddress" class="form-input"
      value="<?php echo htmlspecialchars($streetAddress) ?>">

    <label for="city" class="form-label">City:</label>
    <input type="text" id="city" name="city" class="form-input" value="<?php echo htmlspecialchars($city) ?>">

    <label for="postalCode" class="form-label">Postal Code:</label>
    <input type="text" id="postalCode" name="postalCode" class="form-input"
      value="<?php echo htmlspecialchars($postalCode) ?>">
    <br>
    <br>
    <br>
    <br>


    <h3 class="form-selection-title">Units</h3>
    <div id="units" class="units-container">
      <?php foreach ($units as $index => $unit): ?>
        <div class="unit-block" id="unit_<?php echo $index; ?>">
          <h4>Unit <?php echo $index + 1; ?></h4>
          <label for="description_<?php echo $index; ?>" class="form-label">Description:</label>
          <textarea id="description_<?php echo $index; ?>" class="form-input"
            name="units[<?php echo $index; ?>][description]"><?php echo htmlspecialchars($unit['description'] ?? ''); ?></textarea>

          <label for="unit_type_<?php echo $index; ?>" class="form-label">Unit Type:</label>
          <select type="text" id="unit_type_<?php echo $index; ?>" name="units[<?php echo $index; ?>][unit_type]"
            class="form-input">
            <option value="" disabled <?php echo $unit['unit_type'] === '' ? 'selected' : ''; ?>>Select Unit Type</option>
            <option value="Studio" <?php echo $unit['unit_type'] === 'Studio' ? 'selected' : ''; ?>>Studio</option>
            <option value="Single Room" <?php echo $unit['unit_type'] === 'Single Room' ? 'selected' : ''; ?>>Single Room
            </option>
            <option value="Shared Room" <?php echo $unit['unit_type'] === 'Shared Room' ? 'selected' : ''; ?>>Shared Room
            </option>
            <option value="Multiple-bedrooms" <?php echo $unit['unit_type'] === 'Multiple-bedrooms' ? 'selected' : ''; ?>>
              Multiple-bedrooms</option>
            <option value="Self-contained Unit" <?php echo $unit['unit_type'] === 'Self-contained Unit' ? 'selected' : ''; ?>>
              Self-contained Unit</option>
          </select>

          <label for="numberOfRooms_<?php echo $index; ?>" class="form-label">Number of Rooms:</label>
          <input type="number" id="numberOfRooms_<?php echo $index; ?>" name="units[<?php echo $index; ?>][numberOfRooms]"
            class="form-input" value="<?php echo htmlspecialchars((string) $unit['numberOfRooms'] ?? '') ?>" min="1">

          <label for="quantity_<?php echo $index; ?>" class="form-label">Quantity:</label>
          <input type="number" id="quantity_<?php echo $index; ?>" name="units[<?php echo $index; ?>][quantity]"
            class="form-input" value="<?php echo htmlspecialchars((string) $unit['quantity'] ?? '') ?>" min="1">

          <label for="monthlyPrice_<?php echo $index; ?>" class="form-label">Monthly Price:</label>
          <input type="number" id="monthlyPrice_<?php echo $index; ?>" name="units[<?php echo $index; ?>][monthlyPrice]"
            class="form-input" value="<?php echo htmlspecialchars((string) $unit['monthlyPrice'] ?? '') ?>">
          <br />
          <br />

          <h4 class="form-selection-title">Unit Images</h4>
          <input type="file" name="unit_images[<?php echo $index; ?>][]" multiple accept="image/*"
            onchange="previewImages(this)">
          <small>Maximum 6 images allowed</small>
          <div class="image-preview-container"
            style="display: grid; grid-template-columns: repeat(2, 1fr); gap: 10px; margin-top: 10px;"></div>

          <script>
            function previewImages(input) {
              const container = input.nextElementSibling.nextElementSibling;

              if (input.files.length > 6) {
                alert('Please select maximum 6 files');
                input.value = '';
                container.innerHTML = '';
                return;
              }

              container.innerHTML = '';

              if (input.files) {
                Array.from(input.files).forEach(file => {
                  if (file.type.startsWith('image/')) {
                    const reader = new FileReader();
                    reader.onload = function (e) {
                      const img = document.createElement('img');
                      img.src = e.target.result;
                      img.style.width = '100%';
                      img.style.height = '200px';
                      img.style.objectFit = 'cover';
                      container.appendChild(img);
                    }
                    reader.readAsDataURL(file);
                  }
                });
              }
            }
          </script>

          <br />
          <br />

          <h4 class="form-selection-title">Facilities</h4>
          <div class="unit-facilities" style="
              display: grid;
              grid-template-columns: repeat(3, 1fr);
              gap: 10px;
            ">
            <?php foreach ($facilities as $facility): ?>
              <div class="facility-container">
                <label>
                  <input type="checkbox" class="facility-checkbox" class="facility-label"
                    name="units[<?php echo $index; ?>][facilities][]" value="<?php echo $facility['id']; ?>" <?php echo in_array($facility['id'], $unit['facilities'] ?? []) ? 'checked' : ''; ?>>
                  <?php echo htmlspecialchars($facility['name']); ?>
                </label>
              </div>
            <?php endforeach; ?>
          </div>
        </div>

      <?php endforeach; ?>

    </div>


    <?php
}

function edit_property_inputs()
{
  require_once "../../includes/dbh.inc.php";
  require_once "../../includes/config_session.inc.php";
  require_once "../../includes/models/property_model.inc.php";
  require_once "../../includes/controllers/property_contr.inc.php";

  if (!isset($_GET["property_id"])) {
    echo "Error: Property ID not provided.";
    return;
  }

  $property = fetch_property($pdo, (int) $_GET["property_id"]);
  $_SESSION["edit_property_data"] = $property;

  if (!isset($_SESSION["facilities"])) {
    $_SESSION["facilities"] = fetch_facilities($pdo);
  }
  $facilities = $_SESSION["facilities"];

  $name = $property["name"];
  $description = $property["description"];
  $type = $property["type"];
  $streetAddress = $property["streetAddress"];
  $city = $property["city"];
  $postalCode = $property["postalCode"];
  $units = $property["units"];
  ?>


    <div class="property-form">
      <h3 class="form-selection-title">Property Information</h3>

      <label for="name" class="form-label">Property Name:</label>
      <input type="text" id="name" name="name" class="form-input" value="<?php echo htmlspecialchars($name) ?>">

      <label for="description" class="form-label">Description:</label>
      <textarea id="description" name="description"
        class="form-input"><?php echo htmlspecialchars($description); ?></textarea>

      <label for="type" class="form-label">Property Type:</label>
      <select id="type" name="type" class="form-input">
        <option value="" disabled <?php echo $type === '' ? 'selected' : ''; ?>>Select Property Type</option>
        <option value="Apartment" <?php echo $type === 'Apartment' ? 'selected' : ''; ?>>Apartment</option>
        <option value="Hostel" <?php echo $type === 'Hostel' ? 'selected' : ''; ?>>Hostel</option>
        <option value="Shared House" <?php echo $type === 'Shared House' ? 'selected' : ''; ?>>Shared House</option>
      </select>
      <label for="streetAddress" class="form-label">Street Address:</label>
      <input type="text" id="streetAddress" name="streetAddress" class="form-input"
        value="<?php echo htmlspecialchars($streetAddress) ?>">

      <label for="city" class="form-label">City:</label>
      <input type="text" id="city" name="city" class="form-input" value="<?php echo htmlspecialchars($city) ?>">

      <label for="postalCode" class="form-label">Postal Code:</label>
      <input type="text" id="postalCode" name="postalCode" class="form-input"
        value="<?php echo htmlspecialchars($postalCode) ?>">
      <br>
      <br>
      <br>
      <br>

      <h3 class="form-selection-title">Units</h3>
      <div id="units" class="units-container">
        <?php foreach ($units as $index => $unit): ?>
          <div class="unit-block" id="unit_<?php echo $index; ?>">
            <h4>Unit <?php echo $index + 1; ?></h4>
            <input type="hidden" name="units[<?php echo $index; ?>][id]" value="<?php echo $unit['id']; ?>">

            <label for="description_<?php echo $index; ?>" class="form-label">Description:</label>
            <textarea id="description_<?php echo $index; ?>" class="form-input"
              name="units[<?php echo $index; ?>][description]"><?php echo htmlspecialchars($unit['description'] ?? ''); ?></textarea>

            <label for="unit_type_<?php echo $index; ?>" class="form-label">Unit Type:</label>
            <select type="text" id="unit_type_<?php echo $index; ?>" name="units[<?php echo $index; ?>][unit_type]"
              class="form-input">
              <option value="" disabled <?php echo ($unit['unit_type'] ?? '') === '' ? 'selected' : ''; ?>>Select Unit Type
              </option>
              <option value="Studio" <?php echo ($unit['unit_type'] ?? '') === 'Studio' ? 'selected' : ''; ?>>Studio</option>
              <option value="Single Room" <?php echo ($unit['unit_type'] ?? '') === 'Single Room' ? 'selected' : ''; ?>>Single
                Room
              </option>
              <option value="Shared Room" <?php echo ($unit['unit_type'] ?? '') === 'Shared Room' ? 'selected' : ''; ?>>Shared
                Room
              </option>
              <option value="Multiple-bedrooms" <?php echo ($unit['unit_type'] ?? '') === 'Multiple-bedrooms' ? 'selected' : ''; ?>>
                Multiple-bedrooms</option>
              <option value="Self-contained Unit" <?php echo ($unit['unit_type'] ?? '') === 'Self-contained Unit' ? 'selected' : ''; ?>>
                Self-contained Unit</option>
            </select>

            <label for="numberOfRooms_<?php echo $index; ?>" class="form-label">Number of Rooms:</label>
            <input type="number" id="numberOfRooms_<?php echo $index; ?>" name="units[<?php echo $index; ?>][numberOfRooms]"
              class="form-input" value="<?php echo htmlspecialchars((string) $unit['numberOfRooms'] ?? '') ?>" min="1">

            <label for="quantity_<?php echo $index; ?>" class="form-label">Quantity:</label>
            <input type="number" id="quantity_<?php echo $index; ?>" name="units[<?php echo $index; ?>][quantity]"
              class="form-input" value="<?php echo htmlspecialchars((string) $unit['quantity'] ?? '') ?>" min="1">

            <label for="monthlyPrice_<?php echo $index; ?>" class="form-label">Monthly Price:</label>
            <input type="number" id="monthlyPrice_<?php echo $index; ?>" name="units[<?php echo $index; ?>][monthlyPrice]"
              class="form-input" value="<?php echo htmlspecialchars((string) $unit['monthlyPrice'] ?? '') ?>">
            <br />
            <br />

            <h4>Existing Unit Images</h4>
            <div id="existing_images_<?php echo $index; ?>">
              <?php foreach ($unit['images'] ?? [] as $image): ?>
                <div class="image-container">
                  <img src="<?php echo htmlspecialchars("../" . ($image['path'] ?? 'default.jpg')); ?>" alt="Unit Image"
                    width="100">


                  <!-- Hidden input to store the image ID, it will be passed on form submit -->
                  <input style="display:none" type="checkbox" name="units[<?php echo $index; ?>][existing_images][]"
                    value="<?php echo $image['id']; ?>" checked>

                  <button type="button" onclick="confirmImageDelete(<?php echo $image['id']; ?>)">Delete</button>
                </div>
              <?php endforeach; ?>
            </div>
            <br />

            <h4>Add New Images</h4>
            <input type="file" name="unit_images[<?php echo $index; ?>][]" multiple accept="image/*"
              onchange="previewImages(this)">
            <div class="image-preview-container"
              style="display: grid; grid-template-columns: repeat(2, 1fr); gap: 10px; margin-top: 10px;"></div>
            <br />
            <br />

            <h4 class="form-selection-title">Facilities</h4>
            <div class="unit-facilities" style="
              display: grid;
              grid-template-columns: repeat(3, 1fr);
              gap: 10px;
            ">
              <?php foreach ($facilities as $facility): ?>
                <div class="facility-container">
                  <label>
                    <input type="checkbox" name="units[<?php echo $index; ?>][facilities][]"
                      value="<?php echo $facility['id']; ?>" <?php echo in_array($facility['id'], $unit['facilities'] ?? []) ? 'checked' : ''; ?>>
                    <?php echo htmlspecialchars($facility['name']); ?>
                  </label>
                </div>
              <?php endforeach; ?>
            </div>
            <br />

            <button type="button" onclick="removeUnit(this.parentElement)">Remove Unit</button>
          </div>
        <?php endforeach; ?>
        <?php check_add_property_errors(); ?>
      </div>

      <script>
        function removeUnit(index) {
          const unitElement = document.getElementById(`unit_${index}`);
          if (unitElement) {
            unitElement.remove();
          }
        }
      </script>

      <script>
        function previewImages(input) {
          const container = input.closest('div').querySelector('.image-preview-container');

          if (input.files.length > 6) {
            alert('Please select maximum 6 files');
            input.value = '';
            container.innerHTML = '';
            return;
          }

          container.innerHTML = '';

          if (input.files) {
            Array.from(input.files).forEach(file => {

              if (file.type.startsWith('image/')) {
                const reader = new FileReader();
                reader.onload = function (e) {
                  const img = document.createElement('img');
                  img.src = e.target.result;
                  img.style.width = '100%';
                  img.style.height = '200px';
                  img.style.objectFit = 'cover';
                  container.appendChild(img);
                }
                reader.readAsDataURL(file);
              }
            });
          }
        }
      </script>
    </div>
    <?php
}

function list_user_properties()
{
  require_once "../includes/dbh.inc.php";
  require_once "../includes/config_session.inc.php";
  require_once "../includes/models/property_model.inc.php";
  require_once "../includes/controllers/property_contr.inc.php";

  if (!isset($_SESSION["user_id"])) {
    echo "<p>You are not logged in</p>";
    return;
  }

  $properties = fetch_user_properties($pdo, $_SESSION["user_id"]);

  if (count($properties) === 0) {
    echo "<p class='no-properties'>You have no properties</p>";
  } else {
    echo "<table>";
    echo "<thead>";
    echo "<tr>";
    echo "<th>Name</th>";
    echo "<th class='table-description'>Description</th>";
    echo "<th>Type</th>";
    echo "<th>Address</th>";
    echo "<th>Units</th>";
    echo "<th colspan='2'>Actions</th>";
    echo "</tr>";
    echo "</thead>";

    foreach ($properties as $property) {
      echo "<tbody>";
      echo "<tr>";
      echo "<td>{$property['name']}</td>";
      echo "<td class='table-description'>{$property['description']}</td>";
      echo "<td>{$property['type']}</td>";
      echo "<td>{$property['streetAddress']}, {$property['city']} {$property['postalCode']}</td>";
      echo "<td>{$property['unit_count']}</td>";
      echo "<td><a href='./edit?property_id={$property['id']}'><button>Edit</button></a></td>";
      echo "<td><button class='delete' onclick='confirmDelete(" . htmlspecialchars((string) $property['id']) . ")'>Delete</button></td>";
      echo "</tr>";
      echo "</tbody>";
    }

    echo "</table>";
  }
}

function list_all_properties()
{
  require_once "./includes/dbh.inc.php";
  require_once "./includes/config_session.inc.php";
  require_once "./includes/models/property_model.inc.php";
  require_once "./includes/controllers/property_contr.inc.php";

  $properties = fetch_properties($pdo);

  if (count($properties) === 0) {
    echo "<p>No properties found</p>";
  } else {
    ?>
      <?php foreach ($properties as $property): ?>
        <a href="/studentshelter/property-details?id=<?php echo $property['id']; ?>">
          <div class="property-card">
            <img src="./profile/assets/Property.png" alt="Property 1">
            <div class="property-details">
              <h3>$<?php echo htmlspecialchars($property['monthlyPrice']); ?>/month</h3>
              <div class="favorite-icon"><img src="./assets/heart.png" /></div>
            </div>
            <h4><?php echo htmlspecialchars($property['name']); ?></h4>
            <p><?php echo htmlspecialchars($property['type']); ?></p>
            <p>
              <?php echo htmlspecialchars($property['streetAddress'] . ', ' . $property['city'] . ', ' . $property['postalCode']); ?>
            </p>
          </div>
        </a>
      <?php endforeach; ?>
      <?php
  }
}

function get_property_details()
{
  require_once "../includes/dbh.inc.php";
  require_once "../includes/config_session.inc.php";
  require_once "../includes/models/property_model.inc.php";
  require_once "../includes/controllers/property_contr.inc.php";

  if (!isset($_GET["id"])) {
    echo "<p class='error-message'>Error: Property ID not provided.</p>";
    return;
  }

  $property = fetch_unit_details($pdo, (int) $_GET["id"]);
  $facilities = fetch_facilities($pdo);

  if (!$property) {
    echo "<p class='error-message'>Error: Property not found.</p>";
    return;
  }
  ?>

    <div class="container">
      <div class="main-content">
        <div class="details">
          <div class="main-image">
            <img src="../profile/assets/Picture1.png" alt="Room Image">
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
              if (isset($_SESSION['status']) && $_SESSION['status'] === 'verified') {
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
            <img src="../profile/assets/ss2.jpeg" alt="Property 1">
            <p>Room 7 in Casa Monteiro | $700/Month</p>
          </div>
          <div class="card">
            <img src="../profile/assets/ss3.jpeg" alt="Property 2">
            <p>Room 8 in Casa Monteiro | $700/Month</p>
          </div>
          <div class="card">
            <img src="../profile/assets/ss4.jpeg" alt="Property 3">
            <p>Room 9 in Casa Monteiro | $700/Month</p>
          </div>
          <div class="card">
            <img src="../profile/assets/ss4.jpeg" alt="Property 3">
            <p>Room 9 in Casa Monteiro | $700/Month</p>
          </div>
        </div>
      </div>
    </div>
    <?php
}

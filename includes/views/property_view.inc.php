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

  <h3>Property Information</h3>

  <label for="name">Property Name:</label>
  <input type="text" id="name" name="name" value="<?php echo htmlspecialchars($name) ?>">

  <label for="description">Description:</label>
  <textarea id="description" name="description"><?php echo htmlspecialchars($description); ?></textarea>

  <label for="type">Property Type:</label>
  <input type="text" id="type" name="type" value="<?php echo htmlspecialchars($type) ?>">

  <label for="streetAddress">Street Address:</label>
  <input type="text" id="streetAddress" name="streetAddress" value="<?php echo htmlspecialchars($streetAddress) ?>">

  <label for="city">City:</label>
  <input type="text" id="city" name="city" value="<?php echo htmlspecialchars($city) ?>">

  <label for="postalCode">Postal Code:</label>
  <input type="text" id="postalCode" name="postalCode" value="<?php echo htmlspecialchars($postalCode) ?>">
  <br />
  <br />

  <h3>Units</h3>
  <div id="units">
    <?php foreach ($units as $index => $unit): ?>
      <div class="unit">
        <label for="description_<?php echo $index; ?>">Description:</label>
        <textarea id="description_<?php echo $index; ?>"
          name="units[<?php echo $index; ?>][description]"><?php echo htmlspecialchars($unit['description'] ?? ''); ?></textarea>

        <label for="unit_type_<?php echo $index; ?>">Unit Type:</label>
        <input type="text" id="unit_type_<?php echo $index; ?>" name="units[<?php echo $index; ?>][unit_type]"
          value="<?php echo htmlspecialchars($unit['unit_type'] ?? '') ?>">

        <label for="numberOfRooms_<?php echo $index; ?>">Number of Rooms:</label>
        <input type="number" id="numberOfRooms_<?php echo $index; ?>" name="units[<?php echo $index; ?>][numberOfRooms]"
          value="<?php echo htmlspecialchars((string) $unit['numberOfRooms'] ?? '') ?>" min="1">

        <label for="quantity_<?php echo $index; ?>">Quantity:</label>
        <input type="number" id="quantity_<?php echo $index; ?>" name="units[<?php echo $index; ?>][quantity]"
          value="<?php echo htmlspecialchars((string) $unit['quantity'] ?? '') ?>" min="1">

        <label for="monthlyPrice_<?php echo $index; ?>">Monthly Price:</label>
        <input type="number" id="monthlyPrice_<?php echo $index; ?>" name="units[<?php echo $index; ?>][monthlyPrice]"
          value="<?php echo htmlspecialchars((string) $unit['monthlyPrice'] ?? '') ?>">
        <br />
        <br />

        <h4>Unit Images</h4>
        <input type="file" name="unit_images[<?php echo $index; ?>][]" multiple>
        <br />
        <br />

        <h4>Facilities</h4>
        <div>
          <?php foreach ($facilities as $facility): ?>
            <label>
              <input type="checkbox" name="units[<?php echo $index; ?>][facilities][]" value="<?php echo $facility['id']; ?>"
                <?php echo in_array($facility['id'], $unit['facilities'] ?? []) ? 'checked' : ''; ?>>
              <?php echo htmlspecialchars($facility['name']); ?>
            </label><br>
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

  <h3>Property Information</h3>

  <label for="name">Property Name:</label>
  <input type="text" id="name" name="name" value="<?php echo htmlspecialchars($name) ?>">

  <label for="description">Description:</label>
  <textarea id="description" name="description"><?php echo htmlspecialchars($description); ?></textarea>

  <label for="type">Property Type:</label>
  <input type="text" id="type" name="type" value="<?php echo htmlspecialchars($type) ?>">

  <label for="streetAddress">Street Address:</label>
  <input type="text" id="streetAddress" name="streetAddress" value="<?php echo htmlspecialchars($streetAddress) ?>">

  <label for="city">City:</label>
  <input type="text" id="city" name="city" value="<?php echo htmlspecialchars($city) ?>">

  <label for="postalCode">Postal Code:</label>
  <input type="text" id="postalCode" name="postalCode" value="<?php echo htmlspecialchars($postalCode) ?>">
  <br />
  <br />

  <h3>Units</h3>
  <div id="units">
    <?php foreach ($units as $index => $unit): ?>
      <div class="unit" id="unit_<?php echo $index; ?>">
        <label for="description_<?php echo $index; ?>">Description:</label>
        <textarea id="description_<?php echo $index; ?>"
          name="units[<?php echo $index; ?>][description]"><?php echo htmlspecialchars($unit['description'] ?? ''); ?></textarea>

        <!-- Hidden input to store the unit ID, it will be passed on form submit -->
        <input type="text" id="unit_type_<?php echo $index; ?>" name="units[<?php echo $index; ?>][id]"
          value="<?php echo htmlspecialchars((string) $unit['id'] ?? '') ?>" style="display:none;">

        <label for="unit_type_<?php echo $index; ?>">Unit Type:</label>
        <input type="text" id="unit_type_<?php echo $index; ?>" name="units[<?php echo $index; ?>][unit_type]"
          value="<?php echo htmlspecialchars($unit['type'] ?? '') ?>">

        <label for="numberOfRooms_<?php echo $index; ?>">Number of Rooms:</label>
        <input type="number" id="numberOfRooms_<?php echo $index; ?>" name="units[<?php echo $index; ?>][numberOfRooms]"
          value="<?php echo htmlspecialchars((string) $unit['numberOfRooms'] ?? '') ?>" min="1">

        <label for="quantity_<?php echo $index; ?>">Quantity:</label>
        <input type="number" id="quantity_<?php echo $index; ?>" name="units[<?php echo $index; ?>][quantity]"
          value="<?php echo htmlspecialchars((string) $unit['quantity'] ?? '') ?>" min="1">

        <label for="monthlyPrice_<?php echo $index; ?>">Monthly Price:</label>
        <input type="number" id="monthlyPrice_<?php echo $index; ?>" name="units[<?php echo $index; ?>][monthlyPrice]"
          value="<?php echo htmlspecialchars((string) $unit['monthlyPrice'] ?? '') ?>">
        <br />
        <br />

        <h4>Existing Unit Images</h4>
        <div id="existing_images_<?php echo $index; ?>">
          <?php foreach ($unit['images'] as $image): ?>
            <div class="image-container">
              <img src="<?php echo htmlspecialchars("../" . $image['path']); ?>" alt="Unit Image" width="100">

              <!-- Hidden input to store the image ID, it will be passed on form submit -->
              <input style="display:none" type="checkbox" name="units[<?php echo $index; ?>][existing_images][]"
                value="<?php echo $image['id']; ?>" checked>

              <button type="button" onclick="confirmImageDelete(<?php echo $image['id']; ?>)">Delete</button>
            </div>
          <?php endforeach; ?>
        </div>
        <br />

        <h4>Add New Images</h4>
        <input type="file" name="unit_images[<?php echo $index; ?>][]" multiple>
        <br />
        <br />

        <h4>Facilities</h4>
        <div>
          <?php foreach ($facilities as $facility): ?>
            <label>
              <input type="checkbox" name="units[<?php echo $index; ?>][facilities][]" value="<?php echo $facility['id']; ?>"
                <?php echo in_array($facility['id'], $unit['facilities'] ?? []) ? 'checked' : ''; ?>>
              <?php echo htmlspecialchars($facility['name']); ?>
            </label>
          <?php endforeach; ?>
        </div>
        <br />

        <button type="button" onclick="removeUnit(this.parentElement)">Remove Unit</button>
      </div>
    <?php endforeach; ?>
  </div>

  <script>
    function removeUnitt(index) {
      const unitElement = document.getElementById(`unit_${index}`);
      if (unitElement) {
        unitElement.remove();
      }
    }
  </script>
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
    echo "<p>You have no properties</p>";
  } else {
    echo "<table>";
    echo "<thead>";
    echo "<tr>";
    echo "<th>Name</th>";
    echo "<th>Description</th>";
    echo "<th>Type</th>";
    echo "<th>Address</th>";
    echo "<th>Units</th>";
    echo "<th>Actions</th>";
    echo "</tr>";
    echo "</thead>";

    foreach ($properties as $property) {
      echo "<tbody>";
      echo "<tr>";
      echo "<td>{$property['name']}</td>";
      echo "<td>{$property['description']}</td>";
      echo "<td>{$property['type']}</td>";
      echo "<td>{$property['streetAddress']}, {$property['city']} {$property['postalCode']}</td>";
      echo "<td>{$property['unit_count']}</td>";
      echo "<td><a href='./edit?property_id={$property['id']}'><button>Edit</button></a></td>";
      echo "<td><button onclick='confirmDelete(" . htmlspecialchars((string) $property['id']) . ")'>Delete</button></td>";
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
    <div class="property-grid">
      <?php foreach ($properties as $property): ?>
        <a href="/studentshelter/property-details?id=<?php echo $property['id']; ?>">
          <div class="property-card">
            <h3><?php echo htmlspecialchars($property['name']); ?></h3>
            <p><?php echo htmlspecialchars($property['description']); ?></p>
            <p><?php echo htmlspecialchars($property['type']); ?></p>
            <p><?php echo htmlspecialchars($property['streetAddress']); ?></p>
            <p><?php echo htmlspecialchars($property['city']); ?></p>
            <p><?php echo htmlspecialchars($property['postalCode']); ?></p>
          </div>
        </a>
      <?php endforeach; ?>
    </div>
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
    echo "Error: Property ID not provided.";
    return;
  }

  $property = fetch_unit_details($pdo, (int) $_GET["id"]);
  $facilities = fetch_facilities($pdo);

  if (!$property) {
    echo "Error: Property not found.";
    return;
  }
  ?>

  <h3>Property Information</h3>
  <p>Name: <?php echo htmlspecialchars($property[0]["property_name"]); ?></p>
  <p>Description: <?php echo htmlspecialchars($property[0]["property_description"]); ?></p>
  <p>Type: <?php echo htmlspecialchars($property[0]["property_type"]); ?></p>
  <p>Address:
    <?php echo htmlspecialchars($property[0]["streetAddress"] . ", " . $property[0]["city"] . " " . $property[0]["postalCode"]); ?>
  </p>

  <h3>Unit Information</h3>
  <p>Type: <?php echo htmlspecialchars($property[0]["unit_type"]); ?></p>
  <p>Number of Rooms: <?php echo htmlspecialchars((string) $property[0]["numberOfRooms"]); ?></p>
  <p>Quantity: <?php echo htmlspecialchars((string) $property[0]["quantity"]); ?></p>
  <p>Monthly Price: <?php echo htmlspecialchars($property[0]["monthlyPrice"]); ?></p>
  <p>Available: <?php echo $property[0]["isAvailable"] ? "Yes" : "No"; ?></p>
  <p>Description: <?php echo htmlspecialchars($property[0]["unit_description"]); ?></p>

  <h3>Facilities</h3>
  <div class="property-facilities">
    <?php
    $facilityIds = explode(",", $property[0]["facility_ids"]);
    foreach ($facilities as $facility) {
      if (in_array($facility["id"], $facilityIds)) {
        echo "<p>" . htmlspecialchars($facility["name"]) . "</p>";
      }
    }
    ?>
  </div>

  <h3>Images</h3>
  <div class="property-images">
    <?php
    $images = explode(",", $property[0]["images"]);
    foreach ($images as $image) {
      // Split into ID and image path
      [, $imagePath] = explode(":", $image, 2);
      echo "<img src='$imagePath' alt='Unit Image' width='100'>";
    }
    ?>
  </div>
  <?php
}
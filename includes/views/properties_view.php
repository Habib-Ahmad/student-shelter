<?php

function render_properties(array $properties)
{
  require_once 'partials/header.php';

  echo '<h1 class="page-heading">My Properties</h1>';

  if (empty($properties)) {
    echo "<p>You have not added any properties yet.</p>";
  } else {
    ?>
    <div class="property-container">
      <table>
        <thead>
          <tr>
            <th>Name</th>
            <th class='table-description'>Description</th>
            <th>Type</th>
            <th>Address</th>
            <th>Units</th>
            <th colspan='2'>Actions</th>
          </tr>
        </thead>
        <tbody>
          <?php foreach ($properties as $property) { ?>
            <tr>
              <td><?php echo htmlspecialchars($property['name']); ?></td>
              <td class='table-description'><?php echo htmlspecialchars($property['description']); ?></td>
              <td><?php echo htmlspecialchars($property['type']); ?></td>
              <td class='table-address'>
                <?php echo htmlspecialchars($property['streetAddress']) . ', ' . htmlspecialchars($property['city']) . ' ' . htmlspecialchars($property['postalCode']); ?>
              </td>
              <td><?php echo htmlspecialchars($property['unit_count']); ?></td>
              <td><a href="/studentshelter/properties/edit?id=<?php echo $property['id']; ?>" class="btn-edit"><img src=" /studentshelter/assets/edit.svg" alt="Edit" class="btn-icon"></a></td>
              <td><button 
                  onclick='confirmPropertyDelete(<?php echo htmlspecialchars((string) $property["id"]); ?>)'class="btn-delete" style="border:none; background-color: transparent"> <img src=" /studentshelter/assets/delete.svg" alt="Delete" class="btn-icon" ></button>
              </td>
            </tr>
          <?php } ?>
        </tbody>
      </table>
      <a href="/studentshelter/properties/add" class="page-end-button"> <img src="/studentshelter/assets/add.svg">Add New</a>
    </div>
    <script src="/studentshelter/js/properties.js"></script>
    <?php
  }
  require_once 'partials/footer.php';
}

function render_add_property_form(array $facilities, array $errors)
{
  require_once 'partials/header.php';

  $name = $_SESSION["add_property_data"]["name"] ?? '';
  $description = $_SESSION["add_property_data"]["description"] ?? '';
  $type = $_SESSION["add_property_data"]["type"] ?? '';
  $streetAddress = $_SESSION["add_property_data"]["streetAddress"] ?? '';
  $city = $_SESSION["add_property_data"]["city"] ?? '';
  $postalCode = $_SESSION["add_property_data"]["postalCode"] ?? '';
  $units = $_SESSION["add_property_data"]["units"] ?? [
    [
      'unit_type' => '',
      'numberOfRooms' => '',
      'quantity' => '',
      'monthlyPrice' => '',
      'facilities' => []
    ]
  ];
  ?>

  <h1 class="page-heading">Add Property</h1>

  <form action="/studentshelter/properties/add" method="post" enctype="multipart/form-data" class="property-form">
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
    <button type="button" onclick="addUnit()">Add Unit</button>
    <?php if ($errors): ?>
      <ul class="error-list">
        <?php foreach ($errors as $error): ?>
          <li><?= htmlspecialchars($error) ?></li>
        <?php endforeach; ?>
      </ul>
    <?php endif; ?>
    <br />
    <button name="submit" class="page-end-button">Create Property</button>
  </form>

  <script>
    const facilities = <?php echo json_encode($facilities); ?>;
  </script>
  <script src="/studentshelter/js/properties.js"></script>

  <?php
  require_once 'partials/footer.php';
}

function render_edit_property_form(int $id, array $property, array $facilities, array $errors)
{
  require_once 'partials/header.php';

  $name = $property["name"];
  $description = $property["description"];
  $type = $property["type"];
  $streetAddress = $property["streetAddress"];
  $city = $property["city"];
  $postalCode = $property["postalCode"];
  $units = $property["units"];
  ?>

  <h1 class="page-heading">Edit Property</h1>

  <form action="/studentshelter/properties/edit?id=<?php echo $id; ?>" method="post" enctype="multipart/form-data"
    class="property-form">
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
                <img src="<?php echo htmlspecialchars("/studentshelter/uploads" . $image['path'] . '?v=' . time()); ?>"
                  alt="Unit Image" width="100">

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

          <button type="button" onclick="removeUnit(<?php echo $index; ?>)">Remove Unit</button>
        </div>
      <?php endforeach; ?>
      <?php if ($errors): ?>
        <ul class="error-list">
          <?php foreach ($errors as $error): ?>
            <li><?= htmlspecialchars($error) ?></li>
          <?php endforeach; ?>
        </ul>
      <?php endif; ?>
    </div>
    <button type="button" onclick="addUnit()">Add Unit</button>
    <br />
    <button name="submit" class="page-end-button">Update Property</button>
  </form>

  <script>
    const facilities = <?php echo json_encode($facilities); ?>;
  </script>
  <script src="/studentshelter/js/properties.js"></script>
  <?php

  require_once 'partials/footer.php';
}

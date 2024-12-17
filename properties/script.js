function addUnit() {
  const unitsContainer = document.getElementById("units");

  const newUnit = document.createElement("div");
  let unitCount = unitsContainer.children.length;
  newUnit.classList.add("unit-block");
  newUnit.id = `unit_${unitCount}`;
  newUnit.innerHTML = `
    <h4>Unit ${unitCount + 1}</h4>

    <label for="description_${unitCount}" class="form-label">Description:</label>
    <textarea id="description_${unitCount}" class="form-input" name="units[${unitCount}][description]"></textarea>

    <label class="form-label" for="unit_type">Unit Type:</label>
    <input class="form-input" type="text" name="units[${unitCount}][unit_type]">

    <label class="form-label" for="numberOfRooms">Number of Rooms:</label>
    <input class="form-input" type="number" name="units[${unitCount}][numberOfRooms]" min="1">

    <label class="form-label" for="quantity">Quantity:</label>
    <input class="form-input" type="number" name="units[${unitCount}][quantity]" min="1">

    <label class="form-label" for="monthlyPrice">Monthly Price:</label>
    <input class="form-input" type="number" name="units[${unitCount}][monthlyPrice]">
    <br />
    <br />

    <h4>Unit Images</h4>
    <input type="file" name="unit_images[<?php echo $index; ?>][]" multiple>
    <br />
    <br />

   <h4>Facilities</h4>
    <div class="unit-facilities">
      ${facilities
      .map(
        (facility) => `
    <div class="facility-container">
        <label>
          <input type="checkbox" name="units[${unitCount}][facilities][]" value="${facility.id}">
          ${facility.name}
        </label>
    </div>
      `
      )
      .join("")}
    </div>
    <br />

    <button type="button" onclick="removeUnit(this.parentElement)">Remove Unit</button>
  `;
  unitsContainer.appendChild(newUnit);
  unitCount++;
}

function removeUnit(unitDiv) {
  const unitsContainer = document.getElementById("units");
  if (unitsContainer.children.length > 1) {
    unitsContainer.removeChild(unitDiv);
    unitCount--;
  } else {
    alert("At least one unit is required.");
  }
}

function confirmDelete(propertyId) {
  const userConfirmed = confirm(
    "Are you sure you want to delete this property?"
  );
  if (userConfirmed) {
    window.location.href = `../includes/delete_property.inc.php?property_id=${propertyId}`;
  }
}

function confirmImageDelete(imageId) {
  const userConfirmed = confirm("Are you sure you want to delete this image?");
  if (userConfirmed) {
    window.location.href = `../../includes/delete_unit_image.inc.php?image_id=${imageId}`;
  }
}

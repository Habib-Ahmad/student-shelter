let unitCount = 1;

function addUnit() {
  const unitsContainer = document.getElementById("units");

  const newUnit = document.createElement("div");
  newUnit.classList.add("unit");
  newUnit.innerHTML = `
    <label for="unit_type">Unit Type:</label>
    <input type="text" name="units[${unitCount}][unit_type]">

    <label for="numberOfRooms">Number of Rooms:</label>
    <input type="number" name="units[${unitCount}][numberOfRooms]" min="1">

    <label for="quantity">Quantity:</label>
    <input type="number" name="units[${unitCount}][quantity]" min="1">

    <label for="monthlyPrice">Monthly Price:</label>
    <input type="number" name="units[${unitCount}][monthlyPrice]">
    <br />
    <br />

    <h4>Unit Images</h4>
    <input type="file" name="unit_images[<?php echo $index; ?>][]" multiple>
    <br />
    <br />

   <h4>Facilities</h4>
    <div>
      ${facilities.map(
    (facility) => `
        <label>
          <input type="checkbox" name="units[${unitCount}][facilities][]" value="${facility.id}">
          ${facility.name}
        </label>
      `
  ).join('')}
    </div>
    <br />

    <button type="button" onclick="removeUnit(this.parentElement)">Remove Unit</button>
  `;
  unitsContainer.appendChild(newUnit);
  unitCount++;
}

function removeUnit(unitDiv) {
  const unitsContainer = document.getElementById('units');
  if (unitsContainer.children.length > 1) {
    unitsContainer.removeChild(unitDiv);
    unitCount--;
  } else {
    alert("At least one unit is required.");
  }
}

function confirmDelete(propertyId) {
  const userConfirmed = confirm("Are you sure you want to delete this property?");
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

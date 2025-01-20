function addUnit() {
  const unitsContainer = document.getElementById("units");

  const newUnit = document.createElement("div");
  let unitCount = unitsContainer.children.length;
  newUnit.classList.add("unit-block");
  newUnit.id = `unit_${unitCount}`;
  newUnit.innerHTML = `
    <label for="description_${unitCount}" class="form-label">Description:</label>
    <textarea id="description_${unitCount}" class="form-input" name="units[${unitCount}][description]"></textarea>

    <label for="unit_type_${unitCount}" class="form-label">Unit Type:</label>
    <select id="unit_type_${unitCount}" name="units[${unitCount}][unit_type]" class="form-input">
      <option value="" disabled>Select Unit Type</option>
      <option value="Studio">Studio</option>
      <option value="Single Room">Single Room</option>
      <option value="Shared Room">Shared Room</option>
      <option value="Multiple-bedrooms">Multiple-bedrooms</option>
      <option value="Self-contained Unit">Self-contained Unit</option>
    </select>

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
      ${facilities.map((facility) => `
      <div class="facility-container">
        <label>
          <input type="checkbox" name="units[${unitCount}][facilities][]" value="${facility.id}">
          ${facility.name}
        </label>
      </div>
      `).join("")}
    </div>
    <br />

    <button type="button" onclick="removeUnit(${unitCount})">Remove Unit</button>
  `;
  unitsContainer.appendChild(newUnit);
  unitCount++;
}

function removeUnit(index) {
  if (document.querySelectorAll('.unit-block').length === 1) {
    alert('You must have at least one unit');
    return;
  }

  const unitElement = document.getElementById(`unit_${index}`);
  if (unitElement) {
    unitElement.remove();
  }
}

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

function confirmPropertyDelete(propertyId) {
  const userConfirmed = confirm(
    "Are you sure you want to delete this property?"
  );
  if (userConfirmed) {
    window.location.href = `/studentshelter/properties/delete?id=${propertyId}`;
  }
}

function confirmImageDelete(imageId) {
  const userConfirmed = confirm("Are you sure you want to delete this image?");
  if (userConfirmed) {
    window.location.href = `/studentshelter/properties/delete-unit-image?id=${imageId}`;
  }
}

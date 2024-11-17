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

   <h4>Facilities</h4>
    <div>
      ${facilities.map(
    (facility) => `
        <label>
          <input type="checkbox" name="units[${unitCount}][facilities][]" value="${facility.id}">
          ${facility.name}
        </label><br>
      `
  ).join('')}
    </div>

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

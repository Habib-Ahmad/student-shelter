<?php require_once '../../partials/header.php'; ?>
<?php require_once "../../includes/dbh.inc.php" ?>
<?php require_once "../../includes/config_session.inc.php" ?>
<?php require_once "../../includes/models/property_model.inc.php" ?>
<?php require_once "../../includes/controllers/property_contr.inc.php" ?>
<?php require_once "../../includes/views/property_view.inc.php" ?>
<?php
$facilities = fetch_facilities($pdo);
?>
<script>
  // Pass PHP facilities array to JavaScript
  const facilities = <?= json_encode($facilities); ?>;
</script>

<h1>Add new</h1>

<form action="../../includes/add_property.inc.php" method="post">
  <h3>Property Information</h3>

  <label for="name">Property Name:</label>
  <input type="text" id="name" name="name">

  <label for="description">Description:</label>
  <textarea id="description" name="description"></textarea>

  <label for="type">Property Type:</label>
  <input type="text" id="type" name="type">
  <br />
  <br />

  <h3>Units</h3>
  <div id="units">
    <div class="unit">
      <label for="unit_type">Unit Type:</label>
      <input type="text" name="units[0][unit_type]">

      <label for="numberOfRooms">Number of Rooms:</label>
      <input type="number" name="units[0][numberOfRooms]" min="1">

      <label for="quantity">Quantity:</label>
      <input type="number" name="units[0][quantity]" min="1">

      <label for="monthlyPrice">Monthly Price:</label>
      <input type="number" name="units[0][monthlyPrice]">

      <h4>Facilities</h4>
      <div>
        <?php foreach ($facilities as $facility): ?>
          <label>
            <input type="checkbox" name="units[0][facilities][]" value="<?php echo $facility['id']; ?>">
            <?php echo htmlspecialchars($facility['name']); ?>
          </label><br>
        <?php endforeach; ?>
      </div>
    </div>
  </div>

  <button type="button" onclick="addUnit()">Add Unit</button>
  <br />
  <button type="submit" name="submit">Create Property</button>
</form>

<script src="./script.js"></script>
<?php check_add_property_errors(); ?>

<?php require_once '../../partials/footer.php'; ?>
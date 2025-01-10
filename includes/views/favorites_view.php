<?php
require_once 'partials/header.php';
?>


<section class="properties-section">
      <div class="properties">
        <?php foreach ($properties as $property): ?>
          <a href="/studentshelter/property-details?id=<?php echo $property['id']; ?>">
            <div class="property-card">
              <img src="/studentshelter/assets/Property.png" alt="Property 1">
              <div class="property-details">
                <h3>$<?php echo htmlspecialchars($property['monthlyPrice']); ?>/month</h3>
                <div class="favorite-icon"><img src="/studentshelter/assets/heart.png" /></div>
              </div>
              <h4><?php echo htmlspecialchars($property['name']); ?></h4>
              <p><?php echo htmlspecialchars($property['type']); ?></p>
              <p>
                <?php echo htmlspecialchars($property['streetAddress'] . ', ' . $property['city'] . ', ' . $property['postalCode']); ?>
              </p>
            </div>
          </a>
        <?php endforeach; ?>
      </div>
</section>







<?php require_once 'partials/footer.php'; ?>










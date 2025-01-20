<?php

declare(strict_types=1);

function render_favorites(object $pdo, array $favorites)
{
  require_once 'partials/header.php';
  ?>
  <div class="favorites-container">
    <h1 class="favorites-title">Favorites</h1>

    <?php if (empty($favorites)): ?>
      <p class="no-favorites-message">You have no favorites yet.</p>
    <?php else: ?>
      <div class="properties">
        <?php foreach ($favorites as $favorite): ?>
          <a href="/studentshelter/property-details?id=<?php echo $favorite['id']; ?>">
            <div class="property-card">
              <?php
              $images = !empty($favorite['images']) ? explode(',', $favorite['images']) : [];
              $imageSrc = !empty($images) ? "/studentshelter/uploads/" . htmlspecialchars($images[0]) : "/studentshelter/assets/Property.png";
              ?>
              <img src="<?php echo $imageSrc; ?>" alt="Property Image">
              <div class="property-details">
                <h3>$<?php echo htmlspecialchars($favorite['monthlyPrice']); ?>/month</h3>
                <a href="<?php echo "/studentshelter/favorites/remove?id=" . $favorite['unitId'] ?>" class="favorite-icon"
                  data-id="<?php echo $favorite['id']; ?>">
                  <img src="/studentshelter/assets/heart-filled.svg" alt="Remove from Favorites">
                </a>
              </div>
              <h4><?php echo htmlspecialchars($favorite['name']); ?></h4>
              <p><?php echo htmlspecialchars($favorite['type']); ?></p>
              <p>
                <?php echo htmlspecialchars($favorite['streetAddress'] . ', ' . $favorite['city'] . ', ' . $favorite['postalCode']); ?>
              </p>
            </div>
          </a>
        <?php endforeach; ?>
      </div>
    <?php endif; ?>
  </div>
  <?php
  require_once 'partials/footer.php';
}

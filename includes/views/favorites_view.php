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
      <ul class="favorites-list">
        <?php foreach ($favorites as $favorite): ?>
          <li class="favorite-item">
            <a href="/studentshelter/property-details?id=<?php echo $favorite['unitId']; ?>" class="property-link">
              <div class="property-card">
                <img src="/studentshelter/assets/Property.png" alt="Property 1" class="property-image">
                <div class="property-details">
                  <h3 class="property-price">$<?php echo htmlspecialchars($favorite['monthlyPrice']); ?>/month</h3>
                  <?php
                  if (isset($_SESSION['user_id'])) {
                    $isFavorite = is_property_favorite($pdo, $_SESSION['user_id'], $favorite['unitId']);
                    $favoriteIcon = $isFavorite ? 'heart-filled.svg' : 'heart.svg';
                    $favoriteAlt = $isFavorite ? 'Remove from Favorites' : 'Add to Favorites';
                    $favoriteLink = "/studentshelter/favorites/remove?id=" . $favorite['unitId'];
                  } else {
                    $favoriteIcon = 'heart.svg'; // Default unfilled heart for guests
                    $favoriteAlt = 'Login to add to favorites';
                    $favoriteLink = "/studentshelter/login"; // Redirect to login
                  }
                  ?>
                  <a class="favorite-icon-link" href="<?php echo $favoriteLink; ?>">
                    <img src="/studentshelter/assets/<?php echo $favoriteIcon; ?>" alt="<?php echo $favoriteAlt; ?>" class="favorite-icon">
                  </a>
                </div>
                <h4 class="property-name"><?php echo htmlspecialchars($favorite['name']); ?></h4>
                <p class="property-type"><?php echo htmlspecialchars($favorite['type']); ?></p>
                <p class="property-address">
                  <?php echo htmlspecialchars($favorite['streetAddress'] . ', ' . $favorite['city'] . ', ' . $favorite['postalCode']); ?>
                </p>
              </div>
            </a>
          </li>
        <?php endforeach; ?>
      </ul>
    <?php endif; ?>
  </div>
  <?php
  require_once 'partials/footer.php';
}

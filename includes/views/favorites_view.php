<?php

declare(strict_types=1);

function render_favorites(object $pdo, array $favorites)
{
  require_once 'partials/header.php';
  ?>
  <h1>Favorites</h1>

  <?php if (empty($favorites)): ?>
    <p>You have no favorites yet.</p>
  <?php else: ?>
    <ul>
      <?php foreach ($favorites as $favorite): ?>
        <a href="/studentshelter/property-details?id=<?php echo $favorite['unitId']; ?>">
          <div class="property-card">
            <img src="/studentshelter/assets/Property.png" alt="Property 1">
            <div class="property-details">
              <h3>$<?php echo htmlspecialchars($favorite['monthlyPrice']); ?>/month</h3>
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
              <a class="favorite-icon" href="<?php echo $favoriteLink; ?>">
                <img src="/studentshelter/assets/<?php echo $favoriteIcon; ?>" alt="Add to Favorites">
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
    </ul>
  <?php endif; ?>

  <?php
  require_once 'partials/footer.php';
}

<?php
require_once 'partials/header.php';
?>

<section class="legal-section">
  <div class="container">
    <h2 class="legal-title">Legal Notice</h2> <br>
    <?php foreach ($legalClauses as $title => $description): ?>
      <div class="legal-clause">
        <p class="legal-clause-title"><?php echo htmlspecialchars($title); ?></p>
        <p class="legal-clause-description"><?php echo htmlspecialchars($description); ?></p>
      </div>
    <?php endforeach; ?>
  </div>
</section>

<?php require_once 'partials/footer.php'; ?>
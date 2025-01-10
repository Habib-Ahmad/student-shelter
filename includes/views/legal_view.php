<?php
require_once 'partials/header.php';
?>

<section class="legal-section">
  <h2>Legal Notice</h2>
  <?php foreach ($legalClauses as $title => $description): ?>
    <div>
      <h4><?php echo htmlspecialchars($title); ?></h4>
      <p><?php echo htmlspecialchars($description); ?></p>
    </div>
  <?php endforeach; ?>
</section>

<?php require_once 'partials/footer.php'; ?>
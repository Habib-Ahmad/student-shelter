<?php
require_once 'partials/header.php';
?>

<section>
  <h2>Legal Notice</h2>
  <?php foreach ($legalClauses as $title => $description): ?>
    <div>
      <p><?php echo htmlspecialchars($title); ?></p>
      <p><?php echo htmlspecialchars($description); ?></p>
    </div>
  <?php endforeach; ?>
</section>

<?php require_once 'partials/footer.php'; ?>
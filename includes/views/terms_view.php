<?php require_once "partials/header.php"; ?>

<section id="terms" class="terms-section">
  <div class="terms-container">
    <h2 class="terms-title">Terms and Conditions</h2>
    <?php foreach ($termsClauses as $title => $description): ?>
      <h3 class="terms-subtitle"><?php echo $title; ?></h3>
      <p class="terms-description"><?php echo $description; ?></p>
    <?php endforeach; ?>
  </div>
</section>

<?php require_once "partials/footer.php"; ?>
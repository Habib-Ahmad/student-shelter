<?php require_once "partials/header.php"; ?>

<div>
  <section id="terms-section">
    <h2>Terms and Conditions</h2>
    <?php foreach ($termsClauses as $title => $description): ?>
      <h3><?php echo $title; ?></h3>
      <p><?php echo $description; ?></p>
    <?php endforeach; ?>
  </section>
</div>

<?php require_once "partials/footer.php"; ?>
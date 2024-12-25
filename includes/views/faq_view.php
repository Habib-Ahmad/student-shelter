<?php
require_once 'partials/header.php';
?>

<section class="faq-container">
  <h2>Frequently Asked Questions</h2>
  <?php foreach ($faqs as $question => $answer): ?>
    <details class="faq-item">
      <summary class="faq-question"><?php echo htmlspecialchars($question); ?></summary>
      <div class="faq-answer">
        <p><?php echo htmlspecialchars($answer); ?></p>
      </div>
    </details>
  <?php endforeach; ?>
</section>

<script src="/studentshelter/js/faq.js"></script>

<?php require_once 'partials/footer.php'; ?>
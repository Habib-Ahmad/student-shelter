<?php

function render_faq_list($faqs)
{
  require_once 'partials/header.php';

  $role = $_SESSION['user_role'] ?? '';
  ?>
  <section class="faq-container">
    <h2>Frequently Asked Questions</h2>
    <?php foreach ($faqs as $faq): ?>
      <details class="faq-item">
        <summary class="faq-question">
          <p><?php echo htmlspecialchars($faq['title']); ?></p>
          <?php if ($role === 'admin'): ?>
            <div class="admin-actions">
              <a href="/studentshelter/faq/edit/<?php echo $faq['id']; ?>" class="edit-faq">Edit</a>
              <form method="POST" action="/studentshelter/faq/delete/<?php echo $faq['id']; ?>" class="delete-faq-form" style="display:inline;">
              <button type="submit" class="delete-faq-button" onclick="return confirm('Are you sure you want to delete this FAQ?');">Delete</button>
              </form>
            </div>
          <?php endif; ?>
        </summary>
        <div class="faq-answer">
          <p><?php echo htmlspecialchars($faq['description']); ?></p>
        </div>
      </details>
    <?php endforeach; ?>

    <?php if ($role === 'admin'): ?>
      <form method="POST" action="/studentshelter/faq/add" class="add-faq-form">
        <h3 class="add-faq-title">Add New FAQ</h3>
        <label for="title" class="add-faq-label">Question</label>
        <input type="text" id="title" name="title" class="add-faq-input" required placeholder="question">
        <label for="description" class="add-faq-label">Answer</label>
        <textarea id="description" name="description" class="add-faq-textarea" required placeholder="answer"></textarea>
        <button type="submit" class="add-faq-button">Add FAQ</button>
      </form>
    <?php endif; ?>
  </section>
  <script src="/studentshelter/js/faq.js"></script>
  <?php
  require_once 'partials/footer.php';
}

function render_faq_edit($faq)
{
  require_once 'partials/header.php';
  ?>
  <section class="faq-edit-container">
    <h2>Edit FAQ</h2>

    <form method="POST" action="/studentshelter/faq/edit/<?php echo $faq['id']; ?>">
      <label for="title">Question</label>
      <input type="text" id="title" name="title" value="<?php echo htmlspecialchars($faq['title']); ?>" required>
      <label for="description">Answer</label>
      <textarea id="description" name="description"
        required><?php echo htmlspecialchars($faq['description']); ?></textarea>
      <button type="submit">Save Changes</button>
    </form>
  </section>
  <?php
  require_once 'partials/footer.php';
}

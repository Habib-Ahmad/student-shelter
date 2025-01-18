<?php

function render_terms($terms)
{
  require_once "partials/header.php";

  $role = $_SESSION['user_role'] ?? '';
  ?>

  <section id="terms" class="terms-container">
    <h2 class="terms-title">Terms and Conditions</h2>

     
    <?php foreach ($terms as $term): ?>
      <div>
        <h3 class="terms-subtitle"><?php echo htmlspecialchars($term['title']); ?></h3>
        <p class="terms-description"><?php echo htmlspecialchars($term['description']); ?></p>
        <?php if ($role === 'admin'): ?>
          <a href="/studentshelter/terms/edit/<?php echo $term['id']; ?>" class="btn-edit"><img
              src="/studentshelter/assets/edit.svg" alt="Edit" class="btn-icon"></a>
          <a href="#" onclick="confirmDelete(<?php echo $term['id']; ?>)" class="btn-delete"><img
              src="/studentshelter/assets/delete.svg" alt="Edit" class="btn-icon"></a>
        <?php endif; ?>
      </div>
    <?php endforeach; ?>
    <?php if ($role === 'admin'): ?>
      <a href="/studentshelter/terms/add" class="btn-add"><img src="/studentshelter/assets/add.svg" alt="add"
          class="btn-icon">Add new</a>
    <?php endif; ?>
  </section>

  <script src="/studentshelter/js/terms.js"></script>

  <?php require_once "partials/footer.php";
}

function render_terms_form($term = null)
{
  $action = $term ? "/studentshelter/terms/edit/" . $term['id'] : "/studentshelter/terms/add";
  $title = $term['title'] ?? '';
  $description = $term['description'] ?? '';

  require_once "partials/header.php"; ?>

  <div class="terms-form-container">
    <form action="<?php echo $action; ?>" method="POST">
      <label for="title" class="terms-form-label">Title</label>
      <input type="text" id="title" name="title" value="<?php echo htmlspecialchars($title); ?>" required
        class="terms-form-input">

      <label for="description" class="terms-form-label">Description</label>
      <textarea id="description" name="description" required
        class="terms-form-textarea"><?php echo htmlspecialchars($description); ?></textarea>

      <button type="submit" class="terms-form-button"><?php echo $term ? 'Update' : 'Add'; ?> Term</button>
    </form>
  </div>



  <?php require_once "partials/footer.php";
}

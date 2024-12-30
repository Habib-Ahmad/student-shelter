<?php

function render_terms($terms)
{
  require_once "partials/header.php";

  $role = $_SESSION['user_role'] ?? '';
  ?>

  <section id="terms" class="terms-container">
    <h2 class="terms-title">Terms and Conditions</h2>

    <?php if ($role === 'admin'): ?>
      <a href="/studentshelter/terms/add" class="btn-add">Add New Term</a>
    <?php endif; ?>
    <?php foreach ($terms as $term): ?>
      <div>
        <h3 class="terms-subtitle"><?php echo htmlspecialchars($term['title']); ?></h3>
        <p class="terms-description"><?php echo htmlspecialchars($term['description']); ?></p>
        <?php if ($role === 'admin'): ?>
          <a href="/studentshelter/terms/edit/<?php echo $term['id']; ?>" class="btn-edit">Edit</a>
          <a href="#" onclick="confirmDelete(<?php echo $term['id']; ?>)" class="btn-delete">Delete</a>
        <?php endif; ?>
      </div>
    <?php endforeach; ?>
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

  <form action="<?php echo $action; ?>" method="POST">
    <label for="title">Title</label>
    <input type="text" id="title" name="title" value="<?php echo htmlspecialchars($title); ?>" required>

    <label for="description">Description</label>
    <textarea id="description" name="description" required><?php echo htmlspecialchars($description); ?></textarea>

    <button type="submit"><?php echo $term ? 'Update' : 'Add'; ?> Term</button>
  </form>

  <?php require_once "partials/footer.php";
}

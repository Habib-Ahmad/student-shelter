<?php

function render_legal($legalClauses)
{
  require_once "partials/header.php";

  $role = $_SESSION['user_role'] ?? '';
  ?>

  <section class="container legal-section">
    <h2 class="legal-title">Legal Notice</h2>

    <?php if ($role === 'admin'): ?>
      <a href="/studentshelter/legal/add">Add New Legal Clause</a>
    <?php endif; ?>

    <?php foreach ($legalClauses as $clause): ?>
      <div class="legal-clause">
        <h3 class="legal-clause-title"><?php echo htmlspecialchars($clause['title']); ?></h3>
        <p class="legal-clause-description"><?php echo htmlspecialchars($clause['description']); ?></p>
        <?php if ($role === 'admin'): ?>
          <a href="/studentshelter/legal/edit/<?php echo $clause['id']; ?>">Edit</a>
          <a href="#" onclick="confirmDelete(<?php echo $clause['id']; ?>)">Delete</a>
        <?php endif; ?>
      </div>
    <?php endforeach; ?>
  </section>

  <script src="/studentshelter/js/legal.js"></script>

  <?php require_once "partials/footer.php";
}

function render_legal_form($clause = null)
{
  $action = $clause ? "/studentshelter/legal/edit/" . $clause['id'] : "/studentshelter/legal/add";
  $title = $clause['title'] ?? '';
  $description = $clause['description'] ?? '';

  require_once "partials/header.php"; ?>

  <form action="<?php echo $action; ?>" method="POST" class="container"></form>
    <label for="title">Title</label>
    <input type="text" id="title" name="title" value="<?php echo htmlspecialchars($title); ?>" required>

    <label for="description">Description</label>
    <textarea id="description" name="description" required><?php echo htmlspecialchars($description); ?></textarea>

    <button type="submit"><?php echo $clause ? 'Update' : 'Add'; ?> Legal Clause</button>
  </form>

  <?php require_once "partials/footer.php";
}

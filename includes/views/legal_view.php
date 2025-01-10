<?php

function render_legal($legalClauses)
{
  require_once "partials/header.php";

  $role = $_SESSION['user_role'] ?? '';
  ?>

  <section class="container legal-section">
    <h2 class="legal-title">Legal Notice</h2>

    <?php if ($role === 'admin'): ?>
      <a href="/studentshelter/legal/add" class="btn-add">Add New Legal Clause</a> <br><br>
    <?php endif; ?>

    <?php foreach ($legalClauses as $clause): ?>
      <div class="legal-clause">
        <h3 class="legal-clause-title"><?php echo htmlspecialchars($clause['title']); ?></h3>
        <p class="legal-clause-description"><?php echo htmlspecialchars($clause['description']); ?></p>
        <?php if ($role === 'admin'): ?>
            <a href="/studentshelter/legal/edit/<?php echo $clause['id']; ?>" class="btn-edit">Edit</a>
            <a href="#" onclick="confirmDelete(<?php echo $clause['id']; ?>)" class="btn-delete">Delete</a>
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

  <form action="<?php echo $action; ?>" method="POST" class="container-form-legal">
    <div class="form-group">
      <label for="title" class="form-label">Title</label>
      <input type="text" id="title" name="title" class="form-control" value="<?php echo htmlspecialchars($title); ?>" required>
    </div>

    <div class="form-group">
      <label for="description" class="form-label">Description</label>
      <textarea id="description" name="description" class="form-control" required><?php echo htmlspecialchars($description); ?></textarea>
    </div>

    <button type="submit" class="btn btn-primary"><?php echo $clause ? 'Update' : 'Add'; ?> Legal Clause</button>
  </form>

  <?php require_once "partials/footer.php";
}

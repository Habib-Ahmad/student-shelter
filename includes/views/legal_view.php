<?php

function render_legal($legalClauses)
{
    require_once "partials/header.php";

    $role = $_SESSION['user_role'] ?? '';
    ?>

    <section class="container-legal-section">
        <h2 class="legal-title">Legal Notice</h2>
        <?php foreach ($legalClauses as $clause): ?>
            <div>
                <h3 class="legal-clause-title"><?php echo htmlspecialchars($clause['title']); ?></h3>
                <p class="legal-clause-description"><?php echo htmlspecialchars($clause['description']); ?></p>
                <?php if ($role === 'admin'): ?>
                    <a href="/studentshelter/legal/edit/<?php echo $clause['id']; ?>" class="btn-edit"><img
                            src="/studentshelter/assets/edit.svg" alt="Edit" class="btn-icon"></a>
                    <a href="#" onclick="confirmDelete(<?php echo $clause['id']; ?>)" class="btn-delete"><img
                            src="/studentshelter/assets/delete.svg" alt="Edit" class="btn-icon"></a>
                <?php endif; ?>
            </div>
        <?php endforeach; ?>
        <?php if ($role === 'admin'): ?>
            <a href="/studentshelter/legal/add" class="btn-add"><img src="/studentshelter/assets/add.svg" alt="add"
                    class="btn-icon">New Legal Clause</a>
        <?php endif; ?>
    </section>

    <script src="/studentshelter/js/legal.js"></script>

    <?php require_once "partials/footer.php";
}

function render_legal_form($clause = null)
{
    $action = $clause ? "/studentshelter/legal/edit/" . $clause['id'] : "/studentshelter/legal/add";
    $pageTitle = $clause ? 'Edit Legal Notice' : 'Add Legal Notice';
    $title = $clause['title'] ?? '';
    $description = $clause['description'] ?? '';

    require_once "partials/header.php"; ?>
    <div class="legal-edit-page">
        <section class="legal-edit-container">
            <h2><?php echo $pageTitle; ?></h2>

            <form action="<?php echo $action; ?>" method="POST">
                <label for="title">Title</label>
                <input type="text" id="title" name="title" value="<?php echo htmlspecialchars($title); ?>" required>

                <label for="description">Description</label>
                <textarea id="description" name="description" rows="6"
                    required><?php echo htmlspecialchars($description); ?></textarea>

                <button type="submit">Submit</button>
            </form>
        </section>
    </div>

    <?php require_once "partials/footer.php";
}

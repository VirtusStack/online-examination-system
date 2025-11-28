<?php
// /templates/classrooms/add_class.php
// -------------------------
// View file: Displays Add Classroom form
require_once __DIR__ . '/../../config/config.php';
?>
<?php include __DIR__ . "/../include/header.php"; ?>

<div id="wrapper">

    <!-- Sidebar -->
    <?php include __DIR__ . "/../include/sidebar.php"; ?>

    <!-- Content Wrapper -->
    <div id="content-wrapper" class="d-flex flex-column">

        <div id="content">
            <?php include __DIR__ . "/../include/navbar.php"; ?>

            <div class="container-fluid">
                <h1 class="h3 mb-4 text-gray-800">
                    <?= isset($results['pageTitle']) ? $results['pageTitle'] : 'Add Class' ?>
                </h1>

                <?php if (!empty($results['message'])): ?>
                    <div class="alert <?= (stripos($results['message'], 'success') !== false) ? 'alert-success' : 'alert-danger' ?> alert-dismissible fade show" role="alert">
                        <?= (stripos($results['message'], 'success') !== false)  ? '<i class="fas fa-check-circle"></i>'  : '<i class="fas fa-times-circle"></i>' ?>
                        <?= htmlspecialchars($results['message']) ?>
                        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                <?php endif; ?>

                <div class="card shadow mb-4">
                    <div class="card-body">
                        <form method="POST" action="<?= BASE_URL ?>/admin.php?action=newClassroom">

                            <div class="form-group mb-3">
                                <label>Class Name:</label>
                                <input type="text" name="class_name" class="form-control" required
                                    value="<?= htmlspecialchars($results['class_name'] ?? '') ?>">
                            </div>

                            <button type="submit" class="btn btn-primary">Add Class</button>
                        </form>
                    </div>
                </div>
            </div>

        </div>
        <?php include __DIR__ . "/../include/footer.php"; ?>

    </div>
</div>

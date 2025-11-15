<?php
// /templates/subjects/edit_subject.php
// -------------------------
// View file: Displays Edit Subject
require_once __DIR__ . '/../../config/config.php';
?>
<?php include __DIR__ . "/../include/header.php"; ?>

<!-- Page Wrapper -->
<div id="wrapper">

    <!-- Sidebar -->
    <?php include __DIR__ . "/../include/sidebar.php"; ?>
    <!-- End of Sidebar -->

    <!-- Content Wrapper -->
    <div id="content-wrapper" class="d-flex flex-column">

        <!-- Main Content -->
        <div id="content">

            <!-- Navbar -->
            <?php include __DIR__ . "/../include/navbar.php"; ?>
            <!-- End of Navbar -->

            <!-- Begin Page Content -->
            <div class="container-fluid">

                <!-- Page Heading -->
                <h1 class="h3 mb-4 text-gray-800">
                    <?= isset($results['pageTitle']) ? $results['pageTitle'] : 'Edit Subject' ?>
                </h1>

                <!-- Feedback message -->
                <?php if (!empty($results['message'])): ?>
                    <div class="alert <?= (stripos($results['message'], 'success') !== false) ? 'alert-success' : 'alert-danger' ?> alert-dismissible fade show" role="alert">
                        <?= (stripos($results['message'], 'success') !== false)  ? '<i class="fas fa-check-circle"></i>'  : '<i class="fas fa-times-circle"></i>' ?>
                        <?= htmlspecialchars($results['message']) ?>
                        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                <?php endif; ?>

                <!-- Subject Form Card -->
                <div class="card shadow mb-4">
                    <div class="card-body">
                        <!-- Form submits to admin.php?action=editSubject&id=XX -->
                        <form method="POST" action="<?= BASE_URL ?>/admin.php?action=editSubject&id=<?= htmlspecialchars($results['subject']['subject_id']) ?>">

                            <!-- Subject Name -->
                            <div class="form-group mb-3">
                                <label>Subject Name:</label>
                                <input type="text" name="subject_name" class="form-control" required
                                    value="<?= htmlspecialchars($results['subject']['subject_name'] ?? '') ?>">
                            </div>

                            <!-- Description -->
                            <div class="form-group mb-3">
                                <label>Description:</label>
                                <textarea name="description" class="form-control" rows="3"><?= htmlspecialchars($results['subject']['description'] ?? '') ?></textarea>
                            </div>

                            <!-- Submit Button -->
                            <button type="submit" class="btn btn-primary">Update Subject</button>
                            <a href="<?= BASE_URL ?>/admin.php?action=manageSubjects" class="btn btn-secondary">Cancel</a>
                        </form>
                    </div>
                </div>

            </div>
            <!-- /.container-fluid -->

        </div>
        <!-- End of Main Content -->

        <!-- Footer -->
        <?php include __DIR__ . "/../include/footer.php"; ?>
        <!-- End of Footer -->

    </div>
    <!-- End of Content Wrapper -->

</div>
<!-- End of Page Wrapper -->

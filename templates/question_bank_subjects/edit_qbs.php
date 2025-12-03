<?php
// /templates/question_bank_subjects/edit_qbs.php
// -------------------------
// View file: Edit Question Bank Subject Link
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
                    <?= htmlspecialchars($results['pageTitle'] ?? 'Edit Bank-Subject Link') ?>
                </h1>

                <!-- Feedback message -->
                <?php if (!empty($results['message'])): ?>
                    <div class="alert <?= stripos($results['message'], 'success')!==false ? 'alert-success' : 'alert-danger' ?> alert-dismissible fade show" role="alert">
                        <?= htmlspecialchars($results['message']) ?>
                        <button type="button" class="close" data-dismiss="alert">&times;</button>
                    </div>
                <?php endif; ?>

                <!-- Form Card -->
                <div class="card shadow mb-4">
                    <div class="card-body">
                        <form method="POST" action="<?= BASE_URL ?>/admin.php?action=editQBS&id=<?= htmlspecialchars($results['link']['id'] ?? '') ?>">

                            <!-- Select Question Bank -->
                            <div class="form-group mb-3">
                                <label>Question Bank:</label>
                                <select name="bank_id" class="form-control" required>
                                    <option value="">-- Select Bank --</option>
                                    <?php foreach($results['banks'] as $bank): ?>
                                        <option value="<?= $bank['bank_id'] ?>" <?= isset($results['link']['bank_id']) && $results['link']['bank_id'] == $bank['bank_id'] ? 'selected' : '' ?>>
                                            <?= htmlspecialchars($bank['bank_name']) ?>
                                        </option>
                                    <?php endforeach; ?>
                                </select>
                            </div>

                            <!-- Select Subject -->
                            <div class="form-group mb-3">
                                <label>Subject:</label>
                                <select name="subject_id" class="form-control" required>
                                    <option value="">-- Select Subject --</option>
                                    <?php foreach($results['subjects'] as $sub): ?>
                                        <option value="<?= $sub['subject_id'] ?>" <?= isset($results['link']['subject_id']) && $results['link']['subject_id'] == $sub['subject_id'] ? 'selected' : '' ?>>
                                            <?= htmlspecialchars($sub['subject_name']) ?>
                                        </option>
                                    <?php endforeach; ?>
                                </select>
                            </div>

                            <!-- Submit Button -->
                            <button type="submit" class="btn btn-primary">Update Link</button>
                            <a href="<?= BASE_URL ?>/admin.php?action=manageQBS" class="btn btn-secondary">Cancel</a>
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

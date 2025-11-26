<?php
// /templates/exams/edit_exam.php
// -------------------------
// View file: Displays Edit Exam
require_once __DIR__ . '/../../config/config.php';
$exam = $results['exam'] ?? [];
?>

<?php include __DIR__ . "/../include/header.php"; ?>

<div id="wrapper">

    <!-- Sidebar -->
    <?php include __DIR__ . "/../include/sidebar.php"; ?>

    <div id="content-wrapper" class="d-flex flex-column">

        <div id="content">

            <!-- Navbar -->
            <?php include __DIR__ . "/../include/navbar.php"; ?>

            <div class="container-fluid">

                <!-- Page Heading -->
                <h1 class="h3 mb-4 text-gray-800"><?= htmlspecialchars($results['pageTitle'] ?? 'Edit Exam') ?></h1>

                <!-- Feedback message -->
                <?php if (!empty($results['message'])): ?>
                    <div class="alert <?= (stripos($results['message'], 'success')!==false)?'alert-success':'alert-danger' ?> alert-dismissible fade show" role="alert">
                        <?= htmlspecialchars($results['message']) ?>
                        <button type="button" class="close" data-dismiss="alert"><span>&times;</span></button>
                    </div>
                <?php endif; ?>

                <!-- Exam Form Card -->
                <div class="card shadow mb-4">
                    <div class="card-body">
                        <!-- Form submits to admin.php?action=editExam&id=XX -->
                        <form method="POST" action="<?= BASE_URL ?>/admin.php?action=editExam&id=<?= htmlspecialchars($exam['exam_id'] ?? '') ?>">

                            <!-- Exam Title -->
                            <div class="form-group mb-3">
                                <label>Exam Title:</label>
                                <input type="text" name="exam_title" class="form-control" required
                                       value="<?= htmlspecialchars($exam['exam_title'] ?? '') ?>">
                            </div>

                            <!-- Remove Bank dropdown (not used) -->

                            <!-- Total Questions -->
                            <div class="form-group mb-3">
                                <label>Total Questions:</label>
                                <input type="number" name="total_questions" class="form-control" required
                                       value="<?= htmlspecialchars($exam['total_questions'] ?? 0) ?>" min="1">
                            </div>

                            <!-- Duration -->
                            <div class="form-group mb-3">
                                <label>Duration (minutes):</label>
                                <input type="number" name="duration_minutes" class="form-control" required
                                       value="<?= htmlspecialchars($exam['duration_minutes'] ?? 30) ?>" min="1">
                            </div>

                            <!-- Shuffle Questions -->
                            <div class="form-check mb-2">
                                <input type="checkbox" name="shuffle_questions" class="form-check-input" id="shuffle_questions"
                                    <?= ($exam['shuffle_questions'] ?? 1) ? 'checked' : '' ?>>
                                <label class="form-check-label" for="shuffle_questions">Shuffle Questions</label>
                            </div>

                            <!-- Shuffle Options -->
                            <div class="form-check mb-3">
                                <input type="checkbox" name="shuffle_options" class="form-check-input" id="shuffle_options"
                                    <?= ($exam['shuffle_options'] ?? 1) ? 'checked' : '' ?>>
                                <label class="form-check-label" for="shuffle_options">Shuffle Options</label>
                            </div>

                            <!-- Status -->
                            <div class="form-group mb-3">
                                <label>Status:</label>
                                <select name="status" class="form-control">
                                    <option value="Active" <?= ($exam['status'] ?? '')=='Active'?'selected':'' ?>>Active</option>
                                    <option value="Inactive" <?= ($exam['status'] ?? '')=='Inactive'?'selected':'' ?>>Inactive</option>
                                </select>
                            </div>

                            <!-- Submit Button -->
                            <button type="submit" class="btn btn-primary">Update Exam</button>
                            <a href="<?= BASE_URL ?>/admin.php?action=manageExams" class="btn btn-secondary">Cancel</a>

                        </form>
                    </div>
                </div>

            </div>
            <!-- /.container-fluid -->

        </div>
        <!-- End of Main Content -->

        <?php include __DIR__ . "/../include/footer.php"; ?>

    </div>
</div>

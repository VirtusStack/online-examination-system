<?php
// /templates/exams/add_exam.php
// -------------------------
// View file: Displays Add Exam
require_once __DIR__ . '/../../config/config.php';
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
                <h1 class="h3 mb-4 text-gray-800"><?= htmlspecialchars($results['pageTitle']) ?></h1>

                <!-- Feedback message -->
                <?php if (!empty($results['message'])): ?>
                    <div class="alert <?= (stripos($results['message'], 'success') !== false) ? 'alert-success' : 'alert-danger' ?> alert-dismissible fade show" role="alert">
                        <?= (stripos($results['message'], 'success') !== false) ? '<i class="fas fa-check-circle"></i>' : '<i class="fas fa-times-circle"></i>' ?>
                        <?= htmlspecialchars($results['message']) ?>
                        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                <?php endif; ?>

                <!-- Exam Form Card -->
                <div class="card shadow mb-4">
                    <div class="card-body">
                        <form method="POST" action="<?= BASE_URL ?>/admin.php?action=newExam">

                            <!-- Subject -->
                            <div class="form-group mb-3">
                                <label>Subject:</label>
                                <select name="subject_id" class="form-control" required>
                                    <option value="">-- Select Subject --</option>
                                    <?php foreach ($results['subjects'] as $sub): ?>
                                        <option value="<?= $sub['subject_id'] ?>"
                                            <?= (isset($results['subject_id']) && $sub['subject_id'] == $results['subject_id']) ? 'selected' : '' ?>>
                                            <?= htmlspecialchars($sub['subject_name']) ?>
                                        </option>
                                    <?php endforeach; ?>
                                </select>
                            </div>

                            <!-- Exam Title -->
                            <div class="form-group mb-3">
                                <label>Exam Title:</label>
                                <input type="text" name="exam_title" class="form-control" required
                                    value="<?= htmlspecialchars($results['exam_title'] ?? '') ?>">
                            </div>

                            <!-- Duration -->
                            <div class="form-group mb-3">
                                <label>Duration (minutes):</label>
                                <input type="number" name="duration_minutes" class="form-control" 
                                    value="<?= htmlspecialchars($results['duration_minutes'] ?? 30) ?>" min="1">
                            </div>

                            <!-- Total Marks -->
                            <div class="form-group mb-3">
                                <label>Total Marks (optional):</label>
                                <input type="number" step="0.01" name="total_marks" class="form-control" 
                                    value="<?= htmlspecialchars($results['total_marks'] ?? '') ?>">
                            </div>

                            <!-- Start & End Date -->
                            <div class="form-group mb-3">
                                <label>Start Date & Time:</label>
                                <input type="datetime-local" name="start_date" class="form-control"
                                    value="<?= !empty($results['start_date']) ? date('Y-m-d\TH:i', strtotime($results['start_date'])) : '' ?>">
                            </div>

                            <div class="form-group mb-3">
                                <label>End Date & Time:</label>
                                <input type="datetime-local" name="end_date" class="form-control"
                                    value="<?= !empty($results['end_date']) ? date('Y-m-d\TH:i', strtotime($results['end_date'])) : '' ?>">
                            </div>

                            <!-- Status -->
                            <div class="form-group mb-3">
                                <label>Status:</label>
                                <select name="status" class="form-control">
                                    <option value="Active" <?= (isset($results['status']) && $results['status'] == 'Active') ? 'selected' : '' ?>>Active</option>
                                    <option value="Inactive" <?= (isset($results['status']) && $results['status'] == 'Inactive') ? 'selected' : '' ?>>Inactive</option>
                                </select>
                            </div>

                            <!-- Questions (Checkbox List) -->
                            <div class="form-group mb-3">
                                <label>Questions:</label>

                                <div class="border rounded p-3" style="max-height: 300px; overflow-y: auto;">
                                    <?php foreach ($results['questions'] as $q): ?>
                                        <div class="form-check mb-2">
                                            <input 
                                                type="checkbox" 
                                                class="form-check-input"
                                                name="questions[]" 
                                                value="<?= $q['question_id'] ?>"
                                                <?= (isset($results['questions_selected']) && in_array($q['question_id'], $results['questions_selected'])) ? 'checked' : '' ?>
                                            >
                                            <label class="form-check-label">
                                                <?= htmlspecialchars($q['question_text']) ?>
                                            </label>
                                        </div>
                                    <?php endforeach; ?>
                                </div>
                            </div>

                            <!-- Submit Button -->
                            <button type="submit" class="btn btn-primary">Add Exam</button>
                            <a href="<?= BASE_URL ?>/admin.php?action=manageExams" class="btn btn-secondary">Cancel</a>

                        </form>
                    </div>
                </div>

            </div>
        </div>

        <!-- Footer -->
        <?php include __DIR__ . "/../include/footer.php"; ?>

    </div>
</div>

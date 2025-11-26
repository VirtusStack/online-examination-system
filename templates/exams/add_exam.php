<?php
// /templates/exams/add_exam.php
require_once __DIR__ . '/../../config/config.php';
?>
<?php include __DIR__ . "/../include/header.php"; ?>

<div id="wrapper">

    <?php include __DIR__ . "/../include/sidebar.php"; ?>

    <div id="content-wrapper" class="d-flex flex-column">

        <div id="content">

            <?php include __DIR__ . "/../include/navbar.php"; ?>

            <div class="container-fluid">

                <h1 class="h3 mb-4 text-gray-800">
                    <?= $results['pageTitle'] ?? 'Add Exam' ?>
                </h1>

                <!-- Error / Success Message -->
                <?php if (!empty($results['message'])): ?>
                    <div class="alert <?= stripos($results['message'], 'success') !== false ? 'alert-success' : 'alert-danger' ?> alert-dismissible fade show">
                        <?= htmlspecialchars($results['message']) ?>
                        <button type="button" class="close" data-dismiss="alert"><span>&times;</span></button>
                    </div>
                <?php endif; ?>

                <div class="card shadow mb-4">
                    <div class="card-body">

                        <!-- FORM: No bank dropdown -->
                        <form method="POST" action="<?= BASE_URL ?>/admin.php?action=newExam">

                            <!-- Exam Title -->
                            <div class="form-group">
                                <label>Exam Title:</label>
                                <input type="text" name="exam_title" class="form-control" required
                                    value="<?= htmlspecialchars($results['exam_title'] ?? '') ?>">
                            </div>

                            <!-- SUBJECTS MULTI SELECT -->
                            <div class="form-group">
                                <label>Select Subjects:</label>
                                <select name="subject_ids[]" class="form-control" multiple required>
                                    <?php foreach ($results['subjects'] as $sub): ?>
                                        <option value="<?= $sub['subject_id'] ?>">
                                            <?= htmlspecialchars($sub['subject_name']) ?>
                                        </option>
                                    <?php endforeach; ?>
                                </select>
                                <small class="text-muted">Hold CTRL to select multiple subjects.</small>
                            </div>

                            <!-- Difficulty distribution -->
                            <div class="form-group">
                                <label>Difficulty Distribution:</label>
                                <div class="row">
                                    <div class="col-md-4">
                                        <label>Easy %</label>
                                        <input type="number" class="form-control" name="easy_percent" min="0" max="100" value="30">
                                    </div>
                                    <div class="col-md-4">
                                        <label>Medium %</label>
                                        <input type="number" class="form-control" name="medium_percent" min="0" max="100" value="50">
                                    </div>
                                    <div class="col-md-4">
                                        <label>Hard %</label>
                                        <input type="number" class="form-control" name="hard_percent" min="0" max="100" value="20">
                                    </div>
                                </div>
                                <small class="text-muted">
                                    Questions will be picked based on total questions and difficulty percentages.
                                </small>
                            </div>

                            <!-- Total Questions -->
                            <div class="form-group">
                                <label>Total Questions:</label>
                                <input type="number" class="form-control" name="total_questions" min="1" required value="10">
                            </div>

                            <!-- Duration -->
                            <div class="form-group">
                                <label>Duration (Minutes):</label>
                                <input type="number" class="form-control" name="duration_minutes" min="1" required value="30">
                            </div>

                            <!-- Shuffle toggles -->
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" name="shuffle_questions" checked>
                                <label class="form-check-label">Shuffle Questions</label>
                            </div>

                            <div class="form-check mb-3">
                                <input class="form-check-input" type="checkbox" name="shuffle_options" checked>
                                <label class="form-check-label">Shuffle Options</label>
                            </div>

                            <!-- Start / End Time -->
                            <div class="form-group">
                                <label>Start Time:</label>
                                <input type="datetime-local" class="form-control" name="start_time">
                            </div>

                            <div class="form-group">
                                <label>End Time:</label>
                                <input type="datetime-local" class="form-control" name="end_time">
                            </div>

                            <!-- Marks -->
                            <div class="form-group">
                                <label>Passing Marks:</label>
                                <input type="number" class="form-control" name="passing_marks" step="0.01" value="0">
                            </div>

                            <div class="form-group">
                                <label>Negative Marking:</label>
                                <input type="number" class="form-control" name="negative_marking" step="0.01" value="0">
                            </div>

                            <!-- Status -->
                            <div class="form-group">
                                <label>Status:</label>
                                <select name="status" class="form-control">
                                    <option value="Active">Active</option>
                                    <option value="Inactive">Inactive</option>
                                </select>
                            </div>

                            <button type="submit" class="btn btn-primary">Create Exam</button>

                        </form>

                    </div>
                </div>

            </div>

        </div>

        <?php include __DIR__ . "/../include/footer.php"; ?>

    </div>

</div>

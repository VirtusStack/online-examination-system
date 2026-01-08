<?php 
// /templates/results/view_result.php
// -------------------------------------
// Displays a single exam result with all details:
// - Exam info
// - Student info
// - Marks summary
// - List of answered questions
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

                <!-- Page Title -->
                <div class="d-flex justify-content-between align-items-center mb-4">
                    <h1 class="h3 text-gray-800"><?= htmlspecialchars($results['pageTitle']) ?></h1>
                    <a href="<?= BASE_URL ?>/admin.php?action=manageResults" class="btn btn-secondary">
                        <i class="fas fa-arrow-left"></i> Back
                    </a>
                </div>

                <!-- Message -->
                <?php if (!empty($results['message'])): ?>
                    <div class="alert alert-danger">
                        <?= htmlspecialchars($results['message']) ?>
                    </div>
                <?php endif; ?>

                <?php if (!empty($results['exam'])): ?>

                <!-- Exam Info Card -->
                <div class="card shadow mb-4">
                    <div class="card-header bg-primary text-white">
                        <h6 class="m-0 font-weight-bold">Exam Information</h6>
                    </div>
                    <div class="card-body">

                        <div class="row mb-3">
                            <div class="col-md-4"><strong>Exam Title:</strong></div>
                            <div class="col-md-8"><?= htmlspecialchars($results['exam']['exam_title']) ?></div>
                        </div>

                        <div class="row mb-3">
                            <div class="col-md-4"><strong>Total Marks:</strong></div>
                            <div class="col-md-8"><?= htmlspecialchars($results['exam']['total_marks']) ?></div>
                        </div>

                        <div class="row mb-3">
                            <div class="col-md-4"><strong>Passing Marks:</strong></div>
                            <div class="col-md-8"><?= htmlspecialchars($results['exam']['pass_marks']) ?></div>
                        </div>

                        <div class="row">
                            <div class="col-md-4"><strong>Duration:</strong></div>
                            <div class="col-md-8"><?= htmlspecialchars($results['exam']['duration_minutes']) ?> minutes</div>
                        </div>

                    </div>
                </div>

                <!-- Student Info Card -->
                <div class="card shadow mb-4">
                    <div class="card-header bg-info text-white">
                        <h6 class="m-0 font-weight-bold">Student Information</h6>
                    </div>
                    <div class="card-body">

                        <div class="row mb-3">
                            <div class="col-md-4"><strong>Name:</strong></div>
                            <div class="col-md-8"><?= htmlspecialchars($results['student']['name']) ?></div>
                        </div>

                        <div class="row mb-3">
                            <div class="col-md-4"><strong>Email:</strong></div>
                            <div class="col-md-8"><?= htmlspecialchars($results['student']['email']) ?></div>
                        </div>

                        <div class="row mb-3">
                            <div class="col-md-4"><strong>Started At:</strong></div>
                            <div class="col-md-8"><?= htmlspecialchars($results['student']['started_at']) ?></div>
                        </div>

                        <div class="row">
                            <div class="col-md-4"><strong>Submitted At:</strong></div>
                            <div class="col-md-8"><?= htmlspecialchars($results['student']['submitted_at']) ?></div>
                        </div>

                    </div>
                </div>

                <!-- Marks Summary Card -->
                <div class="card shadow mb-4">
                    <div class="card-header bg-success text-white">
                        <h6 class="m-0 font-weight-bold">Marks Summary</h6>
                    </div>
                    <div class="card-body text-center">

                        <h3>Total: <?= htmlspecialchars($results['total_marks']) ?> Marks</h3>
                        <h4 class="mt-3">
                            Obtained: 
                            <span class="<?= ($results['obtained'] >= $results['exam']['pass_marks']) ? 'text-success' : 'text-danger' ?>">
                                <?= htmlspecialchars($results['obtained']) ?>
                            </span>
                        </h4>

			<h5 class="mt-3">
    			Percentage:
    			<span class="text-info">
        			<?= htmlspecialchars($results['percentage']) ?>%
    			</span>
			</h5>

                        <h5 class="mt-3">
                            Status: 
                            <?php if ($results['obtained'] >= $results['exam']['pass_marks']): ?>
                                <span class="badge bg-success text-white">PASSED</span>
                            <?php else: ?>
                                <span class="badge bg-danger text-white">FAILED</span>
                            <?php endif; ?>
                        </h5>

                    </div>
                </div>

                <!-- Questions Table -->
                <div class="card shadow mb-4">
                    <div class="card-header bg-dark text-white">
                        <h6 class="m-0 font-weight-bold">Answered Questions</h6>
                    </div>

                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="table table-bordered table-striped">
                                <thead class="table-light">
                                    <tr>
                                        <th>#</th>
                                        <th>Question</th>
                                        <th>Correct Option</th>
                                        <th>Selected Option</th>
                                        <th>Is Correct?</th>
                                    </tr>
                                </thead>
                                <tbody>

                                    <?php if (!empty($results['questions'])): ?>
                                        <?php foreach ($results['questions'] as $index => $q): ?>
                                            <tr>
                                                <td><?= $index + 1 ?></td>
                                                <td><?= htmlspecialchars($q['question_text']) ?></td>
                                                <td><?= htmlspecialchars($q['correct_option']) ?></td>
                                                <td><?= htmlspecialchars($q['selected_option']) ?></td>

                                                <td>
                                                    <?php if ($q['is_correct'] == 1): ?>
                                                        <span class="badge bg-success">Correct</span>
                                                    <?php else: ?>
                                                        <span class="badge bg-danger">Wrong</span>
                                                    <?php endif; ?>
                                                </td>
                                            </tr>
                                        <?php endforeach; ?>
                                    <?php else: ?>
                                        <tr>
                                            <td colspan="5" class="text-center">No questions found.</td>
                                        </tr>
                                    <?php endif; ?>

                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>

                <?php endif; ?>

            </div>

        </div>

        <!-- Footer -->
        <?php include __DIR__ . "/../include/footer.php"; ?>

    </div>

</div>

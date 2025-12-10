<?php
// /templates/results/view_result.php
// -------------------------
// Displays detailed exam result for a student
// Shows exam info, student info, questions, answers, marks, and status

$result = $result ?? [
    'exam'        => [],
    'student'     => [],
    'questions'   => [],
    'total_marks' => 0,
    'obtained'    => 0,
    'status'      => ''
];
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
                <div class="d-flex justify-content-between align-items-center mb-4">
                    <h1 class="h3 text-gray-800">View Result - <?= htmlspecialchars($result['student']['name'] ?? '-') ?></h1>
                    <a href="<?= BASE_URL ?>/admin.php?action=manageResults" class="btn btn-secondary">
                        <i class="bi bi-arrow-left"></i> Back to Results
                    </a>
                </div>

                <!-- Exam & Student Info Card -->
                <div class="card shadow mb-4">
                    <div class="card-header py-3">
                        <h6 class="m-0 font-weight-bold text-gray-800">Exam & Student Information</h6>
                    </div>
                    <div class="card-body">
                        <div class="row mb-3">
                            <div class="col-md-6">
                                <p><strong>Exam Title:</strong> <?= htmlspecialchars($result['exam']['exam_title'] ?? '-') ?></p>
                                <p><strong>Total Marks:</strong> <?= $result['exam']['total_marks'] ?? 0 ?></p>
                                <p><strong>Pass Marks:</strong> <?= $result['exam']['pass_marks'] ?? 0 ?></p>
                                <p><strong>Duration:</strong> <?= $result['exam']['duration_minutes'] ?? 0 ?> minutes</p>
                            </div>
                            <div class="col-md-6">
                                <p><strong>Student Name:</strong> <?= htmlspecialchars($result['student']['name'] ?? '-') ?></p>
                                <p><strong>Email:</strong> <?= htmlspecialchars($result['student']['email'] ?? '-') ?></p>
                                <p><strong>Started At:</strong> <?= htmlspecialchars($result['student']['started_at'] ?? '-') ?></p>
                                <p><strong>Submitted At:</strong> <?= htmlspecialchars($result['student']['submitted_at'] ?? '-') ?></p>
                            </div>
                        </div>

                        <!-- Result Summary -->
                        <div class="mb-3">
                            <p><strong>Obtained Marks:</strong> <?= $result['obtained'] ?? 0 ?> / <?= $result['total_marks'] ?? 0 ?></p>
                            <p><strong>Status:</strong> 
                                <?php if (($result['obtained'] ?? 0) >= ($result['exam']['pass_marks'] ?? 0)): ?>
                                    <span class="text-success font-weight-bold">Pass</span>
                                <?php else: ?>
                                    <span class="text-danger font-weight-bold">Fail</span>
                                <?php endif; ?>
                            </p>
                        </div>
                    </div>
                </div>
                <!-- End Exam & Student Info Card -->

                <!-- Questions & Answers Card -->
                <div class="card shadow mb-4">
                    <div class="card-header py-3">
                        <h6 class="m-0 font-weight-bold text-gray-800">Questions & Answers</h6>
                    </div>
                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="table table-bordered table-striped">
                                <thead class="table-light">
                                    <tr>
                                        <th>#</th>
                                        <th>Question</th>
                                        <th>Student Answer</th>
                                        <th>Correct Answer</th>
                                        <th>Marks Obtained</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php if (!empty($result['questions'])): ?>
                                        <?php foreach ($result['questions'] as $index => $q): ?>
                                            <tr>
                                                <td><?= $index + 1 ?></td>
                                                <td><?= htmlspecialchars($q['question_text'] ?? '-') ?></td>
                                                <td>
                                                    <?php if(isset($q['student_answer'])): ?>
                                                        <?php if($q['is_correct']): ?>
                                                            <span class="text-success"><?= htmlspecialchars($q['student_answer']) ?></span>
                                                        <?php else: ?>
                                                            <span class="text-danger"><?= htmlspecialchars($q['student_answer']) ?></span>
                                                        <?php endif; ?>
                                                    <?php else: ?>
                                                        <span class="text-muted">Not answered</span>
                                                    <?php endif; ?>
                                                </td>
                                                <td><?= htmlspecialchars($q['correct_answer'] ?? '-') ?></td>
                                                <td><?= $q['marks_obtained'] ?? 0 ?></td>
                                            </tr>
                                        <?php endforeach; ?>
                                    <?php else: ?>
                                        <tr>
                                            <td colspan="5" class="text-center">No questions found for this result.</td>
                                        </tr>
                                    <?php endif; ?>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
                <!-- End Questions & Answers Card -->

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

<?php
// /templates/exams/view_exam.php
// ---------------------------------------------
// VIEW EXAM DETAILS PAGE
// Shows complete exam information with subject,
// question bank, assigned questions & exam links
// ---------------------------------------------

$exam          = $results['exam'] ?? null;
$subject       = $results['subject'] ?? null;
$questionBank  = $results['question_bank'] ?? null;
$questions     = $results['questions'] ?? [];
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
                    <h1 class="h3 text-gray-800"><?= htmlspecialchars($results['pageTitle']) ?></h1>

                    <div>
                        <a href="<?= BASE_URL ?>/admin.php?action=editExam&id=<?= $exam['exam_id'] ?>" class="btn btn-warning">
                            <i class="bi bi-pencil-square"></i> Edit
                        </a>
                        <a href="<?= BASE_URL ?>/admin.php?action=examLinks&id=<?= $exam['exam_id'] ?>" class="btn btn-success">
                            <i class="bi bi-link-45deg"></i> Links
                        </a>
                        <a href="<?= BASE_URL ?>/admin.php?action=assignQuestions&id=<?= $exam['exam_id'] ?>" class="btn btn-primary">
                            <i class="bi bi-list-check"></i> Assign Questions
                        </a>
                    </div>
                </div>

                <!-- Error / Success Message -->
                <?php if (!empty($results['message'])): ?>
                    <div class="alert alert-danger">
                        <?= htmlspecialchars($results['message']) ?>
                    </div>
                <?php endif; ?>

                <!-- Exam Details Card -->
                <div class="card shadow mb-4">
                    <div class="card-header py-3 bg-light">
                        <h6 class="m-0 font-weight-bold text-dark">Exam Details</h6>
                    </div>

                    <div class="card-body">
                        <table class="table table-bordered">
                            <tr>
                                <th width="250">Exam Title</th>
                                <td><?= htmlspecialchars($exam['exam_title']) ?></td>
                            </tr>

                            <tr>
                                <th>Description</th>
                                <td><?= htmlspecialchars($exam['exam_description'] ?? '-') ?></td>
                            </tr>

                            <tr>
                                <th>Subject</th>
                                <td><?= $subject ? htmlspecialchars($subject['subject_name']) : '-' ?></td>
                            </tr>

                            <tr>
                                <th>Question Bank</th>
                                <td><?= $questionBank ? htmlspecialchars($questionBank['bank_name']) : '-' ?></td>
                            </tr>

                            <tr>
                                <th>Total Questions</th>
                                <td><?= htmlspecialchars($exam['total_questions']) ?></td>
                            </tr>

                            <tr>
                                <th>Duration</th>
                                <td><?= htmlspecialchars($exam['duration_minutes']) ?> minutes</td>
                            </tr>

                            <tr>
                                <th>Start Time</th>
                                <td><?= htmlspecialchars($exam['start_time'] ?? '-') ?></td>
                            </tr>

                            <tr>
                                <th>End Time</th>
                                <td><?= htmlspecialchars($exam['end_time'] ?? '-') ?></td>
                            </tr>

                            <tr>
                                <th>Status</th>
                                <td><?= htmlspecialchars($exam['status']) ?></td>
                            </tr>
                        </table>
                    </div>
                </div>

                <!-- Assigned Questions -->
                <div class="card shadow mb-4">
                    <div class="card-header py-3 bg-light">
                        <h6 class="m-0 font-weight-bold text-dark">Assigned Questions</h6>
                    </div>

                    <div class="card-body">
                        <?php if (!empty($questions)): ?>
                            <ul class="list-group">
                                <?php foreach ($questions as $q): ?>
                                    <li class="list-group-item">
                                        <?= htmlspecialchars($q['question_text']) ?>
                                    </li>
                                <?php endforeach; ?>
                            </ul>
                        <?php else: ?>
                            <p class="text-muted">No questions assigned to this exam.</p>
                        <?php endif; ?>
                    </div>
                </div>

            </div>

        </div>

        <!-- Footer -->
        <?php include __DIR__ . "/../include/footer.php"; ?>

    </div>

</div>

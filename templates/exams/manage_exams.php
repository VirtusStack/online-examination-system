<?php 
// /templates/exams/manage_exams.php
// ----------------------------------
// Displays all exams with Edit/Delete/View actions
// Shows subjects + difficulty percentages
// Includes pagination

$results = $results ?? [
    'pageTitle'   => 'Manage Exams',
    'message'     => '',
    'exams'       => [],
    'currentPage' => 1,
    'totalPages'  => 1,
    'total'       => 0,
    'perPage'     => 25
];

$exams       = $results['exams'];
$currentPage = (int)($results['currentPage'] ?? 1);
$totalPages  = (int)($results['totalPages'] ?? 1);
$total       = (int)($results['total'] ?? count($exams));
$perPage     = (int)($results['perPage'] ?? count($exams));
$offset      = ($currentPage - 1) * $perPage;
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

                <!-- Page Heading with Add Exam Button -->
                <div class="d-flex justify-content-between align-items-center mb-4">
                    <h1 class="h3 text-gray-800"><?= htmlspecialchars($results['pageTitle']) ?></h1>
                    <a href="<?= BASE_URL ?>/admin.php?action=newExam" class="btn btn-primary">
                        <i class="bi bi-plus-circle"></i> Add Exam
                    </a>
                </div>

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

                <!-- Exams Table Card -->
                <div class="card shadow mb-4">
                    <div class="card-header py-3">
                        <h6 class="m-0 font-weight-bold text-gray-800"><?= htmlspecialchars($results['pageTitle']) ?></h6>
                    </div>

                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="table table-bordered table-striped">
                                <thead class="table-light">
                                    <tr>
                                        <th>ID</th>
                                        <th>Title</th>
                                        <th>Subjects</th>
                                        <th>Total Questions</th>
                                        <th>Duration (min)</th>
                                        <th>Start / End</th>
                                        <th>Status</th>
                                        <th>Exam Link</th>
                                        <th>Actions</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php if (!empty($exams)): ?>
                                        <?php foreach ($exams as $exam): ?>
                                            <?php
                                            // --- Fetch DISTINCT subjects for this exam
                                            $stmt = $pdo->prepare("
                                                SELECT DISTINCT s.subject_name
                                                FROM exam_question_sources eqs
                                                JOIN subjects s ON eqs.subject_id = s.subject_id
                                                WHERE eqs.exam_id = ?
                                            ");
                                            $stmt->execute([$exam['exam_id']]);
                                            $subjectRows = $stmt->fetchAll(PDO::FETCH_ASSOC);

                                            // --- Get difficulty percentages from exam table
                                            $easy_pct   = $exam['easy_percentage'] ?? 0;
                                            $medium_pct = $exam['medium_percentage'] ?? 0;
                                            $hard_pct   = $exam['hard_percentage'] ?? 0;

                                            // --- Format subjects with percentages
                                            $subjectList = [];
                                            foreach ($subjectRows as $row) {
                                                $subjectList[] = $row['subject_name'] 
                                                    . " (E {$easy_pct}%, M {$medium_pct}%, H {$hard_pct}%)";
                                            }

                                            // Fetch first unique link for preview / email
						$stmtLink = $pdo->prepare("SELECT unique_link FROM exam_links WHERE exam_id=? LIMIT 1");
						$stmtLink->execute([$exam['exam_id']]);
						$linkCode = $stmtLink->fetchColumn();

					   // New email-ready link
						$fullLink = $linkCode ? BASE_URL . "/student.php?action=examAccess&code=" . $linkCode : '';

                                            ?>
                                            <tr>
                                                <td><?= $exam['exam_id'] ?></td>
                                                <td><?= htmlspecialchars($exam['exam_title']) ?></td>
                                                <td><?= !empty($subjectList) ? implode(', ', $subjectList) : '-' ?></td>
                                                <td><?= htmlspecialchars($exam['total_questions'] ?? '-') ?></td>
                                                <td><?= htmlspecialchars($exam['duration_minutes'] ?? '-') ?></td>
                                                <td>
                                                    <?= !empty($exam['start_time']) ? htmlspecialchars($exam['start_time']) : '-' ?> /
                                                    <?= !empty($exam['end_time']) ? htmlspecialchars($exam['end_time']) : '-' ?>
                                                </td>
                                                <td><?= ($exam['start_time'] <= date('Y-m-d H:i:s') && $exam['end_time'] >= date('Y-m-d H:i:s')) ? 'Active' : 'Inactive' ?></td>
                                                <td>
                                                    <?php if ($fullLink): ?>
                                                        <a href="<?= htmlspecialchars($fullLink) ?>" target="_blank"><?= htmlspecialchars($fullLink) ?></a>
                                                    <?php else: ?>
                                                        -
                                                    <?php endif; ?>
                                                </td>
                                                <td>
                                                    <a class="btn btn-sm btn-warning me-1 mb-1" href="<?= BASE_URL ?>/admin.php?action=editExam&id=<?= $exam['exam_id'] ?>">
                                                        <i class="bi bi-pencil-square"></i> Edit
                                                    </a>
                                                    <form method="get" action="<?= BASE_URL ?>/admin.php" style="display:inline-block;" onsubmit="return confirm('Are you sure you want to delete this exam?');">
                                                        <input type="hidden" name="action" value="manageExams">
                                                        <input type="hidden" name="delete" value="<?= $exam['exam_id'] ?>">
                                                        <button type="submit" class="btn btn-sm btn-danger me-1 mb-1">
                                                            <i class="bi bi-trash"></i> Delete
                                                        </button>
                                                    </form>
                                                 </td>
                                            </tr>
                                        <?php endforeach; ?>
                                    <?php else: ?>
                                        <tr>
                                            <td colspan="9" class="text-center">No exams found.</td>
                                        </tr>
                                    <?php endif; ?>
                                </tbody>
                            </table>
                        </div>

                        <!-- Pagination -->
                        <?php if ($totalPages >= 1): ?>
                        <nav aria-label="Pagination" class="mt-4">
                            <ul class="pagination justify-content-center align-items-center">
                                <li class="page-item <?= ($currentPage <= 1) ? 'disabled' : '' ?>">
                                    <a class="page-link" href="<?= BASE_URL ?>/admin.php?action=manageExams&page=<?= max(1, $currentPage - 1) ?>">Prev</a>
                                </li>
                                <?php
                                $start = max(1, $currentPage - 2);
                                $end   = min($totalPages, $currentPage + 2);
                                for ($i = $start; $i <= $end; $i++): ?>
                                    <li class="page-item <?= ($i === $currentPage) ? 'active' : '' ?>">
                                        <a class="page-link" href="<?= BASE_URL ?>/admin.php?action=manageExams&page=<?= $i ?>"><?= $i ?></a>
                                    </li>
                                <?php endfor; ?>
                                <li class="page-item <?= ($currentPage >= $totalPages) ? 'disabled' : '' ?>">
                                    <a class="page-link" href="<?= BASE_URL ?>/admin.php?action=manageExams&page=<?= min($totalPages, $currentPage + 1) ?>">Next</a>
                                </li>
                                <li class="page-item ms-3">
                                    <form method="get" action="<?= BASE_URL ?>/admin.php" class="form-inline">
                                        <input type="hidden" name="action" value="manageExams">
                                        <input type="number" min="1" max="<?= $totalPages ?>" name="page" class="form-control form-control-sm" style="width:70px" value="<?= $currentPage ?>">
                                        <button type="submit" class="btn btn-sm btn-primary">Go</button>
                                    </form>
                                </li>
                            </ul>
                        </nav>
                        <?php endif; ?>

                    </div>
                </div>

            </div>

        </div>

        <!-- Footer -->
        <?php include __DIR__ . "/../include/footer.php"; ?>
    </div>
</div>

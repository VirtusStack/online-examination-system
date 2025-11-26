<?php
// /templates/exams/view_results.php
// -------------------------
// Admin panel: View all exam results with student details
require_once __DIR__ . '/../../config/config.php';

$resultsData = $results['results'] ?? [];
$message = $results['message'] ?? '';
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

                <h1 class="h3 mb-4 text-gray-800"><?= $results['pageTitle'] ?? 'Exam Results' ?></h1>

                <!-- Feedback message -->
                <?php if (!empty($message)): ?>
                    <div class="alert <?= (stripos($message, 'success') !== false) ? 'alert-success' : 'alert-danger' ?> alert-dismissible fade show" role="alert">
                        <?= htmlspecialchars($message) ?>
                        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                <?php endif; ?>

                <!-- Results Table -->
                <div class="card shadow mb-4">
                    <div class="card-body table-responsive">
                        <table class="table table-bordered table-striped">
                            <thead class="table-light">
                                <tr>
                                    <th>Student Name</th>
                                    <th>Email</th>
                                    <th>Class/Standard</th>
                                    <th>Exam</th>
                                    <th>Obtained Marks</th>
                                    <th>Total Marks</th>
                                    <th>Started At</th>
                                    <th>Submitted At</th>
                                    <th>Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php if (!empty($resultsData)): ?>
                                    <?php foreach ($resultsData as $row): ?>
                                        <tr>
                                            <td><?= htmlspecialchars($row['student_name']) ?></td>
                                            <td><?= htmlspecialchars($row['student_email'] ?? '-') ?></td>
                                            <td><?= htmlspecialchars($row['student_class'] ?? '-') ?></td>
                                            <td><?= htmlspecialchars($row['exam_title']) ?></td>
                                            <td><?= htmlspecialchars($row['obtained_marks']) ?></td>
                                            <td><?= htmlspecialchars($row['total_marks']) ?></td>
                                            <td><?= htmlspecialchars($row['started_at'] ?? '-') ?></td>
                                            <td><?= htmlspecialchars($row['submitted_at'] ?? '-') ?></td>
                                            <td>
                                                <a class="btn btn-sm btn-info" href="<?= BASE_URL ?>/admin.php?action=viewAnswers&result_id=<?= $row['result_id'] ?>">
                                                    <i class="bi bi-eye"></i> View Answers
                                                </a>
                                            </td>
                                        </tr>
                                    <?php endforeach; ?>
                                <?php else: ?>
                                    <tr>
                                        <td colspan="9" class="text-center">No results found.</td>
                                    </tr>
                                <?php endif; ?>
                            </tbody>
                        </table>
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

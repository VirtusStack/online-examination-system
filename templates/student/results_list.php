<?php
// /templates/student/results_list.php
// ------------------------------------------------------------
// Student Results List
// Shows published exam results
// Click View → viewResult page
// ------------------------------------------------------------

include __DIR__ . "/header.php";
include __DIR__ . "/sidebar.php";
?>

<div id="content-wrapper" class="d-flex flex-column">
    <div id="content">

        <?php include __DIR__ . "/topbar.php"; ?>

        <div class="container-fluid">

            <!-- Page Heading -->
            <h1 class="h3 mb-4 text-gray-800">My Results</h1>

            <?php if (empty($results)) : ?>
                <div class="alert alert-info">
                    No results published yet.
                </div>
            <?php else : ?>

                <div class="card shadow mb-4">
                    <div class="card-header py-3">
                        <h6 class="m-0 font-weight-bold text-primary">
                            Published Results
                        </h6>
                    </div>

                    <div class="card-body">
                        <div class="table-responsive">

                            <table class="table table-bordered">
                                <thead class="bg-light">
                                    <tr>
                                        <th>Exam</th>
                                        <th>Total Marks</th>
                                        <th>Obtained</th>
                                        <th>Status</th>
                                        <th>Submitted At</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>

                                <tbody>
                                <?php foreach ($results as $row): ?>
                                    <tr>
                                        <td><?= htmlspecialchars($row['exam_title']) ?></td>
                                        <td><?= $row['total_marks'] ?></td>
                                        <td><?= $row['obtained_marks'] ?></td>
                                        <td>
                                            <?php if ($row['obtained_marks'] >= $row['pass_marks']): ?>
                                                <span class="badge badge-success">Passed</span>
                                            <?php else: ?>
                                                <span class="badge badge-danger">Failed</span>
                                            <?php endif; ?>
                                        </td>
                                        <td><?= date('d M Y h:i A', strtotime($row['submitted_at'])) ?></td>
                                        <td>
                                            <a href="student.php?action=viewStudentResult&result_id=<?= $row['result_id'] ?>"
                                               class="btn btn-primary btn-sm">
                                                View Result
                                            </a>
                                        </td>
                                    </tr>
                                <?php endforeach; ?>
                                </tbody>

                            </table>

                        </div>
                    </div>
                </div>

            <?php endif; ?>

        </div>
        <!-- /.container-fluid -->

    </div>

    <?php include __DIR__ . "/footer.php"; ?>
</div>

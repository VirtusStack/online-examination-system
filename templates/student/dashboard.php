<?php
// /templates/student/dashboard.php
// -----------------------------------------------------------
// Student Dashboard Template
// Shows welcome message, assigned exams list, profile box
// Uses student header, sidebar, footer
// -----------------------------------------------------------

include __DIR__ . "/header.php";
include __DIR__ . "/sidebar.php";
?>

<!-- Content Wrapper -->
<div id="content-wrapper" class="d-flex flex-column">

    <!-- Main Content -->
    <div id="content">

        <?php include __DIR__ . "/topbar.php"; ?>

        <!-- Begin Page Content -->
        <div class="container-fluid">

            <!-- Page Heading -->
            <h1 class="h3 mb-4 text-gray-800">
                Welcome, <?= htmlspecialchars($results['studentName']) ?> 
            </h1>

            <div class="row">

                <!-- Profile Card -->
                <div class="col-xl-4 col-md-6 mb-4">
                    <div class="card border-left-primary shadow h-100 py-2">
                        <div class="card-body">
                            <div class="row no-gutters align-items-center">
                                <div class="col mr-2">
                                    <div class="text-xs font-weight-bold text-primary text-uppercase mb-1">
                                        Student Profile
                                    </div>
                                    <div class="h5 mb-0 font-weight-bold text-gray-800">
                                        <?= htmlspecialchars($results['studentName']) ?>
                                    </div>
                                    <a href="#" class="mt-2 d-block small text-primary">View Profile</a>
                                </div>
                                <div class="col-auto">
                                    <i class="fas fa-user-graduate fa-2x text-gray-300"></i>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Total Assigned Exams -->
                <div class="col-xl-4 col-md-6 mb-4">
                    <div class="card border-left-success shadow h-100 py-2">
                        <div class="card-body">
                            <div class="row no-gutters align-items-center">
                                <div class="col mr-2">
                                    <div class="text-xs font-weight-bold text-success text-uppercase mb-1">
                                        Assigned Exams
                                    </div>
                                    <div class="h5 mb-0 font-weight-bold text-gray-800">
                                        <?= count($results['assignedExams']); ?>
                                    </div>
                                </div>
                                <div class="col-auto">
                                    <i class="fas fa-file-alt fa-2x text-gray-300"></i>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

            </div> <!-- Row end -->

            <!-- Assigned Exams Table -->
            <div class="card shadow mb-4">
                <div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold text-primary">Your Upcoming Exams</h6>
                </div>

                <div class="card-body">

                    <?php if (empty($results['assignedExams'])): ?>
                        <div class="alert alert-info">No exams assigned yet.</div>
                    <?php else: ?>

                        <div class="table-responsive">
                            <table class="table table-bordered">
                                <thead>
                                <tr>
                                    <th>Exam Name</th>
                                    <th>Subjects</th>
                                    <th>Date</th>
                                    <th>Duration</th>
                                    <th>Total Questions</th>
                                    <th>Action</th>
                                </tr>
                                </thead>

                                <tbody>
                                <?php foreach ($results['assignedExams'] as $exam): ?>
                                    <tr>
                                        <td><?= htmlspecialchars($exam['exam_title'] ?? 'N/A'); ?></td>
                                        <td><?= htmlspecialchars($exam['subjects'] ?? 'N/A'); ?></td>
                                        <td>
                                            <?= !empty($exam['start_time']) ? date("d M Y", strtotime($exam['start_time'])) : 'N/A'; ?>
                                        </td>
                                        <td><?= $exam['duration'] ?? 0; ?> mins</td>
                                        <td><?= $exam['total_questions'] ?? 0; ?></td>
                                        <td>
                                            <a href="student.php?action=startExam&exam_id=<?= $exam['exam_id']; ?>"
                                               class="btn btn-sm btn-primary">
                                                Start Exam
                                            </a>
                                        </td>
                                    </tr>
                                <?php endforeach; ?>
                                </tbody>
                            </table>
                        </div>

                    <?php endif; ?>

                </div>
            </div>

        </div>
        <!-- /.container-fluid -->

    </div>
    <!-- End of Main Content -->

    <?php include __DIR__ . "/footer.php"; ?>

</div>
<!-- End of Content Wrapper -->

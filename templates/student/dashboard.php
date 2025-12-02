<?php
// /templates/student/dashboard.php
// -----------------------------------------------------------
// Student Dashboard Template
// Shows Welcome message + Assigned Exams list
// Uses student header, sidebar, topbar, footer
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
                Welcome, <?= htmlspecialchars($results['studentName']); ?>
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
                                        <?= htmlspecialchars($results['studentName']); ?>
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
                        <!-- No exams message -->
                        <div class="alert alert-info">No exams assigned yet.</div>

                    <?php else: ?>

                        <div class="table-responsive">
                            <table class="table table-bordered">
                                <thead>
                                <tr>
                                    <th>Exam Name</th>
                                    <th>Subject</th>
                                    <th>Date</th>
                                    <th>Duration</th>
                                    <th>Total Questions</th>
                                    <th>Action</th>
                                </tr>
                                </thead>

                                <tbody>

                                <?php foreach ($results['assignedExams'] as $exam): ?>

                                    <tr>
                                        <!-- Exam Title -->
                                        <td><?= htmlspecialchars($exam['exam_title']); ?></td>

                                        <!-- Subject -->
                                        <td><?= htmlspecialchars($exam['subjects'] ?? 'N/A'); ?></td>

                                        <!-- Exam Date -->
                                        <td>
                                            <?= !empty($exam['start_time']) ? date("d M Y H:i", strtotime($exam['start_time'])) : 'N/A'; ?>
                                        </td>

                                        <!-- Duration -->
                                        <td>
                                            <?= isset($exam['duration_minutes']) 
                                                ? intval($exam['duration_minutes']) . ' mins' 
                                                : (isset($exam['duration']) ? intval($exam['duration']). ' mins' : 'N/A'); ?>
                                        </td>

                                        <!-- Total Questions -->
                                        <td><?= intval($exam['total_questions']); ?></td>

                                        <!-- Start Exam Button -->
                                        <td>
                                            <?php
                                            $now = new DateTime();
                                            $examStart = !empty($exam['start_time']) ? new DateTime($exam['start_time']) : null;
                                            
                                            if (empty($exam['link_id'])) {
                                                // Link not yet generated
                                                echo '<span class="text-danger">Link not ready</span>';
                                            } elseif ($examStart && $now < $examStart) {
                                                // Exam not started yet
                                                echo '<button class="btn btn-sm btn-secondary" disabled>Not Yet Available</button>';
                                            } else {
                                                // Exam can be started
                                                echo '<a href="student.php?action=startExam&exam_id=' 
                                                    . $exam['exam_id'] . '&link_id=' 
                                                    . $exam['link_id'] . '" 
                                                    class="btn btn-sm btn-primary">Start Exam</a>';
                                            }
                                            ?>
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

<?php
// /templates/student/start_exam.php
// -----------------------------------------------------------
// Exam Instructions Page (Start Exam)
// Shows exam details + rules + Start Now button
// Works with: student.php?action=startExam&exam_id=ID
// -----------------------------------------------------------

// Include header only (sidebar hidden)
include __DIR__ . "/header.php";
// Sidebar is hidden for exam instructions
// include __DIR__ . "/sidebar.php";

?>

<!-- Content Wrapper -->
<div id="content-wrapper" class="d-flex flex-column">

    <!-- Main Content -->
    <div id="content">

        <?php include __DIR__ . "/topbar.php"; ?>

        <!-- Begin Page Content -->
        <div class="container-fluid px-5 py-4" style="max-width: 100%; width:100vw;">

            <!-- Page Heading -->
            <h1 class="h3 mb-4 text-gray-800 text-center">
                Exam Instructions
            </h1>

            <div class="row justify-content-center">

                <div class="col-lg-8">

                    <!-- Exam Card -->
                    <div class="card shadow mb-4">

                        <!-- Card Header -->
                        <div class="card-header py-3">
                            <h6 class="m-0 font-weight-bold text-primary text-center">
                                <?= htmlspecialchars($exam['exam_title'] ?? 'N/A'); ?>
                            </h6>
                        </div>

                        <!-- Card Body -->
                        <div class="card-body">

                            <!-- Exam Details -->
                            <p><strong>Subject:</strong> <?= htmlspecialchars($exam['subject_name'] ?? 'N/A'); ?></p>
                            <p><strong>Total Questions:</strong> <?= intval($exam['total_questions'] ?? 0); ?></p>
                            <p><strong>Duration:</strong> <?= intval($exam['duration_minutes'] ?? 0); ?> minutes</p>
                            <p><strong>Date:</strong> <?= !empty($exam['start_time']) ? date("d M Y", strtotime($exam['start_time'])) : 'N/A'; ?></p>

                            <hr>

                            <!-- Instructions -->
                            <h5 class="font-weight-bold">Important Instructions</h5>
                            <ul>
                                <li>You must complete the exam in one sitting.</li>
                                <li>Timer will start immediately after clicking <b>Start Exam</b>.</li>
                                <li>Do not refresh or close the browser tab during the exam.</li>
                                <li>Each question carries equal marks unless stated otherwise.</li>
                                <li>Do not switch tabs, otherwise your attempt may be auto-submitted.</li>
                                <li>Ensure a stable internet connection.</li>
                                <li>Once submitted, you cannot reattempt the exam.</li>
                            </ul>

                            <hr>

                            <!-- Start Exam Button -->
                            <div class="text-center">
                                <a href="student.php?action=liveExam&exam_id=<?= intval($exam['exam_id'] ?? 0); ?>"
                                   class="btn btn-lg btn-primary">
                                    Start Exam <i class="fas fa-arrow-right ml-2"></i>
                                </a>
                            </div>

                        </div>
                        <!-- End Card Body -->

                    </div>
                    <!-- End Exam Card -->

                </div>
            </div> <!-- row end -->

        </div>
        <!-- /.container-fluid -->

    </div>
    <!-- End of Main Content -->

    <?php include __DIR__ . "/footer.php"; ?>

</div>
<!-- End of Content Wrapper -->


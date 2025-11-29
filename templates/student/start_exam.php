<?php
// /templates/student/start_exam.php
// -----------------------------------------------------------
// Exam Instructions Page
// Shows exam details + rules + Start Now button
// Works with: student.php?action=startExam&exam_id=ID
// -----------------------------------------------------------

// Include header only (do not include sidebar)
include __DIR__ . "/header.php";
// include __DIR__ . "/sidebar.php"; // Sidebar hidden for exam instructions

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

                    <div class="card shadow mb-4">
                        <div class="card-header py-3">
                            <h6 class="m-0 font-weight-bold text-primary text-center">
                                <?= htmlspecialchars($exam['exam_title'] ?? 'N/A'); ?>
                            </h6>
                        </div>

                        <div class="card-body">

                            <p><strong>Subject:</strong> <?= htmlspecialchars($exam['subject_name'] ?? 'N/A'); ?></p>
                            <p><strong>Total Questions:</strong> <?= intval($exam['total_questions'] ?? 0); ?></p>
                            <p><strong>Duration:</strong> <?= intval($exam['duration_minutes'] ?? 0); ?> minutes</p>
                            <p><strong>Date:</strong> <?= date("d M Y", strtotime($exam['start_time'] ?? 'now')); ?></p>

                            <hr>

                            <h5 class="font-weight-bold">Important Instructions</h5>

                            <ul>
                                <li>You must complete the exam in one sitting.</li>
                                <li>Timer will start immediately after clicking <b>Start Exam</b>.</li>
                                <li>You cannot refresh or close the browser tab during the exam.</li>
                                <li>Each question carries equal marks unless mentioned.</li>
                                <li>Do not switch tabs, otherwise your attempt may be auto-submitted.</li>
                                <li>Make sure your internet connection is stable.</li>
                                <li>Once submitted, you cannot reattempt the exam.</li>
                            </ul>

                            <hr>

                            <div class="text-center">
                                <a href="student.php?action=liveExam&exam_id=<?= intval($exam['exam_id'] ?? 0); ?>"
                                   class="btn btn-lg btn-primary">
                                    Start Exam <i class="fas fa-arrow-right ml-2"></i>
                                </a>
                            </div>

                        </div>
                    </div>

                </div>

            </div> <!-- row end -->

        </div>
        <!-- /.container-fluid -->

    </div>
    <!-- End of Main Content -->

    <?php include __DIR__ . "/footer.php"; ?>

</div>
<!-- End of Content Wrapper -->

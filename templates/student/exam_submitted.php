<?php
// /templates/student/exam_submitted.php
// -----------------------------------------------------------
// After exam submission page
// Shown immediately after student submits the exam
// Matches all other student templates: header + topbar only
// No sidebar (same as live_exam page)
// -----------------------------------------------------------

require_once __DIR__ . '/../../config/config.php';

// Include header
include __DIR__ . "/header.php";
?>

<!-- Content Wrapper -->
<div id="content-wrapper" class="d-flex flex-column">

    <!-- Main Content -->
    <div id="content">

        <?php include __DIR__ . "/topbar.php"; ?>

        <!-- Begin Page Content -->
        <div class="container-fluid px-4 py-5" style="max-width: 100%; width:100vw;">

            <div class="row justify-content-center">
                <div class="col-lg-8">

                    <div class="card shadow-lg p-4 text-center">

                        <!-- Success Icon -->
                        <div class="mb-3">
                            <i class="fas fa-check-circle text-success" style="font-size: 70px;"></i>
                        </div>

                        <h2 class="text-success mb-3">
                            Exam Submitted Successfully
                        </h2>

                        <p class="lead">
                            Your responses have been recorded.  
                            <br>
                            You can check your result once it is published by the admin.
                        </p>

                        <hr>

                        <!-- Back to Dashboard -->
                        <a href="student.php" class="btn btn-primary btn-lg mt-3">
                            Go to Dashboard
                        </a>

                    </div>

                </div>
            </div>

        </div>
        <!-- /.container-fluid -->

    </div>
    <!-- End of Main Content -->

</div>
<!-- End of Content Wrapper -->

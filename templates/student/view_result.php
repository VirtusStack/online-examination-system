<?php
// -----------------------------------------------------
// Student Result View Page
// Shows result ONLY after admin publishes it
// Used by: student.php?action=viewResult&result_id=ID
// -----------------------------------------------------
include __DIR__ . "/header.php";
include __DIR__ . "/sidebar.php";
?>

<!-- Content Wrapper -->
<div id="content-wrapper" class="d-flex flex-column">

    <!-- Main Content -->
    <div id="content">

            <!-- Top Navbar -->
           <?php include __DIR__ . "/topbar.php"; ?>

            <!-- Begin Page Content -->
            <div class="container-fluid">

                <!-- Page Heading -->
                <div class="d-flex justify-content-between align-items-center mb-4">
                    <h1 class="h3 text-gray-800">Exam Result</h1>
                   <a href="<?= BASE_URL ?>/student.php?action=results" class="btn btn-secondary">
                    <i class="fas fa-arrow-left"></i> Back to Results
</a>
                </div>

                <!-- Exam Info Card -->
                <div class="card shadow mb-4">
                    <div class="card-header bg-primary text-white">
                        <h6 class="m-0 font-weight-bold">Exam Information</h6>
                    </div>
                    <div class="card-body">

                        <div class="row mb-3">
                            <div class="col-md-4"><strong>Exam Title:</strong></div>
                            <div class="col-md-8">
                                <?= htmlspecialchars($result['exam_title']) ?>
                            </div>
                        </div>

                        <div class="row mb-3">
                            <div class="col-md-4"><strong>Total Marks:</strong></div>
                            <div class="col-md-8">
                                <?= $result['total_marks'] ?>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-4"><strong>Passing Marks:</strong></div>
                            <div class="col-md-8">
                                <?= $result['pass_marks'] ?>
                            </div>
                        </div>

                    </div>
                </div>

                <!-- Marks Summary Card -->
                <div class="card shadow mb-4">
                    <div class="card-header bg-success text-white">
                        <h6 class="m-0 font-weight-bold">Marks Summary</h6>
                    </div>
                    <div class="card-body text-center">

                        <h3>Total Marks: <?= $result['total_marks'] ?></h3>

                        <h4 class="mt-3">
                            Obtained Marks:
                            <span class="<?= ($result['obtained_marks'] >= $result['pass_marks']) ? 'text-success' : 'text-danger' ?>">
                                <?= $result['obtained_marks'] ?>
                            </span>
                        </h4>

			<h5 class="mt-3">
    			Percentage:
    			<span class="text-info">
        			<?= $result['percentage'] ?>%
    			</span>
			</h5>

                        <h5 class="mt-3">
                            Result Status:
                            <?php if ($result['obtained_marks'] >= $result['pass_marks']): ?>
                                <span class="badge bg-success text-white">PASSED</span>
                            <?php else: ?>
                                <span class="badge bg-danger text-white">FAILED</span>
                            <?php endif; ?>
                        </h5>

                        <p class="mt-3">
                            <strong>Submitted At:</strong>
                            <?= htmlspecialchars($result['submitted_at']) ?>
                        </p>

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

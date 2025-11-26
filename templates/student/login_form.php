<?php
// /templates/student/login_form.php
// -------------------------
// Student Login / Exam Start Form
// Includes header, footer, and safe $message handling
// -------------------------

$message = $message ?? ''; // Ensure $message is defined

// Load header (CSS, meta, etc.)
include __DIR__ . "/../include/header.php";
?>

<div id="wrapper">

    <div id="content-wrapper" class="d-flex flex-column">
        <div id="content">

            <!-- Navbar -->
            <?php include __DIR__ . "/../include/navbar.php"; ?>

            <div class="container-fluid">

                <h1 class="h3 mb-4 text-gray-800">Enter Exam Details</h1>

                <!-- Feedback Message -->
                <?php if(!empty($message)): ?>
                    <div class="alert <?= (stripos($message, 'success') !== false) ? 'alert-success' : 'alert-danger' ?> alert-dismissible fade show" role="alert">
                        <?= htmlspecialchars($message) ?>
                        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                <?php endif; ?>

                <!-- Student Exam Form -->
                <div class="card shadow mb-4">
                    <div class="card-body">
                        <form method="POST" action="<?= BASE_URL ?>/student.php?action=startExam">

                            <!-- Student Name -->
                            <div class="form-group mb-3">
                                <label>Name</label>
                                <input type="text" name="student_name" class="form-control" required>
                            </div>

                            <!-- Student Email -->
                            <div class="form-group mb-3">
                                <label>Email</label>
                                <input type="email" name="student_email" class="form-control">
                            </div>

                            <!-- Class / Standard -->
                            <div class="form-group mb-3">
                                <label>Class / Standard</label>
                                <input type="text" name="student_class" class="form-control" required>
                            </div>

                            <!-- Password -->
                            <div class="form-group mb-3">
                                <label>Password</label>
                                <input type="text" name="password" class="form-control" required>
                            </div>

                            <button type="submit" class="btn btn-primary">Start Exam</button>
                        </form>
                    </div>
                </div>

            </div>
            <!-- /.container-fluid -->

        </div>
        <!-- End of Content -->

        <!-- Footer -->
        <?php include __DIR__ . "/../include/footer.php"; ?>
        <!-- End of Footer -->

    </div>
    <!-- End of Content Wrapper -->

</div>
<!-- End of Page Wrapper -->

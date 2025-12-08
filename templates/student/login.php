<?php 
// /templates/student/login.php
// --------------------------------------------------
// Student Login Page
// Shown before accessing student dashboard
// --------------------------------------------------
require_once __DIR__ . '/../../config/config.php';
?>

<?php include __DIR__ . "/header.php"; ?>

<div class="container">

    <!-- Outer Row -->
    <div class="row justify-content-center">

        <div class="col-xl-5 col-lg-7 col-md-9">

            <div class="card o-hidden border-0 shadow-lg my-5">
                <div class="card-body p-5">
                    <!-- Login Form -->
                  <form action="<?= BASE_URL ?>/student.php?action=login" method="post">
 
                        <div class="text-center mb-4">
                            <h1 class="h4 text-gray-900">Student Login</h1>
                            <p class="text-muted">Enter your credentials to continue</p>
                        </div>

                        <!-- Email -->
                        <div class="form-group">
                            <label>Enrollment / Email</label>
                            <input type="text" name="email" class="form-control" required>
                        </div>

                        <!-- Password -->
                        <div class="form-group">
                            <label>Password</label>
                            <input type="password" name="password" class="form-control" required>
                        </div>

			<!-- Remember Me checkbox -->
                        <div class="form-check mb-3">
                        <input class="form-check-input" type="checkbox" name="remember_me" id="remember_me" value="1">
                        <label class="form-check-label" for="remember_me">
                         Remember Me
                         </label>
                        </div>

                        <!-- Submit -->
                        <button type="submit" class="btn btn-primary btn-block">
                            Login
                        </button>

                    </form>
                    <!-- End Login Form -->

                </div>
            </div>

        </div>

    </div>

</div>


<?php
// /templates/common/login_form.php
// -------------------------
// Login page for Property Amenity Marketing System
// Uses header for CSS & meta
// No sidebar, topbar, or dashboard elements
// -------------------------

// Load header (CSS, meta, Bootstrap, etc.)
require_once __DIR__ . '/../include/header.php';
?>

<!-- Login Form Container -->
<div class="container mt-5">
    <div class="row justify-content-center">
        <div class="col-md-6">

            <!-- Card for login form -->
            <div class="card shadow-lg">
                <div class="card-header text-center">
                    <h3>Admin Login</h3>
                </div>

                <div class="card-body">

                    <!-- Display error message if login failed -->
                    <?php if (!empty($results['errorMessage'])): ?>
                        <div class="alert alert-danger" role="alert">
                            <?= htmlspecialchars($results['errorMessage']) ?>
                        </div>
                    <?php endif; ?>

                    <!-- Login Form -->
                    <form action="<?= BASE_URL ?>/admin.php?action=login" method="post">
                        <!-- Optional hidden field to indicate login submission -->
                        <input type="hidden" name="login" value="true" />

                        <!-- Email input -->
                        <div class="form-group mb-3">
                            <label for="email" class="form-label">Email</label>
                            <input type="email" name="email" id="email" class="form-control" 
                                   placeholder="Enter your email" required autofocus />
                        </div>

                        <!-- Password input -->
                        <div class="form-group mb-3">
                            <label for="password" class="form-label">Password</label>
                            <input type="password" name="password" id="password" class="form-control" 
                                   placeholder="Enter your password" required maxlength="50" />
                        </div>

			<!-- Remember Me checkbox -->
                        <div class="form-check mb-3">
                            <input class="form-check-input" type="checkbox" name="remember_me" id="remember_me" value="1">
                            <label class="form-check-label" for="remember_me">
                                Remember Me
                            </label>
                        </div>

                        <!-- Submit button -->
                        <div class="d-grid">
                           <button type="submit" class="btn btn-primary w-100">Login</button> 
                        </div>
                    </form>

                </div> <!-- End Card Body -->
            </div> <!-- End Card -->

        </div> <!-- End Column -->
    </div> <!-- End Row -->
</div> <!-- End Container -->

<!-- Footer -->
<?php include __DIR__ . "/../include/footer.php"; ?>
<!-- End of Footer -->

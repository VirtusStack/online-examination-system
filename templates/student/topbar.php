<?php
// /templates/student/topbar.php
// ------------------------------------------------------
// Student Top Navigation Bar (SB-Admin2 Style)
// Appears on every student panel page
// ------------------------------------------------------
?>

<nav class="navbar navbar-expand navbar-light bg-white topbar mb-4 static-top shadow">

    <!-- Sidebar Toggle (Mobile) -->
    <button id="sidebarToggleTop" class="btn btn-link d-md-none rounded-circle mr-3">
        <i class="fa fa-bars"></i>
    </button>

    <!-- Page Heading (Left Side) -->
    <h5 class="m-0 font-weight-bold text-primary">Student Panel</h5>

    <!-- Topbar Navbar -->
    <ul class="navbar-nav ml-auto">

        <!-- Divider -->
        <div class="topbar-divider d-none d-sm-block"></div>

        <!-- Student Info -->
        <li class="nav-item dropdown no-arrow">
            <a class="nav-link dropdown-toggle" href="#" id="userDropdown"
               role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">

                <span class="mr-2 d-none d-lg-inline text-gray-600 small">
                    <?= htmlspecialchars($_SESSION['student_name'] ?? 'Student'); ?>
                </span>

                <img class="img-profile rounded-circle"
                     src="<?= BASE_URL ?>/assets/img/undraw_profile_1.svg">
            </a>

            <!-- Dropdown -->
            <div class="dropdown-menu dropdown-menu-right shadow animated--grow-in"
                 aria-labelledby="userDropdown">

                <a class="dropdown-item" href="student.php?action=profile">
                    <i class="fas fa-user fa-sm fa-fw mr-2 text-gray-400"></i>
                    My Profile
                </a>

                <div class="dropdown-divider"></div>

                <a class="dropdown-item" href="student.php?action=logout">
                    <i class="fas fa-sign-out-alt fa-sm fa-fw mr-2 text-gray-400"></i>
                    Logout
                </a>
            </div>
        </li>

    </ul>

</nav>

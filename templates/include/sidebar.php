<?php
// templates/include/sidebar.php
?>

<!-- Sidebar -->
<ul class="navbar-nav bg-gradient-primary sidebar sidebar-dark accordion" id="accordionSidebar">

    <!-- Sidebar - Brand -->
    <a class="sidebar-brand d-flex align-items-center justify-content-center" href="admin.php?page=dashboard">
        <div class="sidebar-brand-icon rotate-n-15">
            <i class="fas fa-graduation-cap"></i>
        </div>
        <div class="sidebar-brand-text mx-3">Exam System</div>
    </a>

    <!-- Divider -->
    <hr class="sidebar-divider my-0">

    <!-- Dashboard -->
    <li class="nav-item <?= ($_GET['page'] ?? '') == 'dashboard' ? 'active' : '' ?>">
        <a class="nav-link" href="admin.php?page=dashboard">
            <i class="fas fa-fw fa-tachometer-alt"></i>
            <span>Dashboard</span>
        </a>
    </li>

    <!-- Divider -->
    <hr class="sidebar-divider">

    <!-- Subjects -->
    <li class="nav-item <?= in_array($_GET['page'] ?? '', ['manage_subjects','add_subject','edit_subject']) ? 'active' : '' ?>">
        <a class="nav-link" href="admin.php?page=manage_subjects">
            <i class="fas fa-book"></i>
            <span>Subjects</span>
        </a>
    </li>

    <!-- Question Banks -->
    <li class="nav-item <?= in_array($_GET['page'] ?? '', ['manage_banks','add_bank','edit_bank']) ? 'active' : '' ?>">
        <a class="nav-link" href="admin.php?page=manage_banks">
            <i class="fas fa-layer-group"></i>
            <span>Question Banks</span>
        </a>
    </li>

    <!-- Questions -->
    <li class="nav-item <?= in_array($_GET['page'] ?? '', ['manage_questions','add_question','edit_question']) ? 'active' : '' ?>">
        <a class="nav-link" href="admin.php?page=manage_questions">
            <i class="fas fa-question-circle"></i>
            <span>Questions</span>
        </a>
    </li>

    <!-- Exams -->
    <li class="nav-item <?= in_array($_GET['page'] ?? '', ['manage_exams','create_exam','assign_exam']) ? 'active' : '' ?>">
        <a class="nav-link" href="admin.php?page=manage_exams">
            <i class="fas fa-pencil-alt"></i>
            <span>Exams</span>
        </a>
    </li>

    <!-- Results -->
    <li class="nav-item <?= in_array($_GET['page'] ?? '', ['view_results','result_summary']) ? 'active' : '' ?>">
        <a class="nav-link" href="admin.php?page=view_results">
            <i class="fas fa-chart-bar"></i>
            <span>Results</span>
        </a>
    </li>

    <!-- Divider -->
    <hr class="sidebar-divider d-none d-md-block">

    <!-- Logout -->
    <li class="nav-item">
        <a class="nav-link text-danger" href="templates/common/logout.php">
            <i class="fas fa-sign-out-alt"></i>
            <span>Logout</span>
        </a>
    </li>

</ul>
<!-- End of Sidebar -->

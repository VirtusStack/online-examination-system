<?php
// templates/include/sidebar.php
?>

<!-- Sidebar -->
<ul class="navbar-nav bg-gradient-primary sidebar sidebar-dark accordion" id="accordionSidebar">

    <!-- Sidebar - Brand -->
    <a class="sidebar-brand d-flex align-items-center justify-content-center" href="admin.php?action=dashboard">
        <div class="sidebar-brand-icon">
            <i class="fas fa-graduation-cap"></i>
        </div>
        <div class="sidebar-brand-text mx-3">OES Admin</div>
    </a>

    <hr class="sidebar-divider my-0">

    <!-- Dashboard Link -->
    <li class="nav-item">
        <a class="nav-link" href="admin.php?action=dashboard">
            <i class="fas fa-fw fa-tachometer-alt"></i>
            <span>Dashboard</span></a>
    </li>

    <hr class="sidebar-divider">

    <!-- Subjects -->
    <li class="nav-item">
        <a class="nav-link" href="admin.php?action=manageSubjects">
            <i class="fas fa-fw fa-book"></i>
            <span>Subjects</span></a>
    </li>

    <!-- Exams -->
    <li class="nav-item">
        <a class="nav-link" href="admin.php?action=manageExams">
            <i class="fas fa-fw fa-file-alt"></i>
            <span>Exams</span></a>
    </li>

    <!-- Questions -->
    <li class="nav-item">
        <a class="nav-link" href="admin.php?action=manageQuestions">
            <i class="fas fa-fw fa-question-circle"></i>
            <span>Questions</span></a>
    </li>

    <hr class="sidebar-divider d-none d-md-block">

    <!-- Logout -->
    <li class="nav-item">
        <a class="nav-link" href="admin.php?action=logout">
            <i class="fas fa-fw fa-sign-out-alt"></i>
            <span>Logout</span></a>
    </li>

</ul>
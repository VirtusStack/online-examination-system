<?php
// templates/include/sidebar.php
?>

<ul class="navbar-nav bg-gradient-primary sidebar sidebar-dark accordion" id="accordionSidebar">

    <!-- Sidebar - Brand -->
    <a class="sidebar-brand d-flex align-items-center justify-content-center" href="<?= BASE_URL ?>/admin.php?action=dashboard">
        <div class="sidebar-brand-icon">
            <i class="fas fa-graduation-cap"></i>
        </div>
        <div class="sidebar-brand-text mx-3">OES Admin</div>
    </a>

    <hr class="sidebar-divider my-0">

    <!-- Dashboard -->
    <li class="nav-item">
        <a class="nav-link" href="<?= BASE_URL ?>/admin.php?action=dashboard">
            <i class="fas fa-fw fa-tachometer-alt"></i>
            <span>Dashboard</span>
        </a>
    </li>

    <hr class="sidebar-divider">

    <!-- Subjects -->
    <li class="nav-item">
        <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapseSubjects">
            <i class="fas fa-fw fa-book"></i>
            <span>Subjects</span>
        </a>
        <div id="collapseSubjects" class="collapse" data-parent="#accordionSidebar">
            <div class="bg-white py-2 collapse-inner rounded">
                <a class="collapse-item" href="<?= BASE_URL ?>/admin.php?action=manageSubjects">Manage Subjects</a>
                <a class="collapse-item" href="<?= BASE_URL ?>/admin.php?action=newSubject">Add Subject</a>
            </div>
        </div>
    </li>

    <!-- Question Banks -->
    <li class="nav-item">
        <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapseBanks">
            <i class="fas fa-fw fa-layer-group"></i>
            <span>Question Banks</span>
        </a>
        <div id="collapseBanks" class="collapse" data-parent="#accordionSidebar">
            <div class="bg-white py-2 collapse-inner rounded">
                <a class="collapse-item" href="<?= BASE_URL ?>/admin.php?action=manageBanks">Manage Banks</a>
                <a class="collapse-item" href="<?= BASE_URL ?>/admin.php?action=newBank">Add Bank</a>
            </div>
        </div>
    </li>

    <!-- Questions -->
    <li class="nav-item">
        <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapseQuestions">
            <i class="fas fa-fw fa-question-circle"></i>
            <span>Questions</span>
        </a>
        <div id="collapseQuestions" class="collapse" data-parent="#accordionSidebar">
            <div class="bg-white py-2 collapse-inner rounded">
                <a class="collapse-item" href="<?= BASE_URL ?>/admin.php?action=manageQuestions">Manage Questions</a>
                <a class="collapse-item" href="<?= BASE_URL ?>/admin.php?action=newQuestion">Add Question</a>
            </div>
        </div>
    </li>

<!-- Exams -->
<li class="nav-item">
    <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapseExams">
        <i class="fas fa-fw fa-file-alt"></i>
        <span>Exams</span>
    </a>
    <div id="collapseExams" class="collapse" data-parent="#accordionSidebar">
        <div class="bg-white py-2 collapse-inner rounded">
            <a class="collapse-item" href="<?= BASE_URL ?>/admin.php?action=manageExams">Manage Exams</a>
            <a class="collapse-item" href="<?= BASE_URL ?>/admin.php?action=newExam">Create Exam</a>

            <!-- Generate Links  -->
            <a class="collapse-item" href="<?= BASE_URL ?>/admin.php?action=generateLinks">Generate Exam Links</a>

             </div>
    </div>
</li>



    <hr class="sidebar-divider d-none d-md-block">

    <!-- Logout -->
    <li class="nav-item">
        <a class="nav-link" href="<?= BASE_URL ?>/admin.php?action=logout">
            <i class="fas fa-fw fa-sign-out-alt"></i>
            <span>Logout</span>
        </a>
    </li>

</ul>

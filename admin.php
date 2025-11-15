<?php
// admin.php → Central Admin Controller for Online Examination System
// Handles Dashboard,Login/Logout

session_start(); // Start PHP session

//  Load config and required classes
require("config/config.php");
require_once __DIR__ . "/classes/Admin.php";

//  AUTO-LOGIN USING REMEMBER ME COOKIE
if (!isset($_SESSION['admin_id']) && isset($_COOKIE['remember_admin'])) {
    $adminId = intval($_COOKIE['remember_admin']);
    $admin = Admin::getById($pdo, $adminId);

    if ($admin) {
        $_SESSION['admin_id'] = $admin['admin_id'];
        $_SESSION['admin_name'] = $admin['name'];
        $_SESSION['login_time'] = time();
    } else {
        setcookie('remember_admin', '', time() - 3600, '/');
    }
}

//  FORCE LOGIN IF NOT LOGGED IN
$action = $_GET['action'] ?? '';
if (!isset($_SESSION['admin_id']) && $action !== 'login') {
    $action = 'login';
}

//  ROUTING
switch ($action) {
    case 'login':
        login();
        break;
    case 'logout':
        logout();
        break;
    default:
        dashboard();
        break;

// Subject management
case 'newSubject':
    newSubject();
    break;

case 'manageSubjects':
    manageSubjects();
    break;

case 'editSubject':
    editSubject();
    break;

}

// FUNCTIONS

function login() {
    global $pdo;
    $results = ['errorMessage' => '', 'pageTitle' => 'Admin Login'];

    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        $email    = trim($_POST['email'] ?? '');
        $password = $_POST['password'] ?? '';
      
        if ($email !== '' && $password !== '') {
            $admin = Admin::authenticate($pdo, $email, $password);

            if ($admin) {
                $_SESSION['admin_id'] = $admin['admin_id'];
                $_SESSION['admin_name'] = $admin['name'];
                $_SESSION['login_time'] = time();

                // Remember Me
                if (!empty($_POST['remember_me'])) {
                    setcookie('remember_admin', $admin['admin_id'], time() + 86400, "/", "", false, true);
                }

                header("Location: admin.php?action=dashboard");
                exit;
            } else {
                $results['errorMessage'] = "Invalid email or password!";
            }
        } else {
            $results['errorMessage'] = "Please enter both email and password!";
        }
    }

    require(__DIR__ . "/templates/common/login_form.php");
}

function logout() {
    if (isset($_COOKIE['remember_admin'])) {
        setcookie('remember_admin', '', time() - 3600, '/');
    }
    session_destroy();
    header("Location: admin.php?action=login");
    exit;
}

function dashboard() {
    $results = [
        'pageTitle' => 'Dashboard',
        'adminName' => $_SESSION['admin_name'] ?? 'Unknown'
    ];

    require(__DIR__ . "/templates/common/index.php");
}

// -------------------------
// SUBJECT MANAGEMENT
// -------------------------
function newSubject() {
    global $pdo;
    $results = ['message' => '', 'pageTitle' => 'Add New Subject'];

    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        $subject_name = trim($_POST['subject_name'] ?? '');
        $description  = trim($_POST['description'] ?? '');

        if (empty($subject_name)) {
            $results['message'] = " Subject name is required!";
        } else {
            // Insert subject
            $subjectId = Subject::create($pdo, $subject_name, $description);
            if ($subjectId) {
                $results['message'] = " Subject added successfully!";
                $subject_name = $description = '';
            } else {
                $results['message'] = " Error adding subject!";
            }
        }
    }

    require(TEMPLATE_PATH . "/subjects/add_subject.php");
}

function manageSubjects() {
    global $pdo;
    $results = [
        'message'   => '',
        'pageTitle' => 'Manage Subjects',
        'subjects'  => []
    ];

    // Handle delete request
    if (isset($_GET['delete'])) {
        $subjectId = (int)$_GET['delete'];
        if (Subject::delete($pdo, $subjectId)) {
            $results['message'] = " Subject deleted!";
        } else {
            $results['message'] = " Error deleting subject!";
        }
    }

    // Pagination
    $perPage = 25;
    $page = isset($_GET['page']) ? max(1, (int)$_GET['page']) : 1;
    $offset = ($page - 1) * $perPage;

    // Total subjects
    $stmtTotal = $pdo->query("SELECT COUNT(*) FROM subjects");
    $total = (int)$stmtTotal->fetchColumn();
    $totalPages = ceil($total / $perPage);

    // Fetch subjects for current page
    $stmt = $pdo->prepare("
        SELECT subject_id, subject_name, description, created_at
        FROM subjects
        ORDER BY subject_id ASC
        LIMIT :limit OFFSET :offset
    ");
    $stmt->bindValue(':limit', $perPage, PDO::PARAM_INT);
    $stmt->bindValue(':offset', $offset, PDO::PARAM_INT);
    $stmt->execute();
    $results['subjects'] = $stmt->fetchAll(PDO::FETCH_ASSOC);

    $results['currentPage'] = $page;
    $results['totalPages'] = $totalPages;

    require(TEMPLATE_PATH . "/subjects/manage_subject.php");
}

function editSubject() {
    global $pdo;
    $results = ['message' => '', 'pageTitle' => 'Edit Subject'];

    if (!isset($_GET['id'])) die(" No subject ID given.");
    $subjectId = (int)$_GET['id'];

    // Fetch subject
    $subject = Subject::getById($pdo, $subjectId);

    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        $subjectData = [
            'subject_name' => trim($_POST['subject_name'] ?? ''),
            'description'  => trim($_POST['description'] ?? '')
        ];

        if (Subject::update($pdo, $subjectId, $subjectData)) {
            $results['message'] = " Subject updated successfully!";
        } else {
            $results['message'] = " Error updating subject!";
        }

        $subject = Subject::getById($pdo, $subjectId);
    }

    $results['subject'] = $subject;

    require(TEMPLATE_PATH . "/subjects/edit_subject.php");
}


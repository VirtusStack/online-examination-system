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

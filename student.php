<?php
// student.php 
// -----------------------------------------------------------
// Central Student Controller for Online Examination System
// Handles: Login, Logout, Dashboard, Exams (later)
// Structure same as admin.php
// -----------------------------------------------------------

session_start();

// Load config + required classes
require_once __DIR__ . "/config/config.php";
require_once __DIR__ . "/classes/Student.php";
require_once __DIR__ . "/classes/Exam.php";  // Needed for dashboard exam listing

// AUTO LOGIN USING REMEMBER-ME COOKIE

if (!isset($_SESSION['student_id']) && isset($_COOKIE['remember_student'])) {

    $studentId = intval($_COOKIE['remember_student']);
    $student = Student::getById($pdo, $studentId);

    if ($student) {
        $_SESSION['student_id']  = $student['student_id'];
        $_SESSION['student_name'] = $student['name'];
        $_SESSION['login_time']   = time();
    } else {
        // Invalid cookie, remove it
        setcookie('remember_student', '', time() - 3600, '/');
    }
}

// ROUTING
$action = $_GET['action'] ?? 'login';

// Force login if session not exists
if (!isset($_SESSION['student_id']) && $action !== 'login') {
    $action = 'login';
}

switch ($action) {

    // login
    case 'login':
        studentLogin();
        break;

    // logout
    case 'logout':
        studentLogout();
        break;

    // dashboard
    case 'dashboard':
    default:
        studentDashboard();
        break;

   // startexam
   case 'startExam':
    startExam();
    break;

 // live exam
   case 'liveExam':
    liveExam();
    break;

// submit answer
case 'submitExam':
    submitExam();
    break;

}

// FUNCTION DEFINITIONS

// Student Login
function studentLogin() {
    global $pdo;

    $results = [
        'pageTitle'     => 'Student Login',
        'errorMessage'  => ''
    ];

    // If submitted
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {

        $email    = trim($_POST['email'] ?? '');
        $password = $_POST['password'] ?? '';

        if ($email !== '' && $password !== '') {

            $student = Student::authenticate($pdo, $email, $password);

            if ($student) {

                // Set session
                $_SESSION['student_id']   = $student['student_id'];
                $_SESSION['student_name'] = $student['name'];
                $_SESSION['login_time']   = time();

                // Remember me
                if (!empty($_POST['remember_me'])) {
                    setcookie(
                        'remember_student',
                        $student['student_id'],
                        time() + 86400, // 1 day
                        "/",
                        "",
                        false,
                        true
                    );
                }

                header("Location: student.php?action=dashboard");
                exit;
            } 
            else {
                $results['errorMessage'] = "Invalid email or password!";
            }
        } 
        else {
            $results['errorMessage'] = "Please enter both email and password!";
        }
    }

    require(__DIR__ . "/templates/student/login.php");
}

// Logout Student
function studentLogout() {

    // Remove remember-me cookie
    if (isset($_COOKIE['remember_student'])) {
        setcookie('remember_student', '', time() - 3600, '/');
    }

    session_destroy();
    header("Location: student.php?action=login");
    exit;
}

// Student Dashboard
function studentDashboard() {
    global $pdo;

    $results = [
        'pageTitle'      => 'Student Dashboard',
        'studentName'    => $_SESSION['student_name'] ?? 'Unknown',
        'assignedExams'  => Exam::getAssignedExams($pdo, $_SESSION['student_id'])
    ];

    require(__DIR__ . "/templates/student/dashboard.php");
}

// Start Exam page
function startExam() {
    global $pdo;

    $exam_id = intval($_GET['exam_id'] ?? 0);
    $student_id = $_SESSION['student_id'] ?? 0;

    if (!$exam_id || !$student_id) {
        header("Location: student.php?action=dashboard");
        exit;
    }

    // Fetch exam for this student
    $exam = Exam::getExamForStudent($pdo, $exam_id, $student_id);

    if (!$exam) {
        // Exam not found or not assigned to student
        $_SESSION['error_message'] = "Exam not available or not assigned to you.";
        header("Location: student.php?action=dashboard");
        exit;
    }

    // Pass exam details to template
    $results = [
        'pageTitle' => 'Start Exam: ' . ($exam['exam_title'] ?? ''),
        'exam' => $exam
    ];

    require(__DIR__ . "/templates/student/start_exam.php");
}

function liveExam() {
    global $pdo;
    $exam_id = intval($_GET['exam_id'] ?? 0);

    if (!$exam_id) die("Invalid exam ID");

    // Fetch exam and assigned questions
    $exam = Exam::getExamForStudent($pdo, $exam_id);
    if (!$exam) die("Exam not found or not assigned.");

    $questions = Exam::getExamQuestions($exam_id);

    require(__DIR__ . "/templates/student/live_exam.php");
}

?>

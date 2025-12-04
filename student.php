<?php
// student.php
// ---------------------------------------------------------------------
// Student Controller - Online Examination System
// Handles: Login, Logout, Dashboard, Start Exam, Live Exam, Submit Exam
// Structure + Comments follow same format as admin.php

session_start();

// Load Config + Required Classes
require_once __DIR__ . "/config/config.php";
require_once __DIR__ . "/classes/Student.php";
require_once __DIR__ . "/classes/Exam.php";

// AUTO LOGIN USING REMEMBER ME COOKIE
if (!isset($_SESSION['student_id']) && isset($_COOKIE['remember_student'])) {
    $studentId = intval($_COOKIE['remember_student']);
    $student = Student::getById($pdo, $studentId);

    if ($student) {
        $_SESSION['student_id']   = $student['student_id'];
        $_SESSION['student_name'] = $student['name'];
        $_SESSION['student_email'] = $student['email'];
        $_SESSION['login_time']   = time();
    } else {
        setcookie("remember_student", "", time() - 3600, "/");
    }
}


// ROUTING
$action = $_GET['action'] ?? 'login';

// Force login if not logged in
if (!isset($_SESSION['student_id']) && $action !== 'login') {
    $action = 'login';
}

switch ($action) {

    case 'login':
        studentLogin();
        break;

    case 'logout':
        studentLogout();
        break;

    case 'dashboard':
    default:
        studentDashboard();
        break;

    case 'startExam':
        startExam();
        break;

    case 'liveExam':
        liveExam();
        break;

    case 'submitExam':
        submitExam();
        break;
}


// FUNCTION DEFINITIONS

// STUDENT LOGIN
function studentLogin() {
    global $pdo;

    $results = [
        'pageTitle'    => 'Student Login',
        'errorMessage' => ''
    ];

    if ($_SERVER['REQUEST_METHOD'] === 'POST') {

        $email    = trim($_POST['email'] ?? '');
        $password = $_POST['password'] ?? '';

        if ($email !== '' && $password !== '') {

            $student = Student::authenticate($pdo, $email, $password);

            if ($student) {
                // Set session
                $_SESSION['student_id']    = $student['student_id'];
                $_SESSION['student_name']  = $student['name'];
                $_SESSION['student_email'] = $student['email'];
                $_SESSION['login_time']    = time();

                // Remember me
                if (!empty($_POST['remember_me'])) {
                    setcookie(
                        "remember_student",
                        $student['student_id'],
                        time() + 86400,
                        "/",
                        "",
                        false,
                        true
                    );
                }

                header("Location: student.php?action=dashboard");
                exit;
            } else {
                $results['errorMessage'] = "Invalid email or password!";
            }
        } else {
            $results['errorMessage'] = "Please enter email and password!";
        }
    }

    require(__DIR__ . "/templates/student/login.php");
}

// STUDENT LOGOUT

function studentLogout() {
    if (isset($_COOKIE['remember_student'])) {
        setcookie("remember_student", "", time() - 3600, "/");
    }

    session_destroy();
    header("Location: student.php?action=login");
    exit;
}

// STUDENT DASHBOARD

function studentDashboard() {
    global $pdo;

    $studentId = $_SESSION['student_id'] ?? 0;

    $results = [
        'pageTitle'      => 'Student Dashboard',
        'studentName'    => $_SESSION['student_name'] ?? 'Unknown',
        'assignedExams'  => Exam::getAssignedExams($pdo, $studentId)
    ];

    require(__DIR__ . "/templates/student/dashboard.php");
}

// Start Exam
function startExam() {
    global $pdo;

    $exam_id = $_GET['exam_id'] ?? 0;
    $link_id = $_GET['link_id'] ?? 0;

    if (!$exam_id || !$link_id) {
        echo "Invalid Exam Link!";
        exit;
    }

    // FETCH EXAM
    $stmt = $pdo->prepare("SELECT * FROM exams WHERE exam_id = ?");
    $stmt->execute([$exam_id]);
    $exam = $stmt->fetch(PDO::FETCH_ASSOC);

    if (!$exam) {
        echo "Exam not found!";
        exit;
    }

    // BLOCK IF STUDENT ALREADY SUBMITTED EXAM
    $check = $pdo->prepare("
        SELECT 1 FROM exam_results 
        WHERE exam_id = ? AND link_id = ?
    ");
    $check->execute([$exam_id, $link_id]);

    if ($check->fetchColumn()) {
        header("Location: student.php?action=dashboard&msg=You+have+already+submitted+this+exam");
        exit;
    }

    // FETCH SUBJECTS FROM exam_question_sources
    $stmtSub = $pdo->prepare("
        SELECT DISTINCT s.subject_name
        FROM exam_question_sources eqs
        LEFT JOIN subjects s ON s.subject_id = eqs.subject_id
        WHERE eqs.exam_id = ?
    ");
    $stmtSub->execute([$exam_id]);

    $subjects = $stmtSub->fetchAll(PDO::FETCH_COLUMN);

    // Add subjects to exam array
    $exam['subject_name'] = !empty($subjects) ? implode(', ', $subjects) : 'N/A';

    // STORE SESSION   
    $_SESSION['exam_id'] = $exam_id;
    $_SESSION['link_id'] = $link_id;

    // LOAD VIEW
    require(__DIR__ . "/templates/student/start_exam.php");
}

// LIVE EXAM

function liveExam() {
    global $pdo;

    $exam_id = $_SESSION['exam_id'] ?? 0;
    $link_id = $_SESSION['link_id'] ?? 0;

    if (!$exam_id || !$link_id) {
        echo "Unauthorized Access!";
        exit;
    }

    // BLOCK IF ALREADY SUBMITTED
    $check = $pdo->prepare("
        SELECT 1 FROM exam_results 
        WHERE exam_id = ? AND link_id = ?
    ");
    $check->execute([$exam_id, $link_id]);

    if ($check->fetchColumn()) {
        header("Location: student.php?action=dashboard&msg=You+have+already+submitted+this+exam");
        exit;
    }

    // -------------------------------------------------------------------
    // FETCH QUESTION SOURCES (These define which questions to pull)
    // -------------------------------------------------------------------
    $stmt = $pdo->prepare("
        SELECT bank_id, subject_id, difficulty, question_limit
        FROM exam_question_sources
        WHERE exam_id = ?
    ");
    $stmt->execute([$exam_id]);
    $sources = $stmt->fetchAll(PDO::FETCH_ASSOC);

    $questions = [];

    // -------------------------------------------------------------------
    // FOR EACH SOURCE → PICK RANDOM QUESTIONS
    // -------------------------------------------------------------------
    foreach ($sources as $src) {

        $sql = "
            SELECT q.*
            FROM questions q
            WHERE q.bank_id = ?
              AND q.subject_id = ?
        ";

        if (!empty($src['difficulty'])) {
            $sql .= " AND q.difficulty = " . $pdo->quote($src['difficulty']);
        }

        $sql .= " ORDER BY RAND() LIMIT " . intval($src['question_limit']);

        $stmtQ = $pdo->prepare($sql);
        $stmtQ->execute([$src['bank_id'], $src['subject_id']]);

        $picked = $stmtQ->fetchAll(PDO::FETCH_ASSOC);

        foreach ($picked as $q) {
            $questions[] = $q;
        }
    }

    // -------------------------------------------------------------------
    // BUILD OPTIONS
    // -------------------------------------------------------------------
    foreach ($questions as &$q) {
        $q['options'] = [
            'A' => $q['option_a'],
            'B' => $q['option_b'],
            'C' => $q['option_c'],
            'D' => $q['option_d']
        ];
    }

    require(__DIR__ . "/templates/student/live_exam.php");
}

function submitExam() {
    global $pdo;

    $exam_id = $_SESSION['exam_id'] ?? 0;
    $link_id = $_SESSION['link_id'] ?? 0;

    if (!$exam_id || !$link_id) {
        echo "Invalid submission!";
        exit;
    }

    // CHECK IF EXAM ALREADY SUBMITTED
    $stmtCheck = $pdo->prepare("SELECT result_id FROM exam_results WHERE exam_id = ? AND link_id = ?");
    $stmtCheck->execute([$exam_id, $link_id]);
    $existingResult = $stmtCheck->fetch(PDO::FETCH_ASSOC);

    if ($existingResult) {
        // Already submitted
        unset($_SESSION['exam_id'], $_SESSION['link_id']);
        header("Location: student.php?action=dashboard&msg=You+have+already+submitted+this+exam");
        exit;
    }

    $answers = $_POST['answers'] ?? [];

    // Insert result row
    $stmt = $pdo->prepare("
        INSERT INTO exam_results
            (link_id, exam_id, student_name, student_email, started_at, submitted_at)
        VALUES (?, ?, ?, ?, NOW(), NOW())
    ");
    $stmt->execute([
        $link_id,
        $exam_id,
        $_SESSION['student_name'],
        $_SESSION['student_email']
    ]);

    $result_id = $pdo->lastInsertId();

    // Insert answers
    foreach ($answers as $question_id => $selected) {

        $stmtQ = $pdo->prepare("SELECT correct_option FROM questions WHERE question_id = ?");
        $stmtQ->execute([$question_id]);
        $correct_option = $stmtQ->fetchColumn();

        $is_correct = ($selected === $correct_option) ? 1 : 0;

        $stmtA = $pdo->prepare("
            INSERT INTO exam_answers (result_id, question_id, selected_option, is_correct)
            VALUES (?, ?, ?, ?)
        ");
        $stmtA->execute([$result_id, $question_id, $selected, $is_correct]);
    }

    // Clear exam session
    unset($_SESSION['exam_id'], $_SESSION['link_id']);

    // Redirect
    header("Location: student.php?action=dashboard&msg=Exam+Submitted+Successfully");
    exit;
}
?>

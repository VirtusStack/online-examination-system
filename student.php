<?php
// student.php
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
        $_SESSION['student_id']    = $student['student_id'];
        $_SESSION['student_name']  = $student['name'];
        $_SESSION['student_email'] = $student['email'];
        $_SESSION['login_time']    = time();
    } else {
        setcookie("remember_student", "", time() - 3600, "/");
    }
}

// ROUTING
$action = $_GET['action'] ?? (isset($_SESSION['student_id']) ? 'dashboard' : 'login');

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

    // Access exam via unique email link
    case 'examAccess':
        examAccess();
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

    // Exam submitted page
    case 'examSubmitted':
    examSubmittedPage();
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

                // Redirect if pending exam after clicking email link
                if (!empty($_SESSION['pending_exam_id']) && !empty($_SESSION['pending_link_id'])) {
                    $exam_id = $_SESSION['pending_exam_id'];
                    $link_id = $_SESSION['pending_link_id'];

                    unset($_SESSION['pending_exam_id'], $_SESSION['pending_link_id']);
                    header("Location: student.php?action=startExam&exam_id={$exam_id}&link_id={$link_id}");
                    exit;
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

// NEW: Access Exam via unique email link
// Access Exam via unique email link
function examAccess() {
    global $pdo;

    $code = $_GET['code'] ?? '';

    if (!$code) {
        echo "<h3 style='color:red;text-align:center;margin-top:30px;'>Invalid Exam Link!</h3>";
        exit;
    }

    // Fetch exam link info
    $stmt = $pdo->prepare("SELECT * FROM exam_links WHERE unique_link = ?");
    $stmt->execute([$code]);
    $link = $stmt->fetch(PDO::FETCH_ASSOC);

    if (!$link) {
        echo "<h3 style='color:red;text-align:center;margin-top:30px;'>Invalid or expired exam link!</h3>";
        exit;
    }

    $exam_id = $link['exam_id'];
    $link_id = $link['link_id']; // assuming your table has link_id primary

    // BLOCK ADMIN ACCESS
    if (!empty($_SESSION['admin_id'])) {
        echo "<h3 style='color:red;text-align:center;margin-top:30px;'>
            This exam link is only for students. Please logout from admin panel before using this link.
        </h3>";
        exit;
    }

    // STUDENT NOT LOGGED IN
    if (empty($_SESSION['student_id'])) {
        // Store exam info in session to redirect after login
        $_SESSION['pending_exam_id'] = $exam_id;
        $_SESSION['pending_link_id'] = $link_id;

        // Redirect to login page
        header("Location: student.php?action=login&redirect=startExam");
        exit;
    }

    // -------------------------------
    // STUDENT LOGGED IN
    // -------------------------------
    header("Location: student.php?action=startExam&exam_id={$exam_id}&link_id={$link_id}");
    exit;
}

// START EXAM 
function startExam() {
    global $pdo;

    $exam_id = $_GET['exam_id'] ?? 0;
    $link_id = $_GET['link_id'] ?? 0;

    if (!$exam_id || !$link_id) {
        echo "Invalid Exam Link!";
        exit;
    }

    // 1) FETCH EXAM DETAILS
    $stmt = $pdo->prepare("SELECT * FROM exams WHERE exam_id = ?");
    $stmt->execute([$exam_id]);
    $exam = $stmt->fetch(PDO::FETCH_ASSOC);

    if (!$exam) {
        echo "Exam not found!";
        exit;
    }

    /* =====================================================
       CREATE exam_results ROW IF NOT EXISTS (IMPORTANT FIX)
       ===================================================== */
    $stmtCheck = $pdo->prepare("
        SELECT result_id 
        FROM exam_results 
        WHERE exam_id = ? AND link_id = ?
        LIMIT 1
    ");
    $stmtCheck->execute([$exam_id, $link_id]);
    $result_id = $stmtCheck->fetchColumn();

    if (!$result_id) {
        $stmtInsert = $pdo->prepare("
            INSERT INTO exam_results 
                (exam_id, link_id, student_name, student_email, started_at)
            VALUES (?, ?, ?, ?, NOW())
        ");
        $stmtInsert->execute([
            $exam_id,
            $link_id,
            $_SESSION['student_name'],
            $_SESSION['student_email']
        ]);
    }

    // UPDATE started_at ONLY IF NULL
    $stmtStart = $pdo->prepare("
        UPDATE exam_results
        SET started_at = NOW()
        WHERE exam_id = ? 
          AND link_id = ? 
          AND started_at IS NULL
    ");
    $stmtStart->execute([$exam_id, $link_id]);

    // FETCH SUBJECTS FROM exam_question_sources
    $stmtSub = $pdo->prepare("
        SELECT DISTINCT s.subject_name
        FROM exam_question_sources eqs
        LEFT JOIN subjects s ON s.subject_id = eqs.subject_id
        WHERE eqs.exam_id = ?
    ");
    $stmtSub->execute([$exam_id]);
    $subjects = $stmtSub->fetchAll(PDO::FETCH_COLUMN);

    $exam['subject_name'] = !empty($subjects) ? implode(', ', $subjects) : 'N/A';

    // STORE SESSION (required for answering and submitting)
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

    /* =====================================================
       BLOCK IF ALREADY SUBMITTED
    ===================================================== */
    $check = $pdo->prepare("
        SELECT 1 
        FROM exam_results 
        WHERE exam_id = ? 
          AND link_id = ? 
          AND submitted_at IS NOT NULL
    ");
    $check->execute([$exam_id, $link_id]);

    if ($check->fetchColumn()) {
        header("Location: student.php?action=dashboard&msg=You+have+already+submitted+this+exam");
        exit;
    }

    $stmtExam = $pdo->prepare("SELECT * FROM exams WHERE exam_id = ? LIMIT 1");
    $stmtExam->execute([$exam_id]);
    $exam = $stmtExam->fetch(PDO::FETCH_ASSOC);

    $stmt = $pdo->prepare("
        SELECT q.*
        FROM exam_questions eq
        INNER JOIN questions q ON q.question_id = eq.question_id
        WHERE eq.exam_id = ?
        ORDER BY eq.id ASC
    ");
    $stmt->execute([$exam_id]);
    $questions = $stmt->fetchAll(PDO::FETCH_ASSOC);

    /* =====================================================
       SAFETY CHECK
    ===================================================== */
    if (empty($questions)) {
        echo "No questions found for this exam. Please contact admin.";
        exit;
    }

    foreach ($questions as &$q) {
        $q['options'] = [
            'A' => $q['option_a'],
            'B' => $q['option_b'],
            'C' => $q['option_c'],
            'D' => $q['option_d']
        ];

        // Shuffle options if enabled
        if (!empty($exam['shuffle_options'])) {
            $q['options'] = shuffle_assoc($q['options']);
        }
    }

    // Shuffle questions if enabled
    if (!empty($exam['shuffle_questions'])) {
        shuffle($questions);
    }

    // LOAD VIEW
    require(__DIR__ . "/templates/student/live_exam.php");
}


 //Helper function to shuffle associative arrays

function shuffle_assoc($array) {
    $keys = array_keys($array);
    shuffle($keys);
    $shuffled = [];
    foreach ($keys as $key) {
        $shuffled[$key] = $array[$key];
    }
    return $shuffled;
}

// submit exam
function submitExam() {
    global $pdo;

    $exam_id = $_SESSION['exam_id'] ?? 0;
    $link_id = $_SESSION['link_id'] ?? 0;

    if (!$exam_id || !$link_id) {
        echo "Invalid submission!";
        exit;
    }

    // Fetch existing result row
    $stmtRes = $pdo->prepare("
        SELECT result_id 
        FROM exam_results 
        WHERE exam_id = ? AND link_id = ?
        LIMIT 1
    ");
    $stmtRes->execute([$exam_id, $link_id]);
    $result_id = $stmtRes->fetchColumn();

    if (!$result_id) {
        echo "Exam result record not found!";
        exit;
    }

    $answers = $_POST['answers'] ?? [];

    $stmtNeg = $pdo->prepare("SELECT negative_marking FROM exams WHERE exam_id = ?");
    $stmtNeg->execute([$exam_id]);
    $negative_mark = floatval($stmtNeg->fetchColumn());

    $obtained = 0;
    $total = 0;

    foreach ($answers as $question_id => $selected) {
        $stmtQ = $pdo->prepare("SELECT correct_option, marks_per_question FROM questions WHERE question_id = ?");
        $stmtQ->execute([$question_id]);
        $qData = $stmtQ->fetch(PDO::FETCH_ASSOC);
        if (!$qData) continue;

        $marks = floatval($qData['marks_per_question']);
        $total += $marks;

        $is_correct = ($selected == $qData['correct_option']) ? 1 : 0;
        $score = $is_correct ? $marks : (($negative_mark > 0) ? -$negative_mark : 0);

        $obtained += $score;

        $stmtA = $pdo->prepare("
            INSERT INTO exam_answers (result_id, question_id, selected_option, is_correct)
            VALUES (?, ?, ?, ?)
        ");
        $stmtA->execute([$result_id, $question_id, $selected, $is_correct]);
    }

    $stmtUpdate = $pdo->prepare("
        UPDATE exam_results
        SET total_marks = ?, obtained_marks = ?, submitted_at = NOW()
        WHERE result_id = ?
    ");
    $stmtUpdate->execute([$total, $obtained, $result_id]);

    // Clear ONLY exam tracking
    unset($_SESSION['exam_id'], $_SESSION['link_id']);

    header("Location: student.php?action=examSubmitted&result_id=" . $result_id);
    exit;
}


// Exam submitted page
function examSubmittedPage() {
    global $pdo;

    $result_id = intval($_GET['result_id'] ?? 0);
    if (!$result_id) {
        header("Location: student.php?action=dashboard");
        exit;
    }

    $stmt = $pdo->prepare("
        SELECT er.*, e.exam_title 
        FROM exam_results er
        JOIN exams e ON er.exam_id = e.exam_id
        WHERE er.result_id = ?
    ");
    $stmt->execute([$result_id]);
    $result = $stmt->fetch(PDO::FETCH_ASSOC);
    if (!$result) {
        header("Location: student.php?action=dashboard");
        exit;
    }

   include __DIR__ . '/templates/student/exam_submitted.php';

}


?>

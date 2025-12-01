<?php
// admin.php → Central Admin Controller for Online Examination System
// Handles Dashboard,Login/Logout
// /controllers/ExamController.php

session_start(); // Start PHP session

//  Load config and required classes
require("config/config.php");
require_once __DIR__ . "/classes/Admin.php";
require_once __DIR__ . "/classes/Subject.php";
require_once __DIR__ . "/classes/QuestionBank.php";
require_once __DIR__ . "/classes/Question.php";
require_once __DIR__ . "/classes/Exam.php";
require_once __DIR__ . "/classes/Classroom.php";
require_once __DIR__ . "/classes/Student.php";

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

   // Question Bank management
    case 'newBank':
        newBank();
        break;

    case 'manageBanks':
        manageBanks();
        break;

    case 'editBank':
        editBank();
        break;

 // Question management
    case 'newQuestion':
        newQuestion();
        break;
    case 'manageQuestions':
        manageQuestions();
        break;
    case 'editQuestion':
        editQuestion();
        break;

//EXAM MODULE ROUTES
     case 'newExam':
        newExam(); 
        break;

    case 'manageExams':
        manageExams();
        break;

    case 'editExam':
        editExam();
        break;

// STUDENT MODULE ROUTES
case 'newStudent':
    newStudent();
    break;

case 'manageStudents':
    manageStudents();
    break;

case 'editStudent':
    editStudent();
    break;

// CLASSROOM MODULE ROUTES
case 'newClassroom':
    newClassroom();
    break;

case 'manageClasses':
    manageClasses();
    break;

case 'editClassroom':
    editClassroom();
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

    require(TEMPLATE_PATH . "/subjects/manage_subjects.php");
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

// -------------------------
// QUESTION BANK MANAGEMENT
// -------------------------
function newBank() {
    global $pdo;
    $results = [
        'message'   => '',
        'pageTitle' => 'Add New Bank'
    ];

    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        $bank_name  = trim($_POST['bank_name'] ?? '');
        $description = trim($_POST['description'] ?? '');

        if (empty($bank_name)) {
            $results['message'] = " Bank name is required!";
        } else {
            // Create bank
            $bankId = QuestionBank::create($pdo, $bank_name, $description);

            if ($bankId) {
                $results['message'] = " Bank added successfully!";
                $bank_name = $description = '';
            } else {
                $results['message'] = " Error adding bank!";
            }
        }
    }

    require(TEMPLATE_PATH . "/question_banks/add_bank.php");
}

// MANAGE QUESTION BANKS
function manageBanks() {
    global $pdo;
    $results = [
        'message'   => '',
        'pageTitle' => 'Manage Banks',
        'banks'     => []
    ];

    // Handle delete
    if (isset($_GET['delete'])) {
        $bankId = (int)$_GET['delete'];
        $results['message'] = QuestionBank::delete($pdo, $bankId) 
            ? " Bank deleted!" 
            : " Error deleting bank!";
    }

    // Pagination
    $perPage = 25;
    $page = isset($_GET['page']) ? max(1, (int)$_GET['page']) : 1;
    $offset = ($page - 1) * $perPage;

    // Total banks
    $stmtTotal = $pdo->query("SELECT COUNT(*) FROM question_banks");
    $total = (int)$stmtTotal->fetchColumn();
    $totalPages = ceil($total / $perPage);

    // Fetch banks + total questions in one query
    $stmt = $pdo->prepare("
        SELECT qb.bank_id, qb.bank_name, qb.description, qb.created_at,
               COUNT(q.question_id) AS total_questions
        FROM question_banks qb
        LEFT JOIN questions q ON q.bank_id = qb.bank_id
        GROUP BY qb.bank_id
        ORDER BY qb.bank_id DESC
        LIMIT :limit OFFSET :offset
    ");
    $stmt->bindValue(':limit', $perPage, PDO::PARAM_INT);
    $stmt->bindValue(':offset', $offset, PDO::PARAM_INT);
    $stmt->execute();
    $results['banks'] = $stmt->fetchAll(PDO::FETCH_ASSOC);

    $results['currentPage'] = $page;
    $results['totalPages']  = $totalPages;

    require(TEMPLATE_PATH . "/question_banks/manage_bank.php");
}

function editBank() {
    global $pdo;
    $results = ['message' => '', 'pageTitle' => 'Edit Bank'];

    if (!isset($_GET['id'])) die(" No bank ID given.");
    $bankId = (int)$_GET['id'];

    // Fetch bank
    $bank = QuestionBank::getById($pdo, $bankId);

    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        $bankData = [
            'bank_name'   => trim($_POST['bank_name'] ?? ''),
            'description' => trim($_POST['description'] ?? '')
        ];

        if (QuestionBank::update($pdo, $bankId, $bankData)) {
            $results['message'] = " Bank updated successfully!";
        } else {
            $results['message'] = " Error updating bank!";
        }

        $bank = QuestionBank::getById($pdo, $bankId); // refresh
    }

    $results['bank'] = $bank;

    require(TEMPLATE_PATH . "/question_banks/edit_bank.php");
}

// ------------------------- 
// QUESTION MANAGEMENT
// -------------------------

function newQuestion() {
    global $pdo;

    $results = [
        'message'   => '',
        'pageTitle' => 'Add New Question',
        'banks'     => QuestionBank::getAll($pdo),
        'subjects'  => Subject::getAll($pdo)
    ];

    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        $bank_id            = (int)($_POST['bank_id'] ?? 0);
        $subject_id         = (int)($_POST['subject_id'] ?? 0);
        $question_text      = trim($_POST['question_text'] ?? '');
        $option_a           = trim($_POST['option_a'] ?? '');
        $option_b           = trim($_POST['option_b'] ?? '');
        $option_c           = trim($_POST['option_c'] ?? '');
        $option_d           = trim($_POST['option_d'] ?? '');
        $correct_option     = $_POST['correct_option'] ?? '';
        $marks_per_question = floatval($_POST['marks_per_question'] ?? 1.0);
        $difficulty         = $_POST['difficulty'] ?? 'Easy';

        if ($bank_id <= 0 || $subject_id <= 0 || empty($question_text) || empty($option_a) || empty($option_b) || empty($correct_option)) {
            $results['message'] = "Please fill all required fields!";
        } else {
            $questionId = Question::create(
                $pdo, $bank_id, $subject_id, $question_text,
                $option_a, $option_b, $option_c, $option_d,
                $correct_option, $marks_per_question, $difficulty
            );

            if ($questionId) {
                $results['message'] = "Question added successfully!";
                $_POST = [];
            } else {
                $results['message'] = "Error adding question!";
            }
        }
    }

    require(TEMPLATE_PATH . "/questions/add_question.php");
}

function manageQuestions() {
    global $pdo;

    $results = [
        'message'    => '',
        'pageTitle'  => 'Manage Questions',
        'questions'  => []
    ];

    if (isset($_GET['delete'])) {
        $questionId = (int)$_GET['delete'];
        if (Question::delete($pdo, $questionId)) {
            $results['message'] = "Question deleted successfully!";
        } else {
            $results['message'] = "Error deleting question!";
        }
    }

    $perPage = 25;
    $page    = isset($_GET['page']) ? max(1, (int)$_GET['page']) : 1;
    $offset  = ($page - 1) * $perPage;

    $stmtTotal = $pdo->query("SELECT COUNT(*) FROM questions");
    $total = (int)$stmtTotal->fetchColumn();
    $totalPages = ceil($total / $perPage);

    $stmt = $pdo->prepare("
        SELECT q.question_id, q.question_text, q.correct_option, q.marks_per_question, q.difficulty,
               b.bank_name, s.subject_name
        FROM questions q
        LEFT JOIN question_banks b ON q.bank_id = b.bank_id
        LEFT JOIN subjects s ON q.subject_id = s.subject_id
        ORDER BY q.question_id ASC
        LIMIT :limit OFFSET :offset
    ");
    $stmt->bindValue(':limit', $perPage, PDO::PARAM_INT);
    $stmt->bindValue(':offset', $offset, PDO::PARAM_INT);
    $stmt->execute();
    $results['questions'] = $stmt->fetchAll(PDO::FETCH_ASSOC);

    $results['currentPage'] = $page;
    $results['totalPages']  = $totalPages;
    $results['total']       = $total;
    $results['perPage']     = $perPage;

    require(TEMPLATE_PATH . "/questions/manage_questions.php");
}

function editQuestion() {
    global $pdo;

    $results = [
        'message'   => '',
        'pageTitle' => 'Edit Question',
        'banks'     => QuestionBank::getAll($pdo),
        'subjects'  => Subject::getAll($pdo)
    ];

    if (!isset($_GET['id'])) die("No question ID given.");
    $questionId = (int)$_GET['id'];

    $question = Question::getById($pdo, $questionId);
    if (!$question) die("Question not found.");

    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        $questionData = [
            'bank_id'            => (int)($_POST['bank_id'] ?? 0),
            'subject_id'         => (int)($_POST['subject_id'] ?? 0),
            'question_text'      => trim($_POST['question_text'] ?? ''),
            'option_a'           => trim($_POST['option_a'] ?? ''),
            'option_b'           => trim($_POST['option_b'] ?? ''),
            'option_c'           => trim($_POST['option_c'] ?? ''),
            'option_d'           => trim($_POST['option_d'] ?? ''),
            'correct_option'     => $_POST['correct_option'] ?? '',
            'marks_per_question' => floatval($_POST['marks_per_question'] ?? 1.0),
            'difficulty'         => $_POST['difficulty'] ?? 'Easy'
        ];

        $success = Question::update($pdo, $questionId, $questionData);
        $results['message'] = $success ? "Question updated successfully!" : "Error updating question!";
        $question = Question::getById($pdo, $questionId);
    }

    $results['question'] = $question;
    require(TEMPLATE_PATH . "/questions/edit_question.php");
}

// -------------------------
// EXAM MANAGEMENT
// -------------------------
// Add Exam Controller

function newExam() {
    global $pdo;
    $results = ['message' => '', 'pageTitle' => 'Add New Exam'];

    // Load dropdown data
    $results['subjects'] = Exam::getAllSubjects($pdo);
    $results['question_banks'] = Exam::getAllQuestionBanks($pdo);
    $results['classes']  = Exam::getAllClasses($pdo);
    $results['students'] = Exam::getAllStudents($pdo);
    $results['exam_question_sources'] = $_POST['exam_question_sources'] ?? [];

    if ($_SERVER['REQUEST_METHOD'] === 'POST') {

        // Basic Fields
        $exam_title         = trim($_POST['exam_title'] ?? '');
        $exam_description   = trim($_POST['exam_description'] ?? '');
        $duration_minutes   = (int)($_POST['duration_minutes'] ?? 30);

        // Settings
        $shuffle_questions  = isset($_POST['shuffle_questions']) ? 1 : 0;
        $shuffle_options    = isset($_POST['shuffle_options']) ? 1 : 0;
        $negative_marking   = (float)($_POST['negative_marking'] ?? 0);

        // Timings
        $start_time         = $_POST['start_time'] ?? null;
        $end_time           = $_POST['end_time'] ?? null;

        // Assignment
        $assign_type        = $_POST['assign_type'] ?? 'class';
        $assign_data        = $_POST['assign_data'] ?? [];

        // Question Sources
        $exam_question_sources = $_POST['exam_question_sources'] ?? [];

        // Calculate total questions
        $total_questions = 0;
        foreach ($exam_question_sources as $bank_id => $subjects) {
            foreach ($subjects as $subject_id => $limit) {
                $limit = (int)$limit;
                if ($limit > 0) {
                    $total_questions += $limit;
                }
            }
        }

        // Validations
        if (empty($exam_title)) {
            $results['message'] = "Exam title is required!";
        } elseif ($total_questions <= 0) {
            $results['message'] = "You must select at least one question!";
        } else {

            // CREATE EXAM
            $exam_id = Exam::create($pdo, [
                'exam_title'        => $exam_title,
                'exam_description'  => $exam_description,
                'duration_minutes'  => $duration_minutes,
                'total_questions'   => $total_questions,
                'shuffle_questions' => $shuffle_questions,
                'shuffle_options'   => $shuffle_options,
                'negative_marking'  => $negative_marking,
                'start_time'        => $start_time,
                'end_time'          => $end_time,
                'assign_type'       => $assign_type,
                'assign_data'       => $assign_data   
            ]);

            if ($exam_id) {

                // Insert question sources
                $stmtSource = $pdo->prepare("
                    INSERT INTO exam_question_sources 
                    (exam_id, bank_id, subject_id, question_limit) 
                    VALUES (?, ?, ?, ?)
                ");

                foreach ($exam_question_sources as $bank_id => $subjects) {
                    foreach ($subjects as $subject_id => $limit) {
                        $stmtSource->execute([$exam_id, $bank_id, $subject_id, (int)$limit]);
                    }
                }

               // Auto-generate exam link (store only code in DB)
$link       = 'exam-' . $exam_id . '-' . bin2hex(random_bytes(4));
$password   = $_POST['exam_password'] ?? '';
$expires_at = $_POST['expires_at'] ?? null;

// Store link code in DB
Exam::createExamLink($pdo, $exam_id, $link, $password, $expires_at);

// Full URL to show admin (no DB change)
$fullExamUrl = BASE_URL . "student.php?action=startExam&link=" . $link;

// Show full link in admin template
$results['exam_link'] = $fullExamUrl;


                $results['message'] = "Exam created successfully! Total Questions: $total_questions";
            } else {
                $results['message'] = "Error creating exam!";
            }
        }

        // Preserve form data
        $results['exam_title']        = $exam_title;
        $results['exam_description']  = $exam_description;
        $results['duration_minutes']  = $duration_minutes;
        $results['shuffle_questions'] = $shuffle_questions;
        $results['shuffle_options']   = $shuffle_options;
        $results['negative_marking']  = $negative_marking;
        $results['start_time']        = $start_time;
        $results['end_time']          = $end_time;
        $results['expires_at']        = $expires_at ?? '';
    }

    require(TEMPLATE_PATH . "/exams/add_exam.php");
}

// Manage exam
function manageExams() {
    global $pdo;
    $results = [
        'message'   => '',
        'pageTitle' => 'Manage Exams',
        'exams'     => [],
    ];

    // Handle delete request
    if (isset($_GET['delete'])) {
        $examId = (int)$_GET['delete'];
        if (Exam::delete($pdo, $examId)) {
            $results['message'] = "Exam deleted successfully!";
        } else {
            $results['message'] = "Error deleting exam!";
        }
    }

    // Pagination
    $perPage = 25;
    $page = isset($_GET['page']) ? max(1, (int)$_GET['page']) : 1;
    $offset = ($page - 1) * $perPage;

    // Total exams
    $stmtTotal = $pdo->query("SELECT COUNT(*) FROM exams");
    $total = (int)$stmtTotal->fetchColumn();
    $totalPages = ceil($total / $perPage);

    // Fetch exams for current page
    $stmt = $pdo->prepare("
        SELECT *
        FROM exams
        ORDER BY created_at DESC
        LIMIT :limit OFFSET :offset
    ");
    $stmt->bindValue(':limit', $perPage, PDO::PARAM_INT);
    $stmt->bindValue(':offset', $offset, PDO::PARAM_INT);
    $stmt->execute();
    $results['exams'] = $stmt->fetchAll(PDO::FETCH_ASSOC);

    $results['currentPage'] = $page;
    $results['totalPages']  = $totalPages;
    $results['total']       = $total;
    $results['perPage']     = $perPage;

    require(TEMPLATE_PATH . "/exams/manage_exams.php");
}

function editExam() {
    global $pdo;
    $exam_id = (int)($_GET['id'] ?? 0);
    $results = ['message' => '', 'pageTitle' => 'Edit Exam'];

    // Fetch exam info
    $exam = Exam::getById($pdo, $exam_id);
    if (!$exam) {
        $results['message'] = "Exam not found!";
        require(TEMPLATE_PATH . "/exams/edit_exam.php");
        return;
    }

    // Load dropdowns
    $results['subjects'] = Exam::getAllSubjects($pdo);
    $results['question_banks'] = Exam::getAllQuestionBanks($pdo);
    $results['classes'] = Exam::getAllClasses($pdo);
    $results['students'] = Exam::getAllStudents($pdo);

    // Load question sources
    $sources = Exam::getQuestionSources($pdo, $exam_id);
    $exam_question_sources = [];
    $total_questions = 0;

    foreach ($sources as $src) {
        $bank_id = $src['bank_id'];
        $subject_id = $src['subject_id'];
        $limit = (int)($src['question_limit'] ?? 0);

        $exam_question_sources[$bank_id][$subject_id] = $limit;
        $total_questions += $limit;
    }

    $results['exam_question_sources'] = $exam_question_sources;
    $results['total_questions'] = $total_questions;

    // Load exam link info
    $stmtLink = $pdo->prepare("SELECT * FROM exam_links WHERE exam_id=? LIMIT 1");
    $stmtLink->execute([$exam_id]);
    $linkInfo = $stmtLink->fetch(PDO::FETCH_ASSOC);

    // Ensure BASE_URL ends with slash
    $baseUrl = rtrim(BASE_URL, '/') . '/';

    // Important: FIX EXAM LINK (full URL)
    if (!empty($linkInfo['unique_link'])) {
        $results['exam_link'] = $baseUrl . "student.php?action=startExam&link=" . $linkInfo['unique_link'];
    } else {
        $results['exam_link'] = ''; // empty if no link yet
    }

    $results['expires_at'] = $linkInfo['expires_at'] ?? '';

    // Load exam details
    foreach ($exam as $key => $val) $results[$key] = $val;

    // If form submitted
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {

        $exam_title       = trim($_POST['exam_title'] ?? '');
        $exam_description = trim($_POST['exam_description'] ?? '');
        $duration_minutes = (int)($_POST['duration_minutes'] ?? 30);
        $shuffle_questions = isset($_POST['shuffle_questions']) ? 1 : 0;
        $shuffle_options   = isset($_POST['shuffle_options']) ? 1 : 0;
        $negative_marking  = (float)($_POST['negative_marking'] ?? 0);
        $start_time       = $_POST['start_time'] ?? null;
        $end_time         = $_POST['end_time'] ?? null;
        $assign_type      = $_POST['assign_type'] ?? 'class';
        $assign_data      = $_POST['assign_data'] ?? [];
        $exam_question_sources = $_POST['exam_question_sources'] ?? [];

        // Recalculate total questions
        $total_questions = 0;
        foreach ($exam_question_sources as $bank_id => $subjects) {
            foreach ($subjects as $subject_id => $limit) {
                $limit = (int)$limit;
                if ($limit > 0) $total_questions += $limit;
            }
        }

        // Update exam
        Exam::update($pdo, $exam_id, [
            'exam_title' => $exam_title,
            'exam_description' => $exam_description,
            'duration_minutes' => $duration_minutes,
            'total_questions' => $total_questions,
            'shuffle_questions' => $shuffle_questions,
            'shuffle_options' => $shuffle_options,
            'negative_marking' => $negative_marking,
            'start_time' => $start_time,
            'end_time' => $end_time,
            'assign_type' => $assign_type,
            'assign_data' => $assign_data
        ]);

        // Update question sources
        $pdo->prepare("DELETE FROM exam_question_sources WHERE exam_id=?")->execute([$exam_id]);
        $stmtSource = $pdo->prepare("
            INSERT INTO exam_question_sources (exam_id, bank_id, subject_id, question_limit)
            VALUES (?, ?, ?, ?)
        ");

        foreach ($exam_question_sources as $bank_id => $subjects) {
            foreach ($subjects as $subject_id => $limit) {
                $stmtSource->execute([$exam_id, $bank_id, $subject_id, (int)$limit]);
            }
        }

        // Regenerate exam questions
        Exam::generateQuestions($pdo, $exam_id);

        // Update exam link password + expiry
        $password = $_POST['exam_password'] ?? '';
        $expires_at = $_POST['expires_at'] ?? null;

        if ($linkInfo) {
            $stmt = $pdo->prepare("UPDATE exam_links SET password=?, expires_at=? WHERE exam_id=?");
            $stmt->execute([
                $password ? password_hash($password, PASSWORD_DEFAULT) : $linkInfo['password'],
                $expires_at,
                $exam_id
            ]);
            $finalLinkCode = $linkInfo['unique_link'];
        } else {
            // Generate new link
            $finalLinkCode = 'exam-' . $exam_id . '-' . bin2hex(random_bytes(4));
            Exam::createExamLink($pdo, $exam_id, $finalLinkCode, $password, $expires_at);
        }

        // FIX: Send full link to view
        $results['exam_link'] = $baseUrl . "student.php?action=startExam&link=" . $finalLinkCode;
        $results['total_questions'] = $total_questions;

        $results['message'] = "Exam updated successfully!";
    }

    require(TEMPLATE_PATH . "/exams/edit_exam.php");
}

// -------------------------
// CLASSROOM MANAGEMENT
// -------------------------
function newClassroom() {
    global $pdo;
    $results = ['message' => '', 'pageTitle' => 'Add New Class'];

    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        $class_name = trim($_POST['class_name'] ?? '');

        if (empty($class_name)) {
            $results['message'] = "Class name is required!";
        } else {
            $classId = Classroom::create($pdo, $class_name);
            if ($classId) {
                $results['message'] = "Class added successfully!";
                $class_name = '';
            } else {
                $results['message'] = "Error adding class!";
            }
        }
    }

    require(TEMPLATE_PATH . "/classrooms/add_class.php");
}

//manage classes
function manageClasses() {
    global $pdo;
    $results = [
        'message'   => '',
        'pageTitle' => 'Manage Classes',
        'classes'   => []
    ];

    // Handle delete
    if (isset($_GET['delete'])) {
        $classId = (int)$_GET['delete'];
        if (Classroom::delete($pdo, $classId)) {
            $results['message'] = "Class deleted!";
        } else {
            $results['message'] = "Error deleting class!";
        }
    }

    // Pagination
    $perPage = 25;
    $page = isset($_GET['page']) ? max(1, (int)$_GET['page']) : 1;
    $offset = ($page - 1) * $perPage;

    $stmtTotal = $pdo->query("SELECT COUNT(*) FROM classrooms");
    $total = (int)$stmtTotal->fetchColumn();
    $totalPages = ceil($total / $perPage);

    $stmt = $pdo->prepare("SELECT class_id, class_name FROM classrooms ORDER BY class_id ASC LIMIT :limit OFFSET :offset");
    $stmt->bindValue(':limit', $perPage, PDO::PARAM_INT);
    $stmt->bindValue(':offset', $offset, PDO::PARAM_INT);
    $stmt->execute();
    $results['classes'] = $stmt->fetchAll(PDO::FETCH_ASSOC);

    $results['currentPage'] = $page;
    $results['totalPages'] = $totalPages;

    require(TEMPLATE_PATH . "/classrooms/manage_classes.php");
}

function editClassroom() {
    global $pdo;
    $results = ['message' => '', 'pageTitle' => 'Edit Class'];

    if (!isset($_GET['id'])) die("No class ID given.");
    $classId = (int)$_GET['id'];

    $class = Classroom::getById($pdo, $classId);

    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        $class_name = trim($_POST['class_name'] ?? '');
        if (Classroom::update($pdo, $classId, $class_name)) {
            $results['message'] = "Class updated successfully!";
        } else {
            $results['message'] = "Error updating class!";
        }
        $class = Classroom::getById($pdo, $classId);
    }

    $results['class'] = $class;

    require(TEMPLATE_PATH . "/classrooms/edit_class.php");
}

// -------------------------
// STUDENT MANAGEMENT
// -------------------------
function newStudent() {
    global $pdo;
    $results = ['message' => '', 'pageTitle' => 'Add New Student', 'classes' => Classroom::getAll($pdo)];

    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        $name      = trim($_POST['name'] ?? '');
        $email     = trim($_POST['email'] ?? '');
        $password  = trim($_POST['password'] ?? '');
        $roll_no   = trim($_POST['roll_no'] ?? '');
        $class_id  = (int)($_POST['class_id'] ?? 0);
        $section   = trim($_POST['section'] ?? '');
        $phone     = trim($_POST['phone'] ?? '');
        $status    = trim($_POST['status'] ?? 'Active');

        if (empty($name) || empty($email) || empty($password) || $class_id <= 0) {
            $results['message'] = "Name, Email, Password, and Class are required!";
        } else {
            if (Student::create($pdo, $name, $email, $password, $roll_no, $class_id, $section, $phone, $status)) {
                $results['message'] = "Student added successfully!";
                $name = $email = $password = $roll_no = $section = $phone = '';
            } else {
                $results['message'] = "Error adding student!";
            }
        }
    }

    require(TEMPLATE_PATH . "/students/add_student.php");
}

function manageStudents() {
    global $pdo;
    $results = ['message' => '', 'pageTitle' => 'Manage Students', 'students' => [], 'classes' => Classroom::getAll($pdo)];

    // Handle delete
    if (isset($_GET['delete'])) {
        $studentId = (int)$_GET['delete'];
        if (Student::delete($pdo, $studentId)) {
            $results['message'] = "Student deleted!";
        } else {
            $results['message'] = "Error deleting student!";
        }
    }

    // Pagination
    $perPage = 25;
    $page = isset($_GET['page']) ? max(1, (int)$_GET['page']) : 1;
    $offset = ($page - 1) * $perPage;

    $stmtTotal = $pdo->query("SELECT COUNT(*) FROM students");
    $total = (int)$stmtTotal->fetchColumn();
    $totalPages = ceil($total / $perPage);

    $stmt = $pdo->prepare("
        SELECT s.*, c.class_name 
        FROM students s 
        LEFT JOIN classrooms c ON s.class_id = c.class_id 
        ORDER BY student_id ASC 
        LIMIT :limit OFFSET :offset
    ");
    $stmt->bindValue(':limit', $perPage, PDO::PARAM_INT);
    $stmt->bindValue(':offset', $offset, PDO::PARAM_INT);
    $stmt->execute();
    $results['students'] = $stmt->fetchAll(PDO::FETCH_ASSOC);

    $results['currentPage'] = $page;
    $results['totalPages'] = $totalPages;

    require(TEMPLATE_PATH . "/students/manage_students.php");
}

function editStudent() {
    global $pdo;
    $results = ['message' => '', 'pageTitle' => 'Edit Student', 'classes' => Classroom::getAll($pdo)];

    if (!isset($_GET['id'])) die("No student ID given.");
    $studentId = (int)$_GET['id'];

    $student = Student::getById($pdo, $studentId);

    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        $name      = trim($_POST['name'] ?? '');
        $email     = trim($_POST['email'] ?? '');
        $password  = trim($_POST['password'] ?? '');
        $roll_no   = trim($_POST['roll_no'] ?? '');
        $class_id  = (int)($_POST['class_id'] ?? 0);
        $section   = trim($_POST['section'] ?? '');
        $phone     = trim($_POST['phone'] ?? '');
        $status    = trim($_POST['status'] ?? 'Active');

        if (Student::update($pdo, $studentId, $name, $email, $password, $roll_no, $class_id, $section, $phone, $status)) {
            $results['message'] = "Student updated successfully!";
        } else {
            $results['message'] = "Error updating student!";
        }

        $student = Student::getById($pdo, $studentId);
    }

    $results['student'] = $student;

    require(TEMPLATE_PATH . "/students/edit_student.php");
}

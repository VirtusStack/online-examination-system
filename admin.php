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

    case 'assignQuestions':
        assignQuestions();
        break;

    case 'generateLinks':
        generateLinks();
        break;

    case 'viewResults':
        viewResults();
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

    $results['subjects'] = Exam::getAllSubjects($pdo);
    $results['question_banks'] = Exam::getAllQuestionBanks($pdo);
    $results['exam_question_sources'] = $_POST['exam_question_sources'] ?? [];

    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        $exam_title       = trim($_POST['exam_title'] ?? '');
        $exam_description = trim($_POST['exam_description'] ?? '');
        $duration_minutes = (int)($_POST['duration_minutes'] ?? 30);
        $shuffle_questions = isset($_POST['shuffle_questions']) ? 1 : 0;
        $shuffle_options   = isset($_POST['shuffle_options']) ? 1 : 0;
        $negative_marking  = (float)($_POST['negative_marking'] ?? 0);
        $start_time        = $_POST['start_time'] ?? null;
        $end_time          = $_POST['end_time'] ?? null;
        $assign_type       = $_POST['assign_type'] ?? 'class';
        $assign_data       = $_POST['assign_data'] ?? [];
        $exam_question_sources = $_POST['exam_question_sources'] ?? [];

        $total_questions = 0;
        foreach ($exam_question_sources as $bank_id => $subjects) {
            foreach ($subjects as $subject_id => $limit) {
                $limit = (int)$limit;
                if ($limit > 0) $total_questions += $limit;
            }
        }

        if (empty($exam_title)) {
            $results['message'] = "Exam title is required!";
        } elseif ($total_questions <= 0) {
            $results['message'] = "You must select at least one question!";
        } else {
            // CREATE exam
            $exam_id = Exam::create($pdo, [
                'exam_title' => $exam_title,
                'exam_description' => $exam_description,
                'duration_minutes' => $duration_minutes,
                'total_questions' => $total_questions,
                'shuffle_questions'=> $shuffle_questions,
                'shuffle_options'  => $shuffle_options,
                'negative_marking' => $negative_marking,
                'start_time' => $start_time,
                'end_time'   => $end_time,
                'assign_type'=> $assign_type,
                'assign_data'=> $assign_data
            ]);

            if ($exam_id) {
                // Insert question sources
                $stmtSource = $pdo->prepare("
                    INSERT INTO exam_question_sources (exam_id, bank_id, subject_id, question_limit) 
                    VALUES (?, ?, ?, ?)
                ");
                foreach ($exam_question_sources as $bank_id => $subjects) {
                    foreach ($subjects as $subject_id => $limit) {
                        $stmtSource->execute([$exam_id, $bank_id, $subject_id, (int)$limit]);
                    }
                }

                // Generate exam questions
                Exam::generateQuestions($pdo, $exam_id);

                // Generate unique exam link automatically
                $link = 'exam-' . $exam_id . '-' . bin2hex(random_bytes(4));
                $password = $_POST['exam_password'] ?? '';
                $expires_at = $_POST['expires_at'] ?? null;
                Exam::createExamLink($pdo, $exam_id, $link, $password, $expires_at);

                $results['message'] = "Exam created successfully! Total Questions: $total_questions";
            } else {
                $results['message'] = "Error creating exam!";
            }
        }

        // Preserve form values
        $results['exam_title']       = $exam_title;
        $results['exam_description'] = $exam_description;
        $results['duration_minutes'] = $duration_minutes;
        $results['shuffle_questions']= $shuffle_questions;
        $results['shuffle_options']  = $shuffle_options;
        $results['negative_marking'] = $negative_marking;
        $results['start_time']       = $start_time;
        $results['end_time']         = $end_time;
        $results['exam_link']        = $link ?? '';
        $results['expires_at']       = $expires_at ?? '';
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
    $results = ['message'=>'', 'pageTitle'=>'Edit Exam'];

    // Fetch exam info
    $exam = Exam::getById($pdo, $exam_id);
    if (!$exam) {
        $results['message'] = "Exam not found!";
        require(TEMPLATE_PATH."/exams/edit_exam.php");
        return;
    }

    $results['subjects'] = Exam::getAllSubjects($pdo);
    $results['question_banks'] = Exam::getAllQuestionBanks($pdo);

    // Load question sources and prepare array like in add_exam
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
    $results['exam_link'] = $linkInfo['unique_link'] ?? '';
    $results['expires_at'] = $linkInfo['expires_at'] ?? '';

    // Load exam details into $results (like add form)
    foreach ($exam as $key=>$val) $results[$key] = $val;

    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        $exam_title       = trim($_POST['exam_title'] ?? '');
        $exam_description = trim($_POST['exam_description'] ?? '');
        $duration_minutes = (int)($_POST['duration_minutes'] ?? 30);
        $shuffle_questions= isset($_POST['shuffle_questions']) ? 1 : 0;
        $shuffle_options  = isset($_POST['shuffle_options']) ? 1 : 0;
        $negative_marking = (float)($_POST['negative_marking'] ?? 0);
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
            'exam_title'=>$exam_title,
            'exam_description'=>$exam_description,
            'duration_minutes'=>$duration_minutes,
            'total_questions'=>$total_questions,
            'shuffle_questions'=>$shuffle_questions,
            'shuffle_options'=>$shuffle_options,
            'negative_marking'=>$negative_marking,
            'start_time'=>$start_time,
            'end_time'=>$end_time,
            'assign_type'=>$assign_type,
            'assign_data'=>$assign_data
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

        // Update exam link password and expiration
        $password = $_POST['exam_password'] ?? '';
        $expires_at = $_POST['expires_at'] ?? null;
        if ($linkInfo) {
            $stmt = $pdo->prepare("UPDATE exam_links SET password=?, expires_at=? WHERE exam_id=?");
            $stmt->execute([$password ? password_hash($password,PASSWORD_DEFAULT):$linkInfo['password'], $expires_at, $exam_id]);
        } else {
            // create new link if missing
            $link = 'exam-' . $exam_id . '-' . bin2hex(random_bytes(4));
            Exam::createExamLink($pdo, $exam_id, $link, $password, $expires_at);
        }

        $results['message'] = "Exam updated successfully!";
        $results['exam_link'] = $linkInfo['unique_link'] ?? $link ?? '';
        $results['total_questions'] = $total_questions;
    }

    require(TEMPLATE_PATH . "/exams/edit_exam.php");
}

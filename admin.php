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
require_once __DIR__ . "/classes/ExamQuestion.php";
require_once __DIR__ . "/classes/ExamLink.php";
require_once __DIR__ . "/classes/ExamResult.php";
require_once __DIR__ . "/classes/ExamQuestionSource.php";

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

function newExam() {
    global $pdo;
    
    // Prepare results array for template
    $results = [
        'message'   => '',
        'pageTitle' => 'Add New Exam',
        'subjects'  => Subject::getAll($pdo)   // All subjects for multi-select
    ];

    if ($_SERVER['REQUEST_METHOD'] === 'POST') {

        // Collect exam basic data
        $data = [
            'exam_title'       => trim($_POST['exam_title'] ?? ''),
            'exam_description' => trim($_POST['exam_description'] ?? ''),
            'total_questions'  => (int)($_POST['total_questions'] ?? 0),
            'duration_minutes' => (int)($_POST['duration_minutes'] ?? 30),
            'shuffle_questions'=> isset($_POST['shuffle_questions']) ? 1 : 0,
            'shuffle_options'  => isset($_POST['shuffle_options']) ? 1 : 0,
            'start_time'       => $_POST['start_time'] ?? null,
            'end_time'         => $_POST['end_time'] ?? null,
            'passing_marks'    => (float)($_POST['passing_marks'] ?? 0),
            'negative_marking' => (float)($_POST['negative_marking'] ?? 0),
            'status'           => $_POST['status'] ?? 'Inactive'
        ];

        // Validate exam title
        if (empty($data['exam_title'])) {
            $results['message'] = " Exam title is required!";
        } else {
            // Create exam
            $examId = Exam::create($pdo, $data);
            if ($examId) {

                // Get multi-select inputs
                $subjectIds = $_POST['subject_ids'] ?? [];
                $easyPct    = (int)($_POST['easy_percent'] ?? 30);
                $mediumPct  = (int)($_POST['medium_percent'] ?? 50);
                $hardPct    = (int)($_POST['hard_percent'] ?? 20);

                // Create exam_question_sources entries for each subject & difficulty
                foreach ($subjectIds as $subjectId) {
                    ExamQuestionSource::add($pdo, $examId, null, $subjectId, 'Easy', null);
                    ExamQuestionSource::add($pdo, $examId, null, $subjectId, 'Medium', null);
                    ExamQuestionSource::add($pdo, $examId, null, $subjectId, 'Hard', null);
                }

                $results['message'] = " Exam added successfully!";
            } else {
                $results['message'] = " Error adding exam!";
            }
        }
    }

    require(TEMPLATE_PATH . "/exams/add_exam.php");
}


function manageExams() {
    global $pdo;
    $results = [
        'message' => '',
        'pageTitle' => 'Manage Exams',
        'exams' => []
    ];

    if (isset($_GET['delete'])) {
        $examId = (int)$_GET['delete'];
        $results['message'] = Exam::delete($pdo, $examId) ? " Exam deleted!" : " Error deleting exam!";
    }

    $perPage = 20;
    $page = max(1, (int)($_GET['page'] ?? 1));
    $offset = ($page - 1) * $perPage;

    $stmtTotal = $pdo->query("SELECT COUNT(*) FROM exams");
    $total = (int)$stmtTotal->fetchColumn();
    $totalPages = ceil($total / $perPage);

    $stmt = $pdo->prepare("
        SELECT * FROM exams
        ORDER BY exam_id DESC
        LIMIT :limit OFFSET :offset
    ");
    $stmt->bindValue(':limit', $perPage, PDO::PARAM_INT);
    $stmt->bindValue(':offset', $offset, PDO::PARAM_INT);
    $stmt->execute();
    $results['exams'] = $stmt->fetchAll(PDO::FETCH_ASSOC);

    $results['currentPage'] = $page;
    $results['totalPages']  = $totalPages;

    require(TEMPLATE_PATH . "/exams/manage_exams.php");
}

// Edit Exam function

function editExam() {
    global $pdo;

    // Ensure exam ID is provided
    if (!isset($_GET['id'])) die("No exam ID given.");
    $examId = (int)$_GET['id'];

    // Fetch exam
    $exam = Exam::getById($pdo, $examId);
    if (!$exam) die("Exam not found!");

    // Prepare data for template
    $results = [
        'message'   => '',
        'pageTitle' => 'Edit Exam',
        'subjects'  => Subject::getAll($pdo),  // Load all subjects for possible use
        'exam'      => $exam
    ];

    // Handle form submission
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        $data = [
            'exam_title'       => trim($_POST['exam_title'] ?? ''),
            'exam_description' => trim($_POST['exam_description'] ?? ''),
            'total_questions'  => (int)($_POST['total_questions'] ?? 0),
            'duration_minutes' => (int)($_POST['duration_minutes'] ?? 30),
            'shuffle_questions'=> isset($_POST['shuffle_questions']) ? 1 : 0,
            'shuffle_options'  => isset($_POST['shuffle_options']) ? 1 : 0,
            'start_time'       => $_POST['start_time'] ?? null,
            'end_time'         => $_POST['end_time'] ?? null,
            'passing_marks'    => (float)($_POST['passing_marks'] ?? 0),
            'negative_marking' => (float)($_POST['negative_marking'] ?? 0),
            'status'           => $_POST['status'] ?? 'Inactive'
        ];

        // Update exam
        $success = Exam::update($pdo, $examId, $data);

        $results['message'] = $success ? 
            "Exam updated successfully!" : 
            "Error updating exam!";

        // Refresh exam data
        $results['exam'] = Exam::getById($pdo, $examId);
    }

    // Load edit template
    require(TEMPLATE_PATH . "/exams/edit_exam.php");
}

function assignQuestions() {
    global $pdo;

    // Ensure exam ID is provided
    if (!isset($_GET['id'])) die("No exam ID given.");
    $examId = (int)$_GET['id'];

    // Prepare initial results array
    $results = [
        'message'  => '',
        'pageTitle'=> 'Assign Questions to Exam',
        'questions'=> [],
        'assigned' => ExamQuestion::getByExam($pdo, $examId),
        'sources'  => ExamQuestionSource::getByExam($pdo, $examId),
        'exam'     => Exam::getById($pdo, $examId)
    ];

    $questions = [];

    // Loop through each source to fetch questions
    foreach ($results['sources'] as $source) {
        $query  = "SELECT * FROM questions WHERE 1=1";
        $params = [];

        // Filter by subject
        if (!empty($source['subject_id'])) { 
            $query .= " AND subject_id=?"; 
            $params[] = $source['subject_id']; 
        }

        // Filter by difficulty
        if (!empty($source['difficulty'])) { 
            $query .= " AND difficulty=?"; 
            $params[] = $source['difficulty']; 
        }

        $stmt = $pdo->prepare($query);
        $stmt->execute($params);
        $allQuestions = $stmt->fetchAll(PDO::FETCH_ASSOC);

        // Apply question limit if set
        if (!empty($source['question_limit'])) { 
            shuffle($allQuestions); 
            $allQuestions = array_slice($allQuestions, 0, $source['question_limit']); 
        }

        // Merge without duplicates
        foreach ($allQuestions as $q) {
            if (!isset($questions[$q['question_id']])) {
                $questions[$q['question_id']] = $q;
            }
        }
    }

    // Convert associative array back to indexed array
    $results['questions'] = array_values($questions);

    // Handle POST request for assignment
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        // Remove all previous assignments
        ExamQuestion::removeAllByExam($pdo, $examId);

        if (isset($_POST['auto_select'])) {
            // Auto-select random questions
            $totalQuestions = (int)($_POST['total_questions'] ?? $results['exam']['total_questions']);
            shuffle($results['questions']);
            $selectedQuestions = array_slice($results['questions'], 0, $totalQuestions);

            foreach ($selectedQuestions as $q) { 
                ExamQuestion::add($pdo, $examId, $q['question_id']); 
            }
            $results['message'] = "Questions assigned automatically!";
        } else {
            // Manual selection
            foreach ($_POST['question_ids'] ?? [] as $qId) { 
                ExamQuestion::add($pdo, $examId, (int)$qId); 
            }
            $results['message'] = "Questions assigned manually!";
        }

        // Refresh assigned questions
        $results['assigned'] = ExamQuestion::getByExam($pdo, $examId);
    }

    require(TEMPLATE_PATH . "/exams/assign_questions.php");
}

function generateLinks() {
    global $pdo;

    $examId = isset($_GET['id']) ? (int)$_GET['id'] : null;

    $results = [
        'message'   => '',
        'pageTitle' => 'Generate Exam Links',
        'exams'     => Exam::getAll($pdo), // all exams for dropdown
        'links'     => []
    ];

    if ($examId) {
        $results['exam']  = Exam::getById($pdo, $examId);
        $results['links'] = ExamLink::getByExam($pdo, $examId);
    }

    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        $examId = (int)($_POST['exam_id'] ?? 0);
        $unique_link = ExamLink::create(
            $pdo,
            $examId,
            trim($_POST['student_name'] ?? null),
            trim($_POST['student_email'] ?? null),
            trim($_POST['student_class'] ?? null),
            trim($_POST['password'] ?? null),
            $_POST['expires_at'] ?? null
        );

        $results['message'] = $unique_link ? "Link generated successfully!" : "Error generating link!";
        $results['links']   = ExamLink::getByExam($pdo, $examId);
    }

    require(TEMPLATE_PATH . "/exams/generate_links.php");
}



// -------------------------
// VIEW EXAM RESULTS
// -------------------------
function viewResults() {
    global $pdo;
    if (!isset($_GET['id'])) die(" No exam ID given.");
    $examId = (int)$_GET['id'];

    $stmt = $pdo->prepare("
        SELECT er.*, el.student_name, el.student_email, el.student_class
        FROM exam_results er
        JOIN exam_links el ON er.link_id = el.link_id
        WHERE er.exam_id=?
        ORDER BY er.submitted_at DESC
    ");
    $stmt->execute([$examId]);
    $results = [
        'message'   => '',
        'pageTitle' => 'View Exam Results',
        'results'   => $stmt->fetchAll(PDO::FETCH_ASSOC)
    ];

    require(TEMPLATE_PATH . "/exams/view_results.php");
}

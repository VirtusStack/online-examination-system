<?php
// student.php
require_once __DIR__ . "/config/config.php";
require_once __DIR__ . "/classes/ExamLink.php";
require_once __DIR__ . "/classes/ExamResult.php";

$action = $_GET['action'] ?? 'login';
$message = '';

switch($action) {

    // Show login form
    case 'login':
        require TEMPLATE_PATH . "/student/login_form.php";
        break;

    // Handle form submission: student enters link & details
    case 'startExam':
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $unique_link = trim($_POST['unique_link'] ?? '');
            $name        = trim($_POST['student_name'] ?? '');
            $email       = trim($_POST['student_email'] ?? '');
            $class       = trim($_POST['student_class'] ?? '');
            $password    = trim($_POST['password'] ?? '');

            $linkInfo = ExamLink::getByLink($pdo, $unique_link);

            if (!$linkInfo) {
                $message = "Invalid or used link!";
            } elseif ($linkInfo['password'] && $linkInfo['password'] !== $password) {
                $message = "Incorrect password!";
            } else {
                // Save student info in exam_results and mark link used
                $result_id = ExamResult::create($pdo, $linkInfo['link_id'], $linkInfo['exam_id'], $name, $email);
                ExamLink::markUsed($pdo, $linkInfo['link_id']);

                // Redirect to exam page
                header("Location: student.php?action=takeExam&result_id=" . $result_id);
                exit;
            }
        }
        require TEMPLATE_PATH . "/student/login_form.php";
        break;

    // Show exam questions page
    case 'takeExam':
        $result_id = (int)($_GET['result_id'] ?? 0);
        if (!$result_id) {
            die("No exam found.");
        }

        $examData = ExamResult::getExamByResult($pdo, $result_id);
        require TEMPLATE_PATH . "/student/exam_page.php";
        break;

    default:
        echo "Invalid action.";
}
?>

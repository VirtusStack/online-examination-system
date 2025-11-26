<?php
// /classes/Student.php
// ---------------------------
// Student class for student panel

require_once __DIR__ . "/ExamLink.php";
require_once __DIR__ . "/ExamResult.php";

class Student {

    // Get exam link by token
    public static function getExamLink($pdo, $link_token) {
        return ExamLink::getByLink($pdo, $link_token); // only unused links
    }

    // Validate student password for link
    public static function validatePassword($exam_link, $password) {
        return $exam_link['password'] === $password;
    }

    // Start exam: save student info and mark link used
    public static function startExam($pdo, $exam_link, $student_name, $student_email, $student_class) {
        // Update student info in link
        $stmt = $pdo->prepare("UPDATE exam_links SET student_name=?, student_email=?, student_class=? WHERE link_id=?");
        $stmt->execute([$student_name, $student_email, $student_class, $exam_link['link_id']]);

        // Insert exam result entry
        $stmt2 = $pdo->prepare("INSERT INTO exam_results (link_id, exam_id, student_name, student_email, started_at) VALUES (?, ?, ?, ?, NOW())");
        $stmt2->execute([$exam_link['link_id'], $exam_link['exam_id'], $student_name, $student_email]);

        // Mark link used
        ExamLink::markUsed($pdo, $exam_link['link_id']);

        return true;
    }
}
?>

<?php
// /classes/ExamResult.php
// ---------------------------
// ExamResult class for storing and fetching exam results

class ExamResult {

    // CREATE new result
    public static function create($pdo, $exam_id, $link_id, $student_name = null, $student_email = null, $total_marks = 0, $obtained_marks = 0, $started_at = null, $submitted_at = null) {
        try {
            $stmt = $pdo->prepare("
                INSERT INTO exam_results (exam_id, link_id, student_name, student_email, total_marks, obtained_marks, started_at, submitted_at)
                VALUES (?, ?, ?, ?, ?, ?, ?, ?)
            ");
            $stmt->execute([$exam_id, $link_id, $student_name, $student_email, $total_marks, $obtained_marks, $started_at, $submitted_at]);
            return $pdo->lastInsertId();
        } catch (PDOException $e) {
            error_log("Create exam result failed: " . $e->getMessage());
            return false;
        }
    }

    // GET all results for an exam
    public static function getByExam($pdo, $exam_id) {
        $stmt = $pdo->prepare("
            SELECT er.*, el.student_name, el.student_email 
            FROM exam_results er
            JOIN exam_links el ON er.link_id = el.link_id
            WHERE er.exam_id=?
            ORDER BY er.submitted_at DESC
        ");
        $stmt->execute([$exam_id]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
}
?>

<?php
// /classes/ExamQuestionSource.php
// ---------------------------
// ExamQuestionSource class for multi-subject question assignment
// Bank references removed

class ExamQuestionSource {

    // ADD a source for exam questions
    public static function add($pdo, $exam_id, $subject_id = null, $difficulty = null, $question_limit = null) {
        try {
            $stmt = $pdo->prepare("
                INSERT INTO exam_question_sources (exam_id, subject_id, difficulty, question_limit)
                VALUES (?, ?, ?, ?)
            ");
            return $stmt->execute([$exam_id, $subject_id, $difficulty, $question_limit]);
        } catch (PDOException $e) {
            error_log("Add exam question source failed: " . $e->getMessage());
            return false;
        }
    }

    // GET all sources for exam
    public static function getByExam($pdo, $exam_id) {
        $stmt = $pdo->prepare("SELECT * FROM exam_question_sources WHERE exam_id=?");
        $stmt->execute([$exam_id]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    // DELETE a source
    public static function remove($pdo, $id) {
        try {
            $stmt = $pdo->prepare("DELETE FROM exam_question_sources WHERE id=?");
            return $stmt->execute([$id]);
        } catch (PDOException $e) {
            error_log("Remove exam question source failed: " . $e->getMessage());
            return false;
        }
    }
}
?>

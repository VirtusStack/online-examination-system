<?php
// /classes/ExamQuestion.php
// ---------------------------
// ExamQuestion class for linking questions to exams

class ExamQuestion {

    // ADD question to exam
    public static function add($pdo, $exam_id, $question_id) {
        try {
            $stmt = $pdo->prepare("INSERT INTO exam_questions (exam_id, question_id) VALUES (?, ?)");
            return $stmt->execute([$exam_id, $question_id]);
        } catch (PDOException $e) {
            error_log("Add exam question failed: " . $e->getMessage());
            return false;
        }
    }

    // REMOVE question from exam
    public static function remove($pdo, $exam_id, $question_id) {
        try {
            $stmt = $pdo->prepare("DELETE FROM exam_questions WHERE exam_id=? AND question_id=?");
            return $stmt->execute([$exam_id, $question_id]);
        } catch (PDOException $e) {
            error_log("Remove exam question failed: " . $e->getMessage());
            return false;
        }
    }

    // REMOVE all questions from an exam
    public static function removeAllByExam($pdo, $exam_id) {
        try {
            $stmt = $pdo->prepare("DELETE FROM exam_questions WHERE exam_id=?");
            return $stmt->execute([$exam_id]);
        } catch (PDOException $e) {
            error_log("Remove all exam questions failed: " . $e->getMessage());
            return false;
        }
    }

    // GET all questions for exam
    public static function getByExam($pdo, $exam_id) {
        $stmt = $pdo->prepare("
            SELECT eq.*, q.question_text, q.option_a, q.option_b, q.option_c, q.option_d, 
                   q.correct_option, q.marks_per_question, q.difficulty 
            FROM exam_questions eq
            JOIN questions q ON eq.question_id = q.question_id
            WHERE eq.exam_id=?
        ");
        $stmt->execute([$exam_id]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
}
?>

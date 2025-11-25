<?php
// /classes/ExamQuestionSource.php
// ---------------------------
// Manage question sources for an exam 

class ExamQuestionSource {

    // CREATE a new source row
    public static function create($pdo, $exam_id, $bank_id = null, $subject_id = null, $difficulty = null, $question_limit = null) {
        $stmt = $pdo->prepare("
            INSERT INTO exam_question_sources 
            (exam_id, bank_id, subject_id, difficulty, question_limit)
            VALUES (?, ?, ?, ?, ?)
        ");
        return $stmt->execute([$exam_id, $bank_id, $subject_id, $difficulty, $question_limit]);
    }

    // READ all sources for an exam
    public static function getByExam($pdo, $exam_id) {
        $stmt = $pdo->prepare("SELECT * FROM exam_question_sources WHERE exam_id=?");
        $stmt->execute([$exam_id]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    // UPDATE a source row
    public static function update($pdo, $id, $data) {
        $stmt = $pdo->prepare("
            UPDATE exam_question_sources 
            SET bank_id=?, subject_id=?, difficulty=?, question_limit=?
            WHERE id=?
        ");
        return $stmt->execute([
            $data['bank_id'] ?? null,
            $data['subject_id'] ?? null,
            $data['difficulty'] ?? null,
            $data['question_limit'] ?? null,
            $id
        ]);
    }

    // DELETE a source row
    public static function delete($pdo, $id) {
        $stmt = $pdo->prepare("DELETE FROM exam_question_sources WHERE id=?");
        return $stmt->execute([$id]);
    }

    // DELETE all sources for an exam
    public static function deleteByExam($pdo, $exam_id) {
        $stmt = $pdo->prepare("DELETE FROM exam_question_sources WHERE exam_id=?");
        return $stmt->execute([$exam_id]);
    }
}
?>

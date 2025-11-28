<?php
// /classes/ExamResult.php
// ---------------------------
// Handles exam submissions and results

class ExamResult {

    // Submit exam answers
    public static function submit($pdo, $student_id, $exam_id, $answers) {
        try {
            // Delete previous submission if exists
            $stmtDel = $pdo->prepare("DELETE FROM exam_results WHERE exam_id=? AND student_id=?");
            $stmtDel->execute([$exam_id, $student_id]);

            $score = 0;
            foreach ($answers as $question_id => $answer) {
                $stmtQ = $pdo->prepare("SELECT correct_answer, marks FROM questions WHERE question_id=?");
                $stmtQ->execute([$question_id]);
                $q = $stmtQ->fetch(PDO::FETCH_ASSOC);

                if ($q) {
                    if ($answer == $q['correct_answer']) {
                        $score += $q['marks'];
                    } elseif ($q['negative_marking']) {
                        $score -= $q['negative_marking'];
                    }
                }

                $stmtInsert = $pdo->prepare("
                    INSERT INTO exam_answers (exam_id, student_id, question_id, answer) 
                    VALUES (?, ?, ?, ?)
                ");
                $stmtInsert->execute([$exam_id, $student_id, $question_id, $answer]);
            }

            // Save final score
            $stmtRes = $pdo->prepare("
                INSERT INTO exam_results (exam_id, student_id, score, submitted_at) 
                VALUES (?, ?, ?, NOW())
            ");
            $stmtRes->execute([$exam_id, $student_id, $score]);

            return $score;
        } catch(PDOException $e) {
            error_log("Exam submit failed: " . $e->getMessage());
            return false;
        }
    }

    // Get result by student and exam
    public static function getByStudentExam($pdo, $student_id, $exam_id) {
        $stmt = $pdo->prepare("SELECT * FROM exam_results WHERE exam_id=? AND student_id=?");
        $stmt->execute([$exam_id, $student_id]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }
}
?>

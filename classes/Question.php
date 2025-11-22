<?php
// /classes/Question.php
// ---------------------------------
// Updated Question class matching new DB structure
// Excludes difficulty_percentage and shuffle_options
// ---------------------------------

class Question {

    // CREATE Question
    public static function create(
        $pdo,
        $bank_id,
        $subject_id,
        $question_text,
        $option_a,
        $option_b,
        $option_c,
        $option_d,
        $correct_option,
        $marks_per_question = 1.00,
        $difficulty = 'Easy'
    ) {
        try {
            $stmt = $pdo->prepare("
                INSERT INTO questions 
                (bank_id, subject_id, question_text, option_a, option_b, option_c, option_d, 
                 correct_option, marks_per_question, difficulty)
                VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?)
            ");

            $stmt->execute([
                $bank_id, $subject_id, $question_text,
                $option_a, $option_b, $option_c, $option_d,
                $correct_option, $marks_per_question,
                $difficulty
            ]);

            return $pdo->lastInsertId();

        } catch (PDOException $e) {
            error_log("Create question failed: " . $e->getMessage());
            return false;
        }
    }

    // GET ALL Questions
    public static function getAll($pdo, $bank_id = null) {
        if ($bank_id) {
            $stmt = $pdo->prepare("SELECT * FROM questions WHERE bank_id=? ORDER BY question_id DESC");
            $stmt->execute([$bank_id]);
        } else {
            $stmt = $pdo->query("SELECT * FROM questions ORDER BY question_id DESC");
        }
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    // GET Question By ID
    public static function getById($pdo, $question_id) {
        $stmt = $pdo->prepare("SELECT * FROM questions WHERE question_id=?");
        $stmt->execute([$question_id]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    // UPDATE Question
    public static function update($pdo, $question_id, $data) {
        try {
            $stmt = $pdo->prepare("
                UPDATE questions SET
                    bank_id=?,
                    subject_id=?,
                    question_text=?,
                    option_a=?, 
                    option_b=?, 
                    option_c=?, 
                    option_d=?, 
                    correct_option=?, 
                    marks_per_question=?,
                    difficulty=?
                WHERE question_id=?
            ");

            return $stmt->execute([
                $data['bank_id'],
                $data['subject_id'],
                $data['question_text'],
                $data['option_a'],
                $data['option_b'],
                $data['option_c'],
                $data['option_d'],
                $data['correct_option'],
                $data['marks_per_question'],
                $data['difficulty'],
                $question_id
            ]);

        } catch (PDOException $e) {
            error_log("Update question failed: " . $e->getMessage());
            return false;
        }
    }

    // DELETE Question (CASCADE Safe)
    public static function delete($pdo, $question_id) {
        try {
            $stmt = $pdo->prepare("DELETE FROM questions WHERE question_id=?");
            return $stmt->execute([$question_id]);

        } catch (PDOException $e) {
            error_log("Delete question failed: " . $e->getMessage());
            return false;
        }
    }
}
?>

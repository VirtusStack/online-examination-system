<?php
// /classes/Question.php
// ---------------------------
// Question class for CRUD

class Question {

    // CREATE question
    public static function create($pdo, $bank_id, $question_text, $option_a, $option_b, $option_c, $option_d, $correct_option, $marks = 1.0, $negative_marks = 0.0, $difficulty = 'Easy') {
        try {
            $stmt = $pdo->prepare("
                INSERT INTO questions 
                (bank_id, question_text, option_a, option_b, option_c, option_d, correct_option, marks, negative_marks, difficulty) 
                VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?)
            ");
            $stmt->execute([
                $bank_id, $question_text, $option_a, $option_b, $option_c, $option_d,
                $correct_option, $marks, $negative_marks, $difficulty
            ]);
            return $pdo->lastInsertId(); // return new question ID
        } catch (PDOException $e) {
            error_log("Create question failed: " . $e->getMessage());
            return false;
        }
    }

    // READ ALL questions (optional: by bank)
    public static function getAll($pdo, $bank_id = null) {
        if ($bank_id) {
            $stmt = $pdo->prepare("SELECT * FROM questions WHERE bank_id=? ORDER BY question_id DESC");
            $stmt->execute([$bank_id]);
        } else {
            $stmt = $pdo->query("SELECT * FROM questions ORDER BY question_id DESC");
        }
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    // READ question BY ID
    public static function getById($pdo, $question_id) {
        $stmt = $pdo->prepare("SELECT * FROM questions WHERE question_id=?");
        $stmt->execute([$question_id]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    // UPDATE question safely
    public static function update($pdo, $question_id, $data) {
        try {
            $bank_id        = $data['bank_id'] ?? '';
            $question_text  = $data['question_text'] ?? '';
            $option_a       = $data['option_a'] ?? '';
            $option_b       = $data['option_b'] ?? '';
            $option_c       = $data['option_c'] ?? '';
            $option_d       = $data['option_d'] ?? '';
            $correct_option = $data['correct_option'] ?? '';
            $marks          = $data['marks'] ?? 1.0;
            $negative_marks = $data['negative_marks'] ?? 0.0;
            $difficulty     = $data['difficulty'] ?? 'Easy';

            $stmt = $pdo->prepare("
                UPDATE questions SET 
                    bank_id=?, 
                    question_text=?, 
                    option_a=?, 
                    option_b=?, 
                    option_c=?, 
                    option_d=?, 
                    correct_option=?, 
                    marks=?, 
                    negative_marks=?, 
                    difficulty=?
                WHERE question_id=?
            ");
            return $stmt->execute([
                $bank_id, $question_text, $option_a, $option_b, $option_c, $option_d,
                $correct_option, $marks, $negative_marks, $difficulty, $question_id
            ]);
        } catch (PDOException $e) {
            error_log("Update question failed: " . $e->getMessage());
            return false;
        }
    }

    // DELETE question (hard delete)
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

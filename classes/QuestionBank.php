<?php
// /classes/QuestionBank.php
// ---------------------------
// QuestionBank class for CRUD and fetching related questions
// ---------------------------

class QuestionBank {

    // CREATE bank
    public static function create($pdo, $bank_name, $description = '') {
        try {
            $stmt = $pdo->prepare("
                INSERT INTO question_banks (bank_name, description) 
                VALUES (?, ?)
            ");
            $stmt->execute([$bank_name, $description]);
            return $pdo->lastInsertId(); 
        } catch (PDOException $e) {
            error_log("Create question bank failed: " . $e->getMessage());
            return false;
        }
    }

    // READ ALL banks with total questions per subject
    public static function getAll($pdo) {
        $stmt = $pdo->query("
            SELECT qb.*, 
                   COUNT(q.question_id) AS total_questions
            FROM question_banks qb
            LEFT JOIN questions q ON qb.bank_id = q.bank_id
            GROUP BY qb.bank_id
            ORDER BY qb.bank_id DESC
        ");
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    // GET bank by ID
    public static function getById($pdo, $id) {
        $stmt = $pdo->prepare("
            SELECT qb.*, 
                   COUNT(q.question_id) AS total_questions
            FROM question_banks qb
            LEFT JOIN questions q ON qb.bank_id = q.bank_id
            WHERE qb.bank_id = ?
            GROUP BY qb.bank_id
        ");
        $stmt->execute([$id]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    // GET questions for a bank
    public static function getQuestions($pdo, $bank_id) {
        $stmt = $pdo->prepare("
            SELECT q.*, s.subject_name
            FROM questions q
            LEFT JOIN subjects s ON q.subject_id = s.subject_id
            WHERE q.bank_id = ?
            ORDER BY q.question_id DESC
        ");
        $stmt->execute([$bank_id]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    // UPDATE bank safely
    public static function update($pdo, $id, $data) {
        try {
            $bank_name   = $data['bank_name'] ?? '';
            $description = $data['description'] ?? '';

            $stmt = $pdo->prepare("
                UPDATE question_banks SET bank_name=?, description=? 
                WHERE bank_id=?
            ");
            return $stmt->execute([$bank_name, $description, $id]);
        } catch (PDOException $e) {
            error_log("Update question bank failed: " . $e->getMessage());
            return false;
        }
    }

    // DELETE bank and cascade questions
    public static function delete($pdo, $id) {
        try {
            $stmt = $pdo->prepare("DELETE FROM question_banks WHERE bank_id=?");
            return $stmt->execute([$id]);
        } catch (PDOException $e) {
            error_log("Delete question bank failed: " . $e->getMessage());
            return false;
        }
    }
}
?>

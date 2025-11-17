<?php
// /classes/QuestionBank.php
// ---------------------------
// QuestionBank class for CRUD

class QuestionBank {

    // CREATE bank
    public static function create($pdo, $bank_name, $subject_id, $description = '') {
        try {
            $stmt = $pdo->prepare("
                INSERT INTO question_banks (bank_name, subject_id, description) 
                VALUES (?, ?, ?)
            ");
            $stmt->execute([$bank_name, $subject_id, $description]);
            return $pdo->lastInsertId(); // return new bank ID
        } catch (PDOException $e) {
            error_log("Create question bank failed: " . $e->getMessage());
            return false;
        }
    }

    // READ ALL
    public static function getAll($pdo) {
        $stmt = $pdo->query("
            SELECT qb.*, s.subject_name 
            FROM question_banks qb 
            LEFT JOIN subjects s ON qb.subject_id = s.subject_id
            ORDER BY qb.bank_id DESC
        ");
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    // READ BY ID
    public static function getById($pdo, $id) {
        $stmt = $pdo->prepare("
            SELECT qb.*, s.subject_name 
            FROM question_banks qb 
            LEFT JOIN subjects s ON qb.subject_id = s.subject_id
            WHERE qb.bank_id = ?
        ");
        $stmt->execute([$id]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    // UPDATE bank safely
    public static function update($pdo, $id, $data) {
        try {
            $bank_name  = $data['bank_name'] ?? '';
            $subject_id = $data['subject_id'] ?? null;
            $description = $data['description'] ?? '';

            $stmt = $pdo->prepare("
                UPDATE question_banks SET bank_name=?, subject_id=?, description=? 
                WHERE bank_id=?
            ");
            return $stmt->execute([$bank_name, $subject_id, $description, $id]);
        } catch (PDOException $e) {
            error_log("Update question bank failed: " . $e->getMessage());
            return false;
        }
    }

    // DELETE bank 
    public static function delete($pdo, $id) {
        try {
            // Hard delete; if you want soft delete, add 'is_deleted' column
            $stmt = $pdo->prepare("DELETE FROM question_banks WHERE bank_id=?");
            return $stmt->execute([$id]);
        } catch (PDOException $e) {
            error_log("Delete question bank failed: " . $e->getMessage());
            return false;
        }
    }
}
?>

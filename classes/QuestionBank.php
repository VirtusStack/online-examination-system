<?php 
// /classes/QuestionBank.php
// ---------------------------
// QuestionBank class for CRUD

class QuestionBank {

    // CREATE bank
    public static function create($pdo, $bank_name, $description = '') {
        try {
            $stmt = $pdo->prepare("
                INSERT INTO question_banks (bank_name, description) 
                VALUES (?, ?)
            ");
            $stmt->execute([$bank_name, $description]);
            return $pdo->lastInsertId(); // return new bank ID
        } catch (PDOException $e) {
            error_log("Create question bank failed: " . $e->getMessage());
            return false;
        }
    }

    // READ ALL
    public static function getAll($pdo) {
        $stmt = $pdo->query("
            SELECT * 
            FROM question_banks 
            ORDER BY bank_id DESC
        ");
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    // READ BY ID
    public static function getById($pdo, $id) {
        $stmt = $pdo->prepare("
            SELECT * 
            FROM question_banks 
            WHERE bank_id = ?
        ");
        $stmt->execute([$id]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
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

    // DELETE bank 
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

<?php
// /classes/QuestionBankSubject.php
// ---------------------------
// QuestionBankSubject class for CRUD (link subjects to banks)

class QuestionBankSubject {

    // CREATE a bank-subject link
    public static function create($pdo, $bank_id, $subject_id) {
        try {
            $stmt = $pdo->prepare("
                INSERT INTO question_bank_subjects (bank_id, subject_id) 
                VALUES (?, ?)
            ");
            $stmt->execute([$bank_id, $subject_id]);
            return $pdo->lastInsertId(); // return new record ID
        } catch (PDOException $e) {
            error_log("Create QuestionBankSubject failed: " . $e->getMessage());
            return false;
        }
    }

    // READ ALL links
    public static function getAll($pdo) {
        $stmt = $pdo->query("
            SELECT qbs.*, qb.bank_name, s.subject_name 
            FROM question_bank_subjects qbs
            JOIN question_banks qb ON qbs.bank_id = qb.bank_id
            JOIN subjects s ON qbs.subject_id = s.subject_id
            ORDER BY qb.bank_name, s.subject_name
        ");
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    // READ BY ID
    public static function getById($pdo, $id) {
        $stmt = $pdo->prepare("SELECT * FROM question_bank_subjects WHERE id = ?");
        $stmt->execute([$id]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    // GET subjects by bank ID
    public static function getSubjectsByBank($pdo, $bank_id) {
        $stmt = $pdo->prepare("
            SELECT s.subject_id, s.subject_name 
            FROM question_bank_subjects qbs
            JOIN subjects s ON qbs.subject_id = s.subject_id
            WHERE qbs.bank_id = ?
            ORDER BY s.subject_name
        ");
        $stmt->execute([$bank_id]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    // UPDATE a bank-subject link
    public static function update($pdo, $id, $bank_id, $subject_id) {
        try {
            $stmt = $pdo->prepare("
                UPDATE question_bank_subjects SET bank_id=?, subject_id=? 
                WHERE id=?
            ");
            return $stmt->execute([$bank_id, $subject_id, $id]);
        } catch (PDOException $e) {
            error_log("Update QuestionBankSubject failed: " . $e->getMessage());
            return false;
        }
    }

    // DELETE a link
    public static function delete($pdo, $id) {
        try {
            $stmt = $pdo->prepare("DELETE FROM question_bank_subjects WHERE id=?");
            return $stmt->execute([$id]);
        } catch (PDOException $e) {
            error_log("Delete QuestionBankSubject failed: " . $e->getMessage());
            return false;
        }
    }
}
?>

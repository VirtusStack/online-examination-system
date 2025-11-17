<?php
// /classes/Subject.php
// ---------------------------
// Subject class for CRUD


class Subject {

    // CREATE subject
    public static function create($pdo, $subject_name, $description = '') {
        try {
            $stmt = $pdo->prepare("
                INSERT INTO subjects (subject_name, description) 
                VALUES (?, ?)
            ");
            $stmt->execute([$subject_name, $description]);
            return $pdo->lastInsertId(); // return new subject ID
        } catch (PDOException $e) {
            error_log("Create subject failed: " . $e->getMessage());
            return false;
        }
    }

    // READ ALL
    public static function getAll($pdo) {
        $stmt = $pdo->query("SELECT * FROM subjects ORDER BY subject_id DESC");
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    // READ BY ID
    public static function getById($pdo, $id) {
        $stmt = $pdo->prepare("SELECT * FROM subjects WHERE subject_id = ?");
        $stmt->execute([$id]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    // UPDATE subject safely
    public static function update($pdo, $id, $data) {
        try {
            $subject_name = $data['subject_name'] ?? '';
            $description  = $data['description'] ?? '';

            $stmt = $pdo->prepare("
                UPDATE subjects SET subject_name=?, description=? 
                WHERE subject_id=?
            ");
            return $stmt->execute([$subject_name, $description, $id]);
        } catch (PDOException $e) {
            error_log("Update subject failed: " . $e->getMessage());
            return false;
        }
    }

    // DELETE subject (soft delete)
    public static function delete($pdo, $id) {
        try {
            // If you want hard delete, change this to DELETE FROM
            $stmt = $pdo->prepare("DELETE FROM subjects WHERE subject_id=?");
            return $stmt->execute([$id]);
        } catch (PDOException $e) {
            error_log("Delete subject failed: " . $e->getMessage());
            return false;
        }
    }
}
?>

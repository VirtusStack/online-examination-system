<?php
// /classes/Student.php
// ---------------------------
// Student class for CRUD and authentication

class Student {

    // CREATE student
    public static function create($pdo, $data) {
        try {
            $stmt = $pdo->prepare("
                INSERT INTO students (name, email, password, class_id, created_at) 
                VALUES (?, ?, ?, ?, NOW())
            ");
            $stmt->execute([
                $data['name'] ?? '',
                $data['email'] ?? '',
                password_hash($data['password'], PASSWORD_DEFAULT),
                $data['class_id'] ?? null
            ]);
            return $pdo->lastInsertId();
        } catch(PDOException $e) {
            error_log("Create student failed: " . $e->getMessage());
            return false;
        }
    }

    // READ ALL students
    public static function getAll($pdo) {
        $stmt = $pdo->query("SELECT * FROM students ORDER BY created_at DESC");
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    // READ student by ID
    public static function getById($pdo, $id) {
        $stmt = $pdo->prepare("SELECT * FROM students WHERE student_id=?");
        $stmt->execute([$id]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    // UPDATE student
    public static function update($pdo, $id, $data) {
        try {
            $stmt = $pdo->prepare("
                UPDATE students SET name=?, email=?, class_id=? 
                WHERE student_id=?
            ");
            return $stmt->execute([
                $data['name'] ?? '',
                $data['email'] ?? '',
                $data['class_id'] ?? null,
                $id
            ]);
        } catch(PDOException $e) {
            error_log("Update student failed: " . $e->getMessage());
            return false;
        }
    }

    // DELETE student
    public static function delete($pdo, $id) {
        try {
            $stmt = $pdo->prepare("DELETE FROM students WHERE student_id=?");
            return $stmt->execute([$id]);
        } catch(PDOException $e) {
            error_log("Delete student failed: " . $e->getMessage());
            return false;
        }
    }

    // AUTHENTICATE
    public static function authenticate($pdo, $email, $password) {
        $stmt = $pdo->prepare("SELECT * FROM students WHERE email=?");
        $stmt->execute([$email]);
        $student = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($student && password_verify($password, $student['password'])) {
            return $student;
        }
        return false;
    }
}
?>

<?php
// classes/Student.php
// ----------------------------------------
// Student class for both student panel login and admin management

class Student {

    // STUDENT PANEL FUNCTION

    // Authenticate student for login
    public static function authenticate($pdo, $email, $password) {
        $stmt = $pdo->prepare("SELECT * FROM students WHERE email = :email AND status='Active'");
        $stmt->execute([':email' => $email]);
        $student = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($student && password_verify($password, $student['password_hash'])) {
            return $student;
        }
        return false;
    }

    // Get student by ID
    public static function getById($pdo, $student_id) {
        $stmt = $pdo->prepare("SELECT * FROM students WHERE student_id = :student_id");
        $stmt->execute([':student_id' => $student_id]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    // ADMIN CRUD FUNCTIONS

    // Create new student
    public static function create($pdo, $name, $email, $password, $roll_no, $class_id, $section, $phone, $status='Active') {
        $password_hash = password_hash($password, PASSWORD_BCRYPT);
        $stmt = $pdo->prepare("INSERT INTO students 
            (name, email, password_hash, roll_no, class_id, section, phone, status) 
            VALUES 
            (:name, :email, :password_hash, :roll_no, :class_id, :section, :phone, :status)
        ");
        return $stmt->execute([
            ':name' => $name,
            ':email' => $email,
            ':password_hash' => $password_hash,
            ':roll_no' => $roll_no,
            ':class_id' => $class_id,
            ':section' => $section,
            ':phone' => $phone,
            ':status' => $status
        ]);
    }

    // Get all students
    public static function getAll($pdo) {
        $stmt = $pdo->query("SELECT s.*, c.class_name 
                             FROM students s 
                             LEFT JOIN classrooms c ON s.class_id = c.class_id 
                             ORDER BY student_id DESC");
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    // Update student
    public static function update($pdo, $student_id, $name, $email, $password, $roll_no, $class_id, $section, $phone, $status) {
        if (!empty($password)) {
            $password_hash = password_hash($password, PASSWORD_BCRYPT);
            $stmt = $pdo->prepare("UPDATE students SET 
                name=:name, email=:email, password_hash=:password_hash, roll_no=:roll_no, class_id=:class_id, 
                section=:section, phone=:phone, status=:status
                WHERE student_id=:student_id");
            return $stmt->execute([
                ':name'=>$name, ':email'=>$email, ':password_hash'=>$password_hash, ':roll_no'=>$roll_no,
                ':class_id'=>$class_id, ':section'=>$section, ':phone'=>$phone, ':status'=>$status, ':student_id'=>$student_id
            ]);
        } else {
            $stmt = $pdo->prepare("UPDATE students SET 
                name=:name, email=:email, roll_no=:roll_no, class_id=:class_id, 
                section=:section, phone=:phone, status=:status
                WHERE student_id=:student_id");
            return $stmt->execute([
                ':name'=>$name, ':email'=>$email, ':roll_no'=>$roll_no,
                ':class_id'=>$class_id, ':section'=>$section, ':phone'=>$phone, ':status'=>$status, ':student_id'=>$student_id
            ]);
        }
    }

    // Delete student
    public static function delete($pdo, $student_id) {
        $stmt = $pdo->prepare("DELETE FROM students WHERE student_id=:student_id");
        return $stmt->execute([':student_id'=>$student_id]);
    }
}

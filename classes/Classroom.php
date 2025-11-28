<?php
// classes/Classroom.php
// ----------------------------------------
// Classroom class for managing college classes (admin module)

class Classroom {
    // Create new class
    public static function create($pdo, $class_name) {
        $stmt = $pdo->prepare("INSERT INTO classrooms (class_name) VALUES (:class_name)");
        return $stmt->execute([':class_name' => $class_name]);
    }

    // Get all classes
    public static function getAll($pdo) {
        $stmt = $pdo->query("SELECT * FROM classrooms ORDER BY class_id DESC");
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    // Get class by ID
    public static function getById($pdo, $class_id) {
        $stmt = $pdo->prepare("SELECT * FROM classrooms WHERE class_id = :class_id");
        $stmt->execute([':class_id' => $class_id]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    // Update class
    public static function update($pdo, $class_id, $class_name) {
        $stmt = $pdo->prepare("UPDATE classrooms SET class_name = :class_name WHERE class_id = :class_id");
        return $stmt->execute([':class_name' => $class_name, ':class_id' => $class_id]);
    }

    // Delete class
    public static function delete($pdo, $class_id) {
        $stmt = $pdo->prepare("DELETE FROM classrooms WHERE class_id = :class_id");
        return $stmt->execute([':class_id' => $class_id]);
    }
}

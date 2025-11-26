<?php
// /classes/Exam.php
// ---------------------------
// Exam class for CRUD and management

class Exam {

    // CREATE new exam
    public static function create($pdo, $data) {
        try {
            $stmt = $pdo->prepare("
                INSERT INTO exams 
                ( exam_title, exam_description, total_questions, duration_minutes, 
                  shuffle_questions, shuffle_options, start_time, end_time, passing_marks, negative_marking, status) 
                VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)
            ");
            $stmt->execute([
                $data['exam_title'] ?? '',
                $data['exam_description'] ?? '',
                $data['total_questions'] ?? 0,
                $data['duration_minutes'] ?? 30,
                $data['shuffle_questions'] ?? 1,
                $data['shuffle_options'] ?? 1,
                $data['start_time'] ?? null,
                $data['end_time'] ?? null,
                $data['passing_marks'] ?? 0,
                $data['negative_marking'] ?? 0,
                $data['status'] ?? 'Inactive'
            ]);
            return $pdo->lastInsertId();
        } catch (PDOException $e) {
            error_log("Create exam failed: " . $e->getMessage());
            return false;
        }
    }

    // READ all exams
    public static function getAll($pdo) {
        $stmt = $pdo->query("SELECT * FROM exams ORDER BY exam_id DESC");
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    // READ exam by ID
    public static function getById($pdo, $id) {
        $stmt = $pdo->prepare("SELECT * FROM exams WHERE exam_id=?");
        $stmt->execute([$id]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    // UPDATE exam
    public static function update($pdo, $id, $data) {
        try {
            $stmt = $pdo->prepare("
                UPDATE exams SET 
                     exam_title=?, exam_description=?, total_questions=?, duration_minutes=?,
                    shuffle_questions=?, shuffle_options=?, start_time=?, end_time=?, passing_marks=?, negative_marking=?, status=?
                WHERE exam_id=?
            ");
            return $stmt->execute([
                $data['exam_title'] ?? '',
                $data['exam_description'] ?? '',
                $data['total_questions'] ?? 0,
                $data['duration_minutes'] ?? 30,
                $data['shuffle_questions'] ?? 1,
                $data['shuffle_options'] ?? 1,
                $data['start_time'] ?? null,
                $data['end_time'] ?? null,
                $data['passing_marks'] ?? 0,
                $data['negative_marking'] ?? 0,
                $data['status'] ?? 'Inactive',
                $id
            ]);
        } catch (PDOException $e) {
            error_log("Update exam failed: " . $e->getMessage());
            return false;
        }
    }

    // DELETE exam
    public static function delete($pdo, $id) {
        try {
            $stmt = $pdo->prepare("DELETE FROM exams WHERE exam_id=?");
            return $stmt->execute([$id]);
        } catch (PDOException $e) {
            error_log("Delete exam failed: " . $e->getMessage());
            return false;
        }
    }
}
?>

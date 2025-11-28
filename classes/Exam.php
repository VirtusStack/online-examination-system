<?php
// /classes/Exam.php
// ---------------------------
// Exam class handles all exam CRUD and management

class Exam {

    // CREATE exam
    public static function create($pdo, $data) {
        try {
            $stmt = $pdo->prepare("
                INSERT INTO exams 
                (exam_title, exam_description, duration_minutes, total_questions, shuffle_questions, shuffle_options, negative_marking, start_time, end_time, assign_type, created_at) 
                VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, NOW())
            ");
            $stmt->execute([
                $data['exam_title'] ?? '',
                $data['exam_description'] ?? '',
                $data['duration_minutes'] ?? 30,
                $data['total_questions'] ?? 0,
                $data['shuffle_questions'] ?? 0,
                $data['shuffle_options'] ?? 0,
                $data['negative_marking'] ?? 0,
                $data['start_time'] ?? null,
                $data['end_time'] ?? null,
                $data['assign_type'] ?? 'class'
            ]);
            $exam_id = $pdo->lastInsertId();

            // Assign students if data provided
            if (!empty($data['assign_data'])) {
                self::assignStudents($pdo, $exam_id, $data['assign_type'], $data['assign_data']);
            }

            return $exam_id;
        } catch (PDOException $e) {
            error_log("Create exam failed: " . $e->getMessage());
            return false;
        }
    }

    // READ ALL exams
    public static function getAllExams($pdo) {
        $stmt = $pdo->query("SELECT * FROM exams ORDER BY created_at DESC");
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    // READ exam by ID
    public static function getById($pdo, $exam_id) {
        $stmt = $pdo->prepare("SELECT * FROM exams WHERE exam_id = ?");
        $stmt->execute([$exam_id]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    // UPDATE exam
    public static function update($pdo, $exam_id, $data) {
        try {
            $stmt = $pdo->prepare("
                UPDATE exams SET 
                    exam_title=?, 
                    exam_description=?, 
                    duration_minutes=?, 
                    total_questions=?, 
                    shuffle_questions=?, 
                    shuffle_options=?, 
                    negative_marking=?, 
                    start_time=?, 
                    end_time=?, 
                    assign_type=?
                WHERE exam_id=?
            ");
            $updated = $stmt->execute([
                $data['exam_title'] ?? '',
                $data['exam_description'] ?? '',
                $data['duration_minutes'] ?? 30,
                $data['total_questions'] ?? 0,
                $data['shuffle_questions'] ?? 0,
                $data['shuffle_options'] ?? 0,
                $data['negative_marking'] ?? 0,
                $data['start_time'] ?? null,
                $data['end_time'] ?? null,
                $data['assign_type'] ?? 'class',
                $exam_id
            ]);

            // Re-assign students if provided
            if (!empty($data['assign_data'])) {
                self::assignStudents($pdo, $exam_id, $data['assign_type'], $data['assign_data']);
            }

            return $updated;
        } catch (PDOException $e) {
            error_log("Update exam failed: " . $e->getMessage());
            return false;
        }
    }

    // DELETE exam
    public static function delete($pdo, $exam_id) {
        try {
            $stmt = $pdo->prepare("DELETE FROM exams WHERE exam_id=?");
            return $stmt->execute([$exam_id]);
        } catch (PDOException $e) {
            error_log("Delete exam failed: " . $e->getMessage());
            return false;
        }
    }

    // Fetch all subjects
    public static function getAllSubjects($pdo) {
        $stmt = $pdo->query("SELECT * FROM subjects ORDER BY subject_name ASC");
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    // Fetch all question banks
    public static function getAllQuestionBanks($pdo) {
        $stmt = $pdo->query("SELECT * FROM question_banks ORDER BY bank_name ASC");
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    // Get question sources for an exam
    public static function getQuestionSources($pdo, $exam_id) {
        $stmt = $pdo->prepare("SELECT * FROM exam_question_sources WHERE exam_id = ?");
        $stmt->execute([$exam_id]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    // Assign students to exam
    public static function assignStudents($pdo, $exam_id, $type, $data) {
        $exam_id = (int)$exam_id;

        // Delete old assignments
        $stmtDel = $pdo->prepare("DELETE FROM exam_assigned_students WHERE exam_id = ?");
        $stmtDel->execute([$exam_id]);

        $students = [];

        if ($type === 'class' && !empty($data['class_id'])) {
            $class_id = (int)$data['class_id'];
            $stmt = $pdo->prepare("SELECT student_id FROM students WHERE class_id = ?");
            $stmt->execute([$class_id]);
            $students = $stmt->fetchAll(PDO::FETCH_COLUMN);
        } elseif ($type === 'individual' && !empty($data['student_ids'])) {
            $students = is_array($data['student_ids']) 
                        ? array_map('intval', $data['student_ids']) 
                        : array_map('intval', explode(',', $data['student_ids']));
        } elseif ($type === 'group' && !empty($data['group_id'])) {
            $group_id = (int)$data['group_id'];
            $stmt = $pdo->prepare("SELECT student_id FROM students WHERE group_id = ?");
            $stmt->execute([$group_id]);
            $students = $stmt->fetchAll(PDO::FETCH_COLUMN);
        }

        // Insert assigned students
        if (!empty($students)) {
            $stmtInsert = $pdo->prepare("INSERT INTO exam_assigned_students (exam_id, student_id) VALUES (?, ?)");
            foreach ($students as $student_id) {
                $stmtInsert->execute([$exam_id, (int)$student_id]);
            }
        }
    }

    // Generate questions for an exam
    public static function generateQuestions($pdo, $exam_id) {
        // Delete old questions
        $stmt = $pdo->prepare("DELETE FROM exam_questions WHERE exam_id = ?");
        $stmt->execute([$exam_id]);

        $sources = self::getQuestionSources($pdo, $exam_id);
        foreach ($sources as $source) {
            $sql = "SELECT question_id FROM questions WHERE bank_id=? AND subject_id=?";
            $params = [$source['bank_id'], $source['subject_id']];

            if (!empty($source['difficulty'])) {
                $sql .= " AND difficulty=?";
                $params[] = $source['difficulty'];
            }

            // FIX LIMIT SQL issue
            $limit = (int)($source['question_limit'] ?? 10);
            $sql .= " ORDER BY RAND() LIMIT $limit";

            $stmtQ = $pdo->prepare($sql);
            $stmtQ->execute($params);
            $questions = $stmtQ->fetchAll(PDO::FETCH_COLUMN);

            $stmtInsert = $pdo->prepare("INSERT INTO exam_questions (exam_id, question_id) VALUES (?, ?)");
            foreach ($questions as $question_id) {
                $stmtInsert->execute([$exam_id, $question_id]);
            }
        }
    }

    // Get assigned students
    public static function getAssignedStudents($pdo, $exam_id) {
        $stmt = $pdo->prepare("
            SELECT s.* 
            FROM exam_assigned_students eas 
            JOIN students s ON eas.student_id = s.student_id 
            WHERE eas.exam_id = ?
        ");
        $stmt->execute([$exam_id]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    // Create exam link
    public static function createExamLink($pdo, $exam_id, $link, $password, $expires_at = null) {
        $stmt = $pdo->prepare("
            INSERT INTO exam_links (exam_id, unique_link, password, expires_at, created_at) 
            VALUES (?, ?, ?, ?, NOW())
        ");
        $stmt->execute([
            $exam_id, 
            $link, 
            password_hash($password, PASSWORD_DEFAULT), 
            $expires_at
        ]);
        return $pdo->lastInsertId();
    }
}
?>

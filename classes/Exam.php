<?php
// /classes/Exam.php
// ---------------------------
// Exam class for CRUD operations and managing questions

class Exam {

    // CREATE new exam
    public static function create($pdo, $subject_id, $exam_title, $duration_minutes = 30, $total_marks = null, $start_date = null, $end_date = null, $status = 'Active') {
        try {
            $stmt = $pdo->prepare("
                INSERT INTO exams (subject_id, exam_title, duration_minutes, total_marks, start_date, end_date, status)
                VALUES (?, ?, ?, ?, ?, ?, ?)
            ");
            $stmt->execute([$subject_id, $exam_title, $duration_minutes, $total_marks, $start_date, $end_date, $status]);
            return $pdo->lastInsertId(); // return new exam ID
        } catch (PDOException $e) {
            error_log("Create exam failed: " . $e->getMessage());
            return false;
        }
    }

    // READ all exams (optionally by subject)
    public static function getAll($pdo, $subject_id = null) {
        if ($subject_id) {
            $stmt = $pdo->prepare("SELECT * FROM exams WHERE subject_id=? ORDER BY exam_id DESC");
            $stmt->execute([$subject_id]);
        } else {
            $stmt = $pdo->query("SELECT * FROM exams ORDER BY exam_id DESC");
        }
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    // READ single exam by ID
    public static function getById($pdo, $exam_id) {
        $stmt = $pdo->prepare("SELECT * FROM exams WHERE exam_id=?");
        $stmt->execute([$exam_id]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

   public static function countAll($pdo) {
       $stmt = $pdo->query("SELECT COUNT(*) FROM exams");
       return $stmt->fetchColumn();
     }

    // UPDATE exam
    public static function update($pdo, $exam_id, $data) {
        try {
            $stmt = $pdo->prepare("
                UPDATE exams SET subject_id=?, exam_title=?, duration_minutes=?, total_marks=?, start_date=?, end_date=?, status=? 
                WHERE exam_id=?
            ");
            return $stmt->execute([
                $data['subject_id'] ?? 1,
                $data['exam_title'] ?? '',
                $data['duration_minutes'] ?? 30,
                $data['total_marks'] ?? null,
                $data['start_date'] ?? null,
                $data['end_date'] ?? null,
                $data['status'] ?? 'Active',
                $exam_id
            ]);
        } catch (PDOException $e) {
            error_log("Update exam failed: " . $e->getMessage());
            return false;
        }
    }

    // DELETE exam (soft or hard delete)
    public static function delete($pdo, $exam_id) {
        try {
            // Currently hard delete
            $stmt = $pdo->prepare("DELETE FROM exams WHERE exam_id=?");
            return $stmt->execute([$exam_id]);
        } catch (PDOException $e) {
            error_log("Delete exam failed: " . $e->getMessage());
            return false;
        }
    }

    // Get questions assigned to an exam
    public static function getQuestions($pdo, $exam_id) {
        $stmt = $pdo->prepare("
            SELECT q.* 
            FROM exam_questions eq
            JOIN questions q ON eq.question_id = q.question_id
            WHERE eq.exam_id=?
        ");
        $stmt->execute([$exam_id]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    // Assign multiple questions to an exam
    public static function setQuestions($pdo, $exam_id, $question_ids = []) {
        try {
            // Clear existing questions
            $stmtDelete = $pdo->prepare("DELETE FROM exam_questions WHERE exam_id=?");
            $stmtDelete->execute([$exam_id]);

            // Insert new questions
            $stmtInsert = $pdo->prepare("INSERT INTO exam_questions (exam_id, question_id) VALUES (?, ?)");
            foreach ($question_ids as $qid) {
                $stmtInsert->execute([$exam_id, $qid]);
            }
            return true;
        } catch (PDOException $e) {
            error_log("Set exam questions failed: " . $e->getMessage());
            return false;
        }
    }
}
?>

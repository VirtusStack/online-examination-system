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

// Fetch all classes
public static function getAllClasses($pdo) {
    $stmt = $pdo->query("SELECT class_id, class_name FROM classrooms ORDER BY class_name ASC");
    return $stmt->fetchAll(PDO::FETCH_ASSOC);
}

// Fetch all students
public static function getAllStudents($pdo) {
    $stmt = $pdo->query("SELECT student_id, name, email FROM students ORDER BY name ASC");
    return $stmt->fetchAll(PDO::FETCH_ASSOC);
}
    
// Assign students to exam AND create unique exam links
public static function assignStudents($pdo, $exam_id, $type, $data) {
    $exam_id = (int)$exam_id;

    // Delete old assignments
    $stmtDel = $pdo->prepare("DELETE FROM exam_assigned_students WHERE exam_id = ?");
    $stmtDel->execute([$exam_id]);

    $students = [];

    // Get students to assign
    if ($type === 'class' && !empty($data['class_id'])) {
        $class_id = (int)$data['class_id'];
        $stmt = $pdo->prepare("SELECT student_id, name, email FROM students WHERE class_id = ?");
        $stmt->execute([$class_id]);
        $students = $stmt->fetchAll(PDO::FETCH_ASSOC);
    } elseif ($type === 'individual' && !empty($data['student_ids'])) {
        $ids = is_array($data['student_ids']) 
               ? $data['student_ids'] 
               : explode(',', $data['student_ids']);
        $ids = array_map('intval', $ids);

        $stmt = $pdo->prepare("SELECT student_id, name, email FROM students WHERE student_id IN (" . implode(',', $ids) . ")");
        $stmt->execute();
        $students = $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    // Insert assigned students AND create exam links
    if (!empty($students)) {
        $stmtInsert = $pdo->prepare("INSERT INTO exam_assigned_students (exam_id, student_id) VALUES (?, ?)");
        $stmtLink   = $pdo->prepare("
            INSERT INTO exam_links (exam_id, unique_link, student_email, student_name, created_at)
            VALUES (?, ?, ?, ?, NOW())
        ");

        foreach ($students as $student) {
            // Assign student
            $stmtInsert->execute([$exam_id, $student['student_id']]);

            // Check if link already exists
            $stmtCheck = $pdo->prepare("SELECT link_id FROM exam_links WHERE exam_id=? AND student_email=?");
            $stmtCheck->execute([$exam_id, $student['email']]);
            if (!$stmtCheck->fetch()) {
                // Create unique link
                $unique_link = uniqid('exam_', true);
                $stmtLink->execute([$exam_id, $unique_link, $student['email'], $student['name']]);
            }
        }
    }
}

// Generate questions for an exam using difficulty percentage logic
public static function generateQuestions($pdo, $exam_id)
{
    // Delete old questions
    $stmt = $pdo->prepare("DELETE FROM exam_questions WHERE exam_id = ?");
    $stmt->execute([$exam_id]);

    $sources = self::getQuestionSources($pdo, $exam_id);

    foreach ($sources as $source) {

        $bank_id    = (int)$source['bank_id'];
        $subject_id = (int)$source['subject_id'];
        $total      = (int)$source['question_limit'];   // total questions needed

        if ($total <= 0) continue;

        // Difficulty distribution
        $easyCount   = round($total * 0.20);
        $mediumCount = round($total * 0.30);
        $hardCount   = $total - ($easyCount + $mediumCount);

        $selected = [];

        // Helper function to fetch N random questions
        $fetchQ = function($difficulty, $limit) use ($pdo, $bank_id, $subject_id) {

            if ($limit <= 0) return [];

            $sql = "SELECT question_id 
                    FROM questions 
                    WHERE bank_id=? AND subject_id=? AND difficulty=? 
                    ORDER BY RAND() LIMIT $limit";

            $stmt = $pdo->prepare($sql);
            $stmt->execute([$bank_id, $subject_id, $difficulty]);

            return $stmt->fetchAll(PDO::FETCH_COLUMN);
        };

        // Fetch difficulty-based questions
        $easyQs   = $fetchQ("Easy", $easyCount);
        $mediumQs = $fetchQ("Medium", $mediumCount);
        $hardQs   = $fetchQ("Hard", $hardCount);

        // Merge all selected questions
        $selected = array_merge($easyQs, $mediumQs, $hardQs);

        // If shortages → fill remaining from ANY difficulty
        $remaining = $total - count($selected);

        if ($remaining > 0) {

            $sql = "SELECT question_id 
                    FROM questions 
                    WHERE bank_id=? AND subject_id=? 
                    AND question_id NOT IN (" . (count($selected) ? implode(",", $selected) : "0") . ")
                    ORDER BY RAND() LIMIT $remaining";

            $stmt = $pdo->prepare($sql);
            $stmt->execute([$bank_id, $subject_id]);
            $fallbackQs = $stmt->fetchAll(PDO::FETCH_COLUMN);

            $selected = array_merge($selected, $fallbackQs);
        }

        // Insert questions into exam
        $insert = $pdo->prepare("INSERT INTO exam_questions (exam_id, question_id) VALUES (?, ?)");

        foreach ($selected as $qid) {
            $insert->execute([$exam_id, $qid]);
        }
    }
}


     // Fetch exam details for a specific student 
     public static function getExamForStudent($pdo, $exam_id, $student_id = 0) {
    try {
        $student_id = $student_id ?: ($_SESSION['student_id'] ?? 0);
        if (!$student_id) return false;

        $stmt = $pdo->prepare("
            SELECT 
                e.*, 
                e.duration_minutes AS duration,
                e.start_time AS exam_date,
                (
                    SELECT GROUP_CONCAT(DISTINCT COALESCE(s.subject_name, 'Unknown') SEPARATOR ', ')
                    FROM exam_question_sources eqs
                    LEFT JOIN subjects s ON s.subject_id = eqs.subject_id
                    WHERE eqs.exam_id = e.exam_id
                ) AS subjects
            FROM exams e
            JOIN exam_assigned_students eas 
                ON e.exam_id = eas.exam_id
            WHERE e.exam_id = ? AND eas.student_id = ?
            LIMIT 1
        ");
        $stmt->execute([$exam_id, $student_id]);
        $exam = $stmt->fetch(PDO::FETCH_ASSOC);

        $exam['subjects'] = $exam['subjects'] ?: 'N/A';
        $exam['duration'] = $exam['duration'] ?? 0;
        $exam['exam_date'] = $exam['exam_date'] ?? date('Y-m-d H:i:s');

        return $exam;

    } catch (PDOException $e) {
        error_log("getExamForStudent failed: " . $e->getMessage());
        return false;
    }
}


   // Get exam questions WITH options
   public static function getExamQuestions($examId)
{
    global $pdo;

    $sql = "SELECT q.question_id, q.question_text, 
                q.option_a, q.option_b, q.option_c, q.option_d,
                q.correct_option, q.marks_per_question
            FROM exam_questions eq
            INNER JOIN questions q ON eq.question_id = q.question_id
            WHERE eq.exam_id = ?
            ORDER BY eq.id ASC";

    $stmt = $pdo->prepare($sql);
    $stmt->execute([$examId]);

    $questions = $stmt->fetchAll(PDO::FETCH_ASSOC);

    // Convert options into an array
    foreach ($questions as &$q) {
        $q['options'] = [
            'A' => $q['option_a'],
            'B' => $q['option_b'],
            'C' => $q['option_c'],
            'D' => $q['option_d'],
        ];
    }

    return $questions;
}


   public static function getAssignedExams($pdo, $student_id) {
    try {
        $stmt = $pdo->prepare("
            SELECT 
                e.exam_id,
                e.exam_title,
                e.duration_minutes,
                e.total_questions,
                e.start_time,
                e.end_time,
                (
                    SELECT GROUP_CONCAT(DISTINCT s.subject_name SEPARATOR ', ')
                    FROM exam_question_sources eqs
                    JOIN subjects s ON s.subject_id = eqs.subject_id
                    WHERE eqs.exam_id = e.exam_id
                ) AS subjects,
                el.link_id,
                el.unique_link
            FROM exam_assigned_students eas
            JOIN exams e ON e.exam_id = eas.exam_id
            JOIN students st ON st.student_id = eas.student_id
            JOIN exam_links el 
                ON el.exam_id = e.exam_id
                AND el.student_email = st.email
            WHERE eas.student_id = ?
            ORDER BY e.start_time ASC
        ");
        $stmt->execute([$student_id]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    } catch (PDOException $e) {
        error_log("Get assigned exams failed: " . $e->getMessage());
        return [];
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

  // Fetch exam by unique link for a specific student
public static function getExamByLink($pdo, $link, $student_id = 0) {
    $student_id = $student_id ?: ($_SESSION['student_id'] ?? 0);
    if (!$student_id) return false;

    $stmt = $pdo->prepare("
        SELECT e.* 
        FROM exams e
        JOIN exam_links el ON e.exam_id = el.exam_id
        LEFT JOIN exam_assigned_students eas ON e.exam_id = eas.exam_id
        WHERE el.unique_link = ? 
          AND (eas.student_id = ? OR e.assign_type = 'all')
        LIMIT 1
    ");
    $stmt->execute([$link, $student_id]);
    $exam = $stmt->fetch(PDO::FETCH_ASSOC);

    // Fallbacks to avoid undefined array keys
    if ($exam) {
        $exam['subject_name'] = $exam['subject_name'] ?? 'N/A';
        $exam['duration'] = $exam['duration_minutes'] ?? 0;
        $exam['exam_date'] = $exam['start_time'] ?? date('Y-m-d H:i:s');
    }

    return $exam;
}

   // get student answer
    public static function getStudentAnswers($pdo, $student_id, $exam_id) {
    $stmt = $pdo->prepare("
        SELECT 
            eq.question_id,
            qb.question_text,
            qb.option_a,
            qb.option_b,
            qb.option_c,
            qb.option_d,
            qb.correct_answer,
            sa.answer AS student_answer,
            sa.is_correct
        FROM student_answers sa
        JOIN exam_questions eq ON sa.exam_question_id = eq.id
        JOIN question_bank qb ON eq.question_id = qb.id
        WHERE sa.student_id = ? AND sa.exam_id = ?
        ORDER BY eq.id ASC
    ");

    $stmt->execute([$student_id, $exam_id]);
    return $stmt->fetchAll(PDO::FETCH_ASSOC);
}

public static function getSubjectsByBank($pdo, $bank_id)
{
    try {
        $stmt = $pdo->prepare("
            SELECT s.subject_id, s.subject_name
            FROM question_bank_subjects qbs
            JOIN subjects s ON s.subject_id = qbs.subject_id
            WHERE qbs.bank_id = ?
            ORDER BY s.subject_name
        ");
        $stmt->execute([$bank_id]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);

    } catch (PDOException $e) {
        error_log("Error fetching subjects by bank: " . $e->getMessage());
        return [];
    }
}

public static function getSubmittedExams($pdo, $studentId) {
    if (!$studentId) return [];

    try {
        $stmt = $pdo->prepare("
            SELECT DISTINCT exam_id
            FROM exam_answers
            WHERE student_id = ?
        ");
        $stmt->execute([$studentId]);
        $rows = $stmt->fetchAll(PDO::FETCH_ASSOC);

        // Return array of exam IDs
        return array_column($rows, 'exam_id');

    } catch (PDOException $e) {
        error_log("Error fetching submitted exams: " . $e->getMessage());
        return [];
    }
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

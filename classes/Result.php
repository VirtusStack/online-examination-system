<?php
// /classes/Result.php
// ---------------------------
// Result class for CRUD + exam result updates

class Result {

    // CREATE result (normally auto-created during exam assign)
    public static function create($pdo, $data) {
        try {
            $stmt = $pdo->prepare("
                INSERT INTO exam_results (exam_id, link_id, student_name, student_email, total_marks, obtained_marks, started_at, submitted_at)
                VALUES (?, ?, ?, ?, ?, ?, ?, ?)
            ");

            $stmt->execute([
                $data['exam_id'] ?? null,
                $data['link_id'] ?? null,
                $data['student_name'] ?? null,
                $data['student_email'] ?? null,
                $data['total_marks'] ?? 0,
                $data['obtained_marks'] ?? 0,
                $data['started_at'] ?? null,
                $data['submitted_at'] ?? null
            ]);

            return $pdo->lastInsertId();
        } catch (PDOException $e) {
            error_log("Create result failed: " . $e->getMessage());
            return false;
        }
    }

    // READ ALL results
    public static function getAll($pdo) {
        $stmt = $pdo->query("
            SELECT r.*, e.exam_title 
            FROM exam_results r 
            LEFT JOIN exams e ON r.exam_id = e.exam_id
            ORDER BY r.result_id DESC
        ");
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    // READ result by ID
    public static function getById($pdo, $id) {
        $stmt = $pdo->prepare("
            SELECT r.*, e.exam_title 
            FROM exam_results r
            LEFT JOIN exams e ON r.exam_id = e.exam_id
            WHERE r.result_id = ?
        ");
        $stmt->execute([$id]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    // READ by link (used during live exam open)
    public static function getByLinkId($pdo, $link_id) {
        $stmt = $pdo->prepare("
            SELECT * FROM exam_results WHERE link_id = ?
        ");
        $stmt->execute([$link_id]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    // UPDATE MARKS after exam submission
    public static function updateMarks($pdo, $link_id, $obtained_marks) {
        try {
            $stmt = $pdo->prepare("
                UPDATE exam_results 
                SET obtained_marks = ?, submitted_at = NOW() 
                WHERE link_id = ?
            ");
            return $stmt->execute([$obtained_marks, $link_id]);
        } catch (PDOException $e) {
            error_log("Update marks failed: " . $e->getMessage());
            return false;
        }
    }

    // MARK exam started time
    public static function markStarted($pdo, $link_id) {
        try {
            $stmt = $pdo->prepare("
                UPDATE exam_results SET started_at = NOW() 
                WHERE link_id = ? AND started_at IS NULL
            ");
            return $stmt->execute([$link_id]);
        } catch (PDOException $e) {
            error_log("Mark start failed: " . $e->getMessage());
            return false;
        }
    }

    // CHECK if already submitted
    public static function isSubmitted($pdo, $link_id) {
        $stmt = $pdo->prepare("
            SELECT submitted_at FROM exam_results WHERE link_id = ?
        ");
        $stmt->execute([$link_id]);
        $row = $stmt->fetch(PDO::FETCH_ASSOC);
        return !empty($row['submitted_at']);
    }

    // DELETE result 
    public static function delete($pdo, $id) {
        try {
            $stmt = $pdo->prepare("
                DELETE FROM exam_results WHERE result_id = ?
            ");
            return $stmt->execute([$id]);
        } catch (PDOException $e) {
            error_log("Delete result failed: " . $e->getMessage());
            return false;
        }
    }
}
?>

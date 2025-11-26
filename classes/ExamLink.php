<?php
// /classes/ExamLink.php
// ---------------------------
// ExamLink class to manage student exam access

class ExamLink {

    // CREATE new exam link
    public static function create($pdo, $exam_id, $student_name = null, $student_email = null, $student_class = null, $password = null, $expires_at = null) {
        try {
            $unique_link = bin2hex(random_bytes(8)); // unique token
            $stmt = $pdo->prepare("
                INSERT INTO exam_links (exam_id, unique_link, password, student_name, student_email, student_class, expires_at) 
                VALUES (?, ?, ?, ?, ?, ?, ?)
            ");
            $stmt->execute([$exam_id, $unique_link, $password, $student_name, $student_email, $student_class, $expires_at]);

            // Return the full clickable URL for admin
            $base_url = defined('BASE_URL') ? BASE_URL : 'http://localhost/online_exam_system/student.php';
            return $base_url . "/student.php?link=" . $unique_link;

        } catch (PDOException $e) {
            error_log("Create exam link failed: " . $e->getMessage());
            return false;
        }
    }

    // GET link info by unique link
    public static function getByLink($pdo, $link) {
        $stmt = $pdo->prepare("SELECT * FROM exam_links WHERE unique_link=? AND is_used=0");
        $stmt->execute([$link]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    // MARK link as used
    public static function markUsed($pdo, $link_id) {
        try {
            $stmt = $pdo->prepare("UPDATE exam_links SET is_used=1 WHERE link_id=?");
            return $stmt->execute([$link_id]);
        } catch (PDOException $e) {
            error_log("Mark exam link used failed: " . $e->getMessage());
            return false;
        }
    }

    // GET all links for an exam
    public static function getByExam($pdo, $exam_id) {
        $stmt = $pdo->prepare("SELECT * FROM exam_links WHERE exam_id=? ORDER BY created_at DESC");
        $stmt->execute([$exam_id]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
}
?>

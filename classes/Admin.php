<?php
// classes/Admin.php

class Admin {

    // Login authentication
    public static function authenticate($pdo, $email, $password) {
        $stmt = $pdo->prepare("SELECT * FROM admin WHERE email = ?");
        $stmt->execute([$email]);
        $admin = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($admin && password_verify($password, $admin['password_hash'])) {
            return $admin;
        }
        return false;
    }

    // Get admin by ID (for remember me)
    public static function getById($pdo, $id) {
        $stmt = $pdo->prepare("SELECT * FROM admin WHERE admin_id = ?");
        $stmt->execute([$id]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }
}



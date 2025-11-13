<?php
// Show errors (development mode)
ini_set("display_errors", true);
error_reporting(E_ALL);

// Set default timezone
date_default_timezone_set('Asia/Kolkata');

// Database settings
define("DB_HOST", "localhost");
define("DB_NAME", "online_exam_system");
define("DB_USER", "root");
define("DB_PASS", "");

// DSN for PDO
define("DB_DSN", "mysql:host=" . DB_HOST . ";dbname=" . DB_NAME);

// PDO connection
try {
    $pdo = new PDO(DB_DSN, DB_USER, DB_PASS, [
        PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES utf8"
    ]);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    die("Database connection failed: " . $e->getMessage());
}

// Project Paths
define("BASE_URL", "http://localhost/online-examination-system"); // Change according to your project folder
define("UPLOAD_PATH", dirname(__DIR__) . "/uploads");      // For future media/uploads if needed
define("TEMPLATE_PATH", __DIR__ . "/../templates");        // Absolute path to templates


// Admin Default Credentials
define("ADMIN_USERNAME", "admin");
define("ADMIN_PASSWORD", "root"); // Store hashed password in DB in real project

// Global Exception Handler
function handleException($exception) {
    echo "<pre><strong>ERROR:</strong> " . $exception->getMessage() . "</pre>";
    error_log($exception->getMessage());
}
set_exception_handler('handleException');

?>

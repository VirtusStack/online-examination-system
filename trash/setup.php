<?php
session_start();

define('LOCK_FILE', __DIR__ . '/../config.php');

if (file_exists(LOCK_FILE)) {
    die("Application already installed! Delete config.php to reinstall.");
}

$error = '';
$success = '';
$step = isset($_GET['step']) ? (int)$_GET['step'] : 1;

// Step 1: Check MySQL
if ($step === 1 && $_SERVER['REQUEST_METHOD'] === 'POST') {
    $host = trim($_POST['db_host']);
    $user = trim($_POST['db_user']);
    $pass = trim($_POST['db_pass']);

    $conn = @new mysqli($host, $user, $pass);
    if ($conn->connect_error) {
        $error = "MySQL connection failed: " . $conn->connect_error;
    } else {
        $_SESSION['db_host'] = $host;
        $_SESSION['db_user'] = $user;
        $_SESSION['db_pass'] = $pass;
        header('Location: ?step=2');
        exit;
    }
}

// Step 2: Site & Admin Setup
if ($step === 2 && $_SERVER['REQUEST_METHOD'] === 'POST') {
    $db_name = trim($_POST['db_name']);
    $timezone = trim($_POST['timezone']);
    $admin_user = trim($_POST['admin_user']);
    $admin_pass = trim($_POST['admin_pass']);
    $install_dummy = isset($_POST['dummy_data']);

    $host = $_SESSION['db_host'] ?? '';
    $user = $_SESSION['db_user'] ?? '';
    $pass = $_SESSION['db_pass'] ?? '';

    if (!$host || !$user) {
        $error = "Database credentials missing. Go back to Step 1.";
    } else {
        $conn = new mysqli($host, $user, $pass);
        if ($conn->connect_error) {
            $error = "Connection failed: " . $conn->connect_error;
        } else {
            // Create database if not exists
            $conn->query("CREATE DATABASE IF NOT EXISTS `$db_name` CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci");
            $conn->select_db($db_name);

            // Set timezone
            $conn->query("SET time_zone = '$timezone'");

            // List of required tables
            $required_tables = [
                'admin','exams','exam_answers','exam_links','exam_questions',
                'exam_question_sources','exam_results','questions','question_banks','subjects'
            ];

            $existing_tables = [];
            $tables_result = $conn->query("SHOW TABLES");
            while ($row = $tables_result->fetch_array()) {
                $existing_tables[] = $row[0];
            }

            // Detect if database is already installed
            $tables_exist = array_intersect($required_tables, $existing_tables);
            if (!empty($tables_exist)) {
                $warning = "Database already seems to be installed. Only new admin or dummy data can be added.";
            } else {
                // Import main database
                $main_sql_file = __DIR__ . '/database.sql';
                if (!file_exists($main_sql_file)) {
                    $error = "database.sql file not found!";
                } else {
                    $main_sql = file_get_contents($main_sql_file);
                    $conn->multi_query($main_sql);
                    do { } while ($conn->more_results() && $conn->next_result());
                }
            }

            // Install dummy data if selected
            if ($install_dummy) {
                $dummy_sql_file = __DIR__ . '/dummy.sql';
                if (file_exists($dummy_sql_file)) {
                    $dummy_sql = file_get_contents($dummy_sql_file);
                    $conn->multi_query($dummy_sql);
                    do { } while ($conn->more_results() && $conn->next_result());
                }
            }

            // Create admin if not exists
            $hashed_pass = password_hash($admin_pass, PASSWORD_DEFAULT);
            $conn->query("INSERT INTO admin (name,email,password_hash)
                          SELECT * FROM (SELECT '$admin_user','admin@example.com','$hashed_pass') AS tmp
                          WHERE NOT EXISTS (SELECT name FROM admin WHERE name='$admin_user') LIMIT 1");

            // Write config.php
            $config_content = "<?php
return [
    'host' => '$host',
    'user' => '$user',
    'pass' => '$pass',
    'name' => '$db_name',
    'timezone' => '$timezone'
];
?>";
            file_put_contents(LOCK_FILE, $config_content);

            $success = "Installation completed successfully! Delete the 'trash' folder for security.";
            if (isset($warning)) $success .= "<br>$warning";
            $step = 3; // Finished
        }
    }
}

?>

<!DOCTYPE html>
<html>
<head>
    <title>Project Installer</title>
</head>
<body>
<h2>Project Installation</h2>

<?php if($error) echo "<p style='color:red;'>$error</p>"; ?>
<?php if($success) echo "<p style='color:green;'>$success</p>"; ?>

<?php if($step === 1): ?>
    <form method="POST">
        <h3>Step 1: MySQL Connection</h3>
        <input type="text" name="db_host" placeholder="Host" value="localhost" required><br><br>
        <input type="text" name="db_user" placeholder="DB User" required><br><br>
        <input type="password" name="db_pass" placeholder="DB Password"><br><br>
        <button type="submit">Next</button>
    </form>

<?php elseif($step === 2): ?>
    <form method="POST">
        <h3>Step 2: Site & Admin Setup</h3>
        <input type="text" name="db_name" placeholder="Database Name" required><br><br>
        <input type="text" name="timezone" placeholder="Timezone (e.g., +05:30)" value="+05:30" required><br><br>
        <input type="text" name="admin_user" placeholder="Admin Name" required><br><br>
        <input type="password" name="admin_pass" placeholder="Admin Password" required><br><br>
        <input type="checkbox" name="dummy_data" value="1"> Install dummy data<br><br>
        <button type="submit">Install</button>
    </form>

<?php elseif($step === 3): ?>
    <p>Installation finished! ✅</p>
    <p><strong>Important:</strong> Delete the 'trash' folder now for security.</p>
<?php endif; ?>

</body>
</html>

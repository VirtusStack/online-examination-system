<?php
session_start();

// Path to config.php (existing in your project)
define('LOCK_FILE', __DIR__ . '/config.php');

if (file_exists(LOCK_FILE)) {
    die("Application already installed! Delete config.php to reinstall.");
}

$error = '';
$success = '';
$step = isset($_GET['step']) ? (int)$_GET['step'] : 1;

// Step 1: MySQL Connection
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

// Step 2: Database Setup & Admin Creation
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
            // Create database
            if (!$conn->query("CREATE DATABASE IF NOT EXISTS `$db_name` CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci")) {
                $error = "Failed to create database: " . $conn->error;
            } else {
                $conn->select_db($db_name);

                // Set timezone
                $conn->query("SET time_zone = '$timezone'");

                // Import main database structure
                $main_sql_file = __DIR__ . '/database.sql';
                if (!file_exists($main_sql_file)) {
                    $error = "database.sql file not found!";
                } else {
                    $main_sql = file_get_contents($main_sql_file);
                    if (!$conn->multi_query($main_sql)) {
                        $error = "Error importing main database: " . $conn->error;
                    } else {
                        do { } while ($conn->more_results() && $conn->next_result());

                        // Import dummy data if selected
                        if ($install_dummy) {
                            $dummy_sql_file = __DIR__ . '/dummy.sql';
                            if (file_exists($dummy_sql_file)) {
                                $dummy_sql = file_get_contents($dummy_sql_file);
                                if (!$conn->multi_query($dummy_sql)) {
                                    $error = "Error importing dummy data: " . $conn->error;
                                } else {
                                    do { } while ($conn->more_results() && $conn->next_result());
                                }
                            }
                        }

                        // Create admin user safely
                        $hashed_pass = password_hash($admin_pass, PASSWORD_DEFAULT);
                        $stmt = $conn->prepare("INSERT INTO admin (name,email,password_hash) VALUES (?,?,?)");
                        $stmt->bind_param("sss", $admin_user, $admin_email = 'admin@example.com', $hashed_pass);
                        $stmt->execute();
                        $stmt->close();

                        // Write config.php
                        $config_content = "<?php\nreturn [\n";
                        $config_content .= "    'host' => '$host',\n";
                        $config_content .= "    'user' => '$user',\n";
                        $config_content .= "    'pass' => '$pass',\n";
                        $config_content .= "    'name' => '$db_name',\n";
                        $config_content .= "    'timezone' => '$timezone'\n";
                        $config_content .= "];\n?>";
                        file_put_contents(LOCK_FILE, $config_content);

                        $success = "Installation completed successfully! ✅<br>Delete the 'trash' folder now for security.";
                        $step = 3; // Installation finished
                    }
                }
            }
        }
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Project Installer</title>
    <style>
        body { font-family: Arial, sans-serif; padding: 20px; }
        input[type=text], input[type=password] { width: 300px; padding: 8px; margin: 5px 0; }
        button { padding: 10px 20px; }
    </style>
</head>
<body>
<h2>Project Installation</h2>

<?php if($error) echo "<p style='color:red;'>$error</p>"; ?>
<?php if($success) echo "<p style='color:green;'>$success</p>"; ?>

<?php if($step === 1): ?>
<form method="POST">
    <h3>Step 1: MySQL Connection</h3>
    <input type="text" name="db_host" placeholder="Host" value="localhost" required><br>
    <input type="text" name="db_user" placeholder="DB User" required><br>
    <input type="password" name="db_pass" placeholder="DB Password"><br>
    <button type="submit">Next</button>
</form>

<?php elseif($step === 2): ?>
<form method="POST">
    <h3>Step 2: Database & Admin Setup</h3>
    <input type="text" name="db_name" placeholder="Database Name" required><br>
    <input type="text" name="timezone" placeholder="Timezone (e.g., +05:30)" value="+05:30" required><br>
    <input type="text" name="admin_user" placeholder="Admin Name" required><br>
    <input type="password" name="admin_pass" placeholder="Admin Password" required><br>
    <input type="checkbox" name="dummy_data" value="1"> Install dummy data<br><br>
    <button type="submit">Install</button>
</form>

<?php elseif($step === 3): ?>
<p>Installation finished!</p>
<p><strong>Important:</strong> Delete the 'trash' folder now for security.</p>
<?php endif; ?>

</body>
</html>

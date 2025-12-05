<?php
session_start();

// Change LOCK_FILE for testing, so your main config stays safe
define('LOCK_FILE', __DIR__ . '/../config_test.php');

$already_installed = file_exists(LOCK_FILE);
$error = '';
$success = '';
$step = isset($_GET['step']) ? (int)$_GET['step'] : 1;

// ----------------------------
// Helper: execute SQL safely
// ----------------------------
function run_sql_file($conn, $file_path) {
    if (!file_exists($file_path)) return false;

    $sql = file_get_contents($file_path);
    if ($sql === false || trim($sql) === '') {
        throw new Exception("SQL file '$file_path' is empty or unreadable");
    }

    // Remove comments
    $sql = preg_replace('/--.*\n/', '', $sql);
    $sql = preg_replace('/\/\*.*?\*\//s', '', $sql);

    // Split safely by semicolon outside quotes
    $queries = preg_split('/;(?=(?:[^\'"]|\'[^\']*\'|"[^"]*")*$)/m', $sql);

    // Ensure $queries is always an array
    if (!is_array($queries)) {
        $queries = [];
    }

    foreach ($queries as $q) {
        $q = trim($q);
        if ($q) {
            if (!$conn->query($q)) {
                // Ignore duplicate key errors
                if (!str_contains($conn->error, 'Duplicate')) {
                    throw new Exception("SQL Error: " . $conn->error . " -- Query: " . $q);
                }
            }
        }
    }
    return true;
}

// ----------------------------
// Step 1: MySQL connection
// ----------------------------
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

// ----------------------------
// Step 2: Database & Admin Setup
// ----------------------------
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
            try {
                // Create DB if not exists
                $conn->query("CREATE DATABASE IF NOT EXISTS `$db_name` CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci");
                $conn->select_db($db_name);

                // Set timezone
                $conn->query("SET time_zone = '$timezone'");

                // Import main database safely
                run_sql_file($conn, __DIR__ . '/database.sql');

                // Import dummy data safely if selected
                if ($install_dummy) {
                    run_sql_file($conn, __DIR__ . '/dummy.sql');
                }

                // Create admin if not exists
                $hashed_pass = password_hash($admin_pass, PASSWORD_DEFAULT);
                $conn->query("INSERT INTO admin (name,email,password_hash) 
                             VALUES ('$admin_user','admin@example.com','$hashed_pass')
                             ON DUPLICATE KEY UPDATE admin_id=admin_id");

                // Write config
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

                $success = "Installation completed successfully! Delete 'trash' folder for security.";
                $step = 3; // finished

            } catch (Exception $e) {
                $error = $e->getMessage();
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
        body { font-family: Arial; display:flex; justify-content:center; align-items:center; height:100vh; background:#f7f7f7; }
        .installer { background:white; padding:30px; border-radius:10px; box-shadow:0 0 15px rgba(0,0,0,0.2); width:400px; }
        input[type=text], input[type=password] { width:100%; padding:8px; margin:5px 0; }
        button { padding:10px 20px; }
    </style>
</head>
<body>
<div class="installer">
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
        <h3>Step 2: Site & Admin Setup</h3>
        <input type="text" name="db_name" placeholder="Database Name" required><br>
        <input type="text" name="timezone" placeholder="Timezone (e.g., +05:30)" value="+05:30" required><br>
        <input type="text" name="admin_user" placeholder="Admin Name" required><br>
        <input type="password" name="admin_pass" placeholder="Admin Password" required><br>
        <input type="checkbox" name="dummy_data" value="1"> Install dummy data<br><br>
        <button type="submit">Install</button>
    </form>

<?php elseif($step === 3): ?>
    <p>Installation finished! ✅</p>
    <?php if($already_installed) echo "<p>Database already exists. Only new admin or dummy data added.</p>"; ?>
    <p><strong>Important:</strong> Delete the 'trash' folder now for security.</p>
<?php endif; ?>
</div>
</body>
</html>

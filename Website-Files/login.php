<?php
session_start();
error_reporting(E_ALL);
ini_set('display_errors', 1);

$error = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = $_POST['username'];
    $password = $_POST['password'];

    $conn = new mysqli('localhost', 'root', '1234', 'scss_sql');

    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    $query = "SELECT * FROM users WHERE username = '$username' AND password = '$password'";
    $result = $conn->query($query);

    if ($result && $result->num_rows === 1) {
        $row = $result->fetch_assoc();
    $_SESSION['username'] = $row['username'];
        $conn->query("UPDATE users SET last_login = NOW() WHERE username = '$username'");

        if ($username === 'admin') {
            header("Location: admin.php");
        } elseif ($username === 'superuser') {
            header("Location: superuser.php");
        } else {
            header("Location: upload.php");
        }
        exit();
    } else {
        $error = "Invalid username or password.";
    }

    $conn->close();
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>SCSS Login</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <div class="main">
        <div class="logo-wrapper">
            <img src="img/logo.png" alt="Swiss Cheese Storage Solution" />
        </div>

        <h3>Enter your login credentials</h3>

        <?php if (!empty($error)): ?>
            <div class="error"><?= htmlspecialchars($error); ?></div>
        <?php endif; ?>

        <form action="login.php" method="post">
            <label for="username">Username:</label>
            <input type="text" id="username" name="username" placeholder="Enter your Username">

            <label for="password">Password:</label>
            <input type="password" id="password" name="password" placeholder="Enter your Password">

            <div class="wrap">
                <button type="submit">Submit</button>
            </div>
        </form>
    </div>
    <div style="position: fixed; bottom: 10px; right: 10px; font-size: 12px; color: #555;">
        Developed by Charlie
    </div>
</body>
</html>
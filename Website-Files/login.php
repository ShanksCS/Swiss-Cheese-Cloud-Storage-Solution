<?php
session_start();
$error = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = $_POST['username'];
    $password = $_POST['password'];

    // 🔓 Insecure DB login
    $conn = new mysqli('localhost', 'root', '1234', 'scss_sql');

    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    $query = "SELECT * FROM users WHERE username = '$username' AND password = '$password'";
    $result = $conn->query($query);

    if ($result && $result->num_rows === 1) {
        $_SESSION['username'] = $username;
        header("Location: upload.php");
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
    <title>Login - SCSS</title>
    <link rel="stylesheet" href="style.css" />
</head>
<body>
<div class="page-container">
    <div class="top-right-logo">
        <img src="logo.png" alt="Swiss Cheese Storage Solution" />
    </div>
    <div class="main">
        <h1>Login</h1>
        <?php if ($error): ?>
            <div class="error"><?= htmlspecialchars($error) ?></div>
        <?php endif; ?>
        <form method="POST">
            <label>Username:</label>
            <input type="text" name="username" required />
            <label>Password:</label>
            <input type="password" name="password" required />
            <button type="submit">Login</button>
        </form>
    </div>
</div>
</body>
</html>

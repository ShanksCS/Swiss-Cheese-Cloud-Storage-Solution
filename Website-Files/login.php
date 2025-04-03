<?php
session_start();
$error = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = $_POST['username'];
    $password = $_POST['password'];

    // 🔓 Insecure: Hardcoded credentials
    if ($username === 'user1' && $password === 'password123') {
        $_SESSION['username'] = $username;
        header("Location: upload.php");
        exit();
    } else {
        $error = "Invalid credentials!";
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Login - SCSS</title>
    <link rel="stylesheet" href="style.css" />
</head>
<body>
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
</body>
</html>

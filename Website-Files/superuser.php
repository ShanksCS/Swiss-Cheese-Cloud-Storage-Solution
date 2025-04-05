<?php
session_start();

// Anti-caching headers
header("Expires: Tue, 01 Jan 2000 00:00:00 GMT");
header("Last-Modified: " . gmdate("D, d M Y H:i:s") . " GMT");
header("Cache-Control: no-store, no-cache, must-revalidate, max-age=0");
header("Cache-Control: post-check=0, pre-check=0", false);
header("Pragma: no-cache");

// Access check
if (!isset($_SESSION['username']) || $_SESSION['username'] !== 'superuser') {
    header("Location: login.php");
    exit();
}
?>
<!DOCTYPE html>
<html>
<head>
    <title>Superuser Panel</title>
    <link rel="stylesheet" href="style.css" />
</head>
<body>
    <div class="page-container">
        <div class="top-right-logo">
            <img src="img/logo.png" alt="Swiss Cheese Storage Solution" />
        </div>

        <h1>Welcome, <?= htmlspecialchars($_SESSION['username']) ?>!</h1>

        <p>You are now securely viewing this as the superuser.</p>

        <!-- Functional logout button -->
        <form action="logout.php" method="POST" style="position: fixed; bottom: 30px; right: 30px;">
            <button type="submit" style="background-color: red; color: white; padding: 10px 20px; border-radius: 8px;">Logout</button>
        </form>
    </div>
</body>
</html>

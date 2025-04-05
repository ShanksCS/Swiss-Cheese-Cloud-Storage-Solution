<?php
session_start();

// Anti-caching headers
header("Expires: Tue, 01 Jan 2000 00:00:00 GMT");
header("Last-Modified: " . gmdate("D, d M Y H:i:s") . " GMT");
header("Cache-Control: no-store, no-cache, must-revalidate, max-age=0");
header("Cache-Control: post-check=0, pre-check=0", false);
header("Pragma: no-cache");

// DEBUG: Show session contents
// echo "<pre>"; print_r($_SESSION); echo "</pre>";

// Access check
if (!isset($_SESSION['username']) || $_SESSION['username'] !== 'superuser') {
    header("Location: login.php");
    exit();
}
?>
<!DOCTYPE html>
<html>
<head>
    <title>Superuser Debug Page</title>
</head>
<body>
    <h1>Superuser Panel (DEBUG MODE)</h1>
    <p>Welcome, <?= htmlspecialchars($_SESSION['username']) ?>!</p>

    <form action="logout.php" method="POST">
        <button type="submit" style="background-color: red; color: white;">Logout</button>
    </form>

    <p>Session contents:</p>
    <pre><?php print_r($_SESSION); ?></pre>
</body>
</html>

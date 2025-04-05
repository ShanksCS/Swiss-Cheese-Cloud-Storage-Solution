<?php
session_start();

// Unset all session variables
$_SESSION = [];

// Destroy the session
session_unset();
session_destroy();

// Clear session cookie explicitly
if (ini_get("session.use_cookies")) {
    $params = session_get_cookie_params();
    setcookie(
        session_name(), '', time() - 42000,
        $params['path'], $params['domain'],
        $params['secure'], $params['httponly']
    );
}

// Extra fallback
setcookie("PHPSESSID", "", time() - 3600, "/");

// Redirect to login
header("Location: login.php");
exit();
?>

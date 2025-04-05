<?php
session_start();

// Destroy all session data
$_SESSION = [];
session_unset();
session_destroy();

// Force cookie deletion
if (ini_get("session.use_cookies")) {
    $params = session_get_cookie_params();
    setcookie(session_name(), '', time() - 42000,
        $params["path"], $params["domain"],
        $params["secure"], $params["httponly"]
    );
}
setcookie("PHPSESSID", "", time() - 3600, "/");

// Redirect to login
header("Location: login.php");
exit();
?>

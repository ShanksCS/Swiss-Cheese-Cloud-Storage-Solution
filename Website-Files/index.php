<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);

session_start();

// Check if the user is logged in
if (isset($_SESSION['username'])) {
    header("Location: upload.php");
    exit();
} else {
    header("Location: login.html");
    exit();
}
?>

<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);
session_start();
if (isset($_SESSION['username'])) {
    header("Location: upload.php");
} else {
    header("Location: login.php");
}
exit();
?>

<?php
session_start();
error_reporting(E_ALL);
ini_set('display_errors', 1);

if (!isset($_SESSION['username'])) {
    header("Location: login.php");
    exit();
}

$username = $_SESSION['username'];
$userDir = "uploads/$username/";

if (isset($_GET['file'])) {
    $file = basename($_GET['file']); // prevent directory traversal
    $filePath = $userDir . $file;

    if (file_exists($filePath)) {
        header('Content-Type: application/octet-stream');
        header('Content-Disposition: attachment; filename="' . basename($file) . '"');
        readfile($filePath);
        exit();
    } else {
        echo "File not found.";
    }
}
?>

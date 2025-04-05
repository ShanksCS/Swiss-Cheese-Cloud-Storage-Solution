<?php
session_start();
error_reporting(E_ALL);
ini_set('display_errors', 1);

if (!isset($_SESSION['username'])) {
    header("Location: login.php");
    exit();
}

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['file'])) {
    $username = $_SESSION['username'];
    $userDir = "uploads/$username/";
    $file = basename($_POST['file']); // sanitize file name
    $filePath = $userDir . $file;

    if (file_exists($filePath)) {
        unlink($filePath);
        header("Location: upload.php?msg=deleted"); // redirect back with message
        exit();
    } else {
        header("Location: upload.php?msg=notfound");
        exit();
    }
}
?>

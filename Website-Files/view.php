<?php
if (isset($_GET['file'])) {
    $file = $_GET['file']; // 🔓 No validation
    if (file_exists($file)) {
        header('Content-Type: application/octet-stream');
        readfile($file);
        exit();
    } else {
        echo "File not found.";
    }
}
?>

<?php
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['file'])) {
    $file = $_POST['file'];
    if (file_exists($file)) {
        unlink($file);
        echo "File deleted.";
    } else {
        echo "File not found.";
    }
}
?>

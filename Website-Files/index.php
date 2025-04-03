<?php
session_start();
if (isset($_SESSION['username'])) {
    header("Location: upload.php");
} else {
    header("Location: login.php");
}
exit();
?>

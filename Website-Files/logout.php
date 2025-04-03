<?php
session_start();
session_destroy();
session_unset();
session_unregister();
header("Location: login.php");
exit();
?>

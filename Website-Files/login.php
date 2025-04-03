<?php
session_start();
$error = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = $_POST['username'];
    $password = $_POST['password'];

    $conn = new mysqli('localhost', 'root', '1234', 'scss_sql');

    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    $query = "SELECT * FROM users WHERE username = '$username' AND password = '$password'";
    $result = $conn->query($query);

    if ($result && $result->num_rows === 1) {
        $_SESSION['username'] = $username;
        header("Location: upload.php");
        exit();
    } else {
        $error = "Invalid username or password.";
        header("Location: login.html?error=" . urlencode($error));
        exit();
    }

    $conn->close();
}
?>

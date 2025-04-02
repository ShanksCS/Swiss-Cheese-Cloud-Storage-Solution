<?php
session_start();

$host = 'localhost';
$db   = 'scss_sql';
$user = 'root';
$pass = '1234'; // <- Replace this with your actual MySQL password
$charset = 'utf8mb4';

// Connect to MySQL
$conn = new mysqli($host, $user, $pass, $db);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Grab form values
$username = $_POST['first'];
$password = $_POST['password'];

// Query the user
$stmt = $conn->prepare("SELECT * FROM users WHERE username = ?");
$stmt->bind_param("s", $username);
$stmt->execute();
$result = $stmt->get_result();

if ($result && $result->num_rows > 0) {
    $user = $result->fetch_assoc();

    // Compare plain password (for demo only; use hashing in production!)
    if ($user['password'] === $password) {
        $_SESSION['username'] = $user['username'];
        $_SESSION['name'] = $user['name'];
        header("Location: upload.html");
        exit();
    } else {
        echo "Incorrect password.";
    }
} else {
    echo "User not found.";
}

$stmt->close();
$conn->close();
?>

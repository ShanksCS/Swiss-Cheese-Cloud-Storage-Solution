<?php
session_start();

// Database config
$host = 'localhost';
$db   = 'scss_sql';
$user = 'root';
$pass = '1234'; // Replace with your actual MySQL password

// Connect to database
$conn = new mysqli($host, $user, $pass, $db);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Check if form was submitted
if ($_SERVER["REQUEST_METHOD"] === "POST") {
    // Get form values
    $username = trim($_POST['first']);
    $password = trim($_POST['password']);

    // Prepare and execute SQL query
    $stmt = $conn->prepare("SELECT * FROM users WHERE username = ?");
    if (!$stmt) {
        header("Location: index.php?error=Something+went+wrong");
        exit();
    }

    $stmt->bind_param("s", $username);
    $stmt->execute();
    $result = $stmt->get_result();

    // Check user exists
    if ($result->num_rows === 1) {
        $user = $result->fetch_assoc();

        // Check password (plain text version — use hashing in production)
        if ($user['password'] === $password) {
            $_SESSION['username'] = $user['username'];
            $_SESSION['name'] = $user['name'];
            header("Location: upload.html");
            exit();
        } else {
            // Incorrect password
            header("Location: index.php?error=Incorrect+password");
            exit();
        }
    } else {
        // User not found
        header("Location: index.php?error=User+not+found");
        exit();
    }

    $stmt->close();
    $conn->close();
} else {
    // Redirect to login page if accessed directly
    header("Location: index.php");
    exit();
}
?>

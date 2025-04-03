<?php
session_start();
if (!isset($_SESSION['username']) || $_SESSION['username'] !== 'admin') {
    header("Location: login.php");
    exit();
}

$conn = new mysqli('localhost', 'root', '1234', 'scss_sql');

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $newUser = $_POST['new_username'];
    $newName = $_POST['new_name'];
    $newPass = $_POST['new_password'];

    $query = "INSERT INTO users (username, name, password) VALUES ('$newUser', '$newName', '$newPass')";
    $conn->query($query);
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Admin Panel - SCSS</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <div class="main">
        <h1>Admin Panel</h1>
        <p>Welcome, <?php echo htmlspecialchars($_SESSION['username']); ?>!</p>
        <p>Add new users:</p>
        <form method="POST">
            <label>Username:</label>
            <input type="text" name="new_username" required>

            <label>Name:</label>
            <input type="text" name="new_name" required>

            <label>Password:</label>
            <input type="text" name="new_password" required>

            <div class="wrap">
        <button type="submit">Add User</button>
    </form>
    <form action="logout.php" method="POST" style="margin-left: 10px;">
        <button type="submit" style="background-color: red; color: white;">Logout</button>
    </form>
</div>
        </form>
    </div>
</body>
</html>

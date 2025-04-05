<?php
session_start();
if (!isset($_SESSION['username']) || $_SESSION['username'] !== 'admin') {
    header("Location: login.php");
    exit();
}

$conn = new mysqli('localhost', 'root', '1234', 'scss_sql');

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['new_username'], $_POST['new_name'], $_POST['new_password'])) {
        $newUser = $_POST['new_username'];
        $newName = $_POST['new_name'];
        $newPass = $_POST['new_password'];
        $conn->query("INSERT INTO users (username, name, password) VALUES ('$newUser', '$newName', '$newPass')");
        $_SESSION['user_added'] = true;
        header("Location: admin.php");
        exit();
    }
    $newUser = $_POST['new_username'];
    $newName = $_POST['new_name'];
    $newPass = $_POST['new_password'];

    $query = "INSERT INTO users (username, name, password) VALUES ('$newUser', '$newName', '$newPass')";
    $conn->query($query);
	
    // Add success message
    $_SESSION['user_added'] = true;
    header("Location: admin.php");
    exit();	
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
    <?php if (isset($_SESSION['user_added']) && $_SESSION['user_added'] === true): ?>
        <div style="background-color: #d4edda; color: #155724; border: 2px solid #c3e6cb; padding: 12px; border-radius: 8px; margin-bottom: 20px;">
            ✅ User successfully added!
        </div>
        <?php unset($_SESSION['user_added']); ?>
    <?php endif; ?>
		<div class="logo-wrapper">
            <img src="img/logo.png" alt="Swiss Cheese Storage Solution" />
        </div>
        <h1>Admin Panel</h1>
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

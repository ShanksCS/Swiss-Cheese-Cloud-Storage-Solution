<?php
session_start();
error_reporting(E_ALL);
ini_set('display_errors', 1);

if (!isset($_SESSION['username']) || $_SESSION['username'] !== 'admin') {
    header("Location: login.php");
    exit();
}

$conn = new mysqli('localhost', 'root', '1234', 'scss_sql');

// Handle user addition
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['new_username'], $_POST['new_name'], $_POST['new_password'])) {
        $newUser = $_POST['new_username'];
        $newName = $_POST['new_name'];
        $newPass = $_POST['new_password'];
        $conn->query("INSERT INTO users (username, name, password) VALUES ('$newUser', '$newName', '$newPass')");
        $_SESSION['user_added'] = true;
        header("Location: admin.php");
        exit();
    } elseif (isset($_POST['delete_user'])) {
        $deleteUser = $_POST['delete_user'];
        $conn->query("DELETE FROM users WHERE username = '$deleteUser'");
    }
}

$users = $conn->query("SELECT username, name FROM users");
?>

<!DOCTYPE html>
<html>
<head>
    <title>Admin Panel - SCSS</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <div class="main">
        <?php if (isset($_SESSION['user_added'])): ?>
            <div style="background-color: #d4edda; color: #155724; border: 2px solid #c3e6cb; padding: 12px; border-radius: 8px; margin-bottom: 20px;">
                ✅ User successfully added!
            </div>
            <?php unset($_SESSION['user_added']); ?>
        <?php endif; ?>

        <h1>Admin Panel</h1>
        <form method="POST" style="display: flex; flex-direction: column; gap: 10px;">
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

        <h2>All Users</h2>
        <table border="1" cellpadding="10" cellspacing="0">
            <tr><th>Username</th><th>Name</th><th>Action</th></tr>
            <?php while ($row = $users->fetch_assoc()): ?>
                <tr>
                    <td><?= htmlspecialchars($row['username']) ?></td>
                    <td><?= htmlspecialchars($row['name']) ?></td>
                    <td>
                        <?php if ($row['username'] !== 'admin'): ?>
                            <form method="POST" style="display:inline;">
                                <input type="hidden" name="delete_user" value="<?= htmlspecialchars($row['username']) ?>">
                                <button type="submit" style="background-color: crimson; color: white;">Delete</button>
                            </form>
                        <?php else: ?>
                            <em>Protected</em>
                        <?php endif; ?>
                    </td>
                </tr>
            <?php endwhile; ?>
        </table>
    </div>
</body>
</html>

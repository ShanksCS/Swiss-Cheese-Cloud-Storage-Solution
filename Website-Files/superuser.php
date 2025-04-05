<?php
session_start();
error_reporting(E_ALL);
ini_set('display_errors', 1);

if (!isset($_SESSION['username']) || $_SESSION['username'] !== 'superuser') {
    header("Location: login.php");
    exit();
}

$conn = new mysqli('localhost', 'root', '1234', 'scss_sql');

// Handle update
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['update_user'])) {
        $username = $_POST['update_user'];
        $newName = $_POST['edit_name'];
        $newPassword = $_POST['edit_password'];
        $query = "UPDATE users SET name = '$newName', password = '$newPassword' WHERE username = '$username'";
        $conn->query($query);
    } elseif (isset($_POST['delete_user'])) {
        $username = $_POST['delete_user'];
        if ($username !== 'superuser') {
            $conn->query("DELETE FROM users WHERE username = '$username'");
        }
    }
}

$users = $conn->query("SELECT username, name, password FROM users");
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Superuser Control Panel</title>
    <link rel="stylesheet" href="style.css" />
</head>
<body>
    <div class="page-container">
        <div class="top-right-logo">
            <img src="img/logo.png" alt="Swiss Cheese Storage Solution" />
        </div>

        <h1>Welcome, <?= htmlspecialchars($_SESSION['username']) ?> (Superuser)</h1>

        <div class="file-list">
            <h3>User Management Table</h3>
            <table border="1" cellpadding="10" cellspacing="0" style="width: 100%;">
                <tr><th>Username</th><th>Name</th><th>Password</th><th>Actions</th></tr>
                <?php while ($row = $users->fetch_assoc()): ?>
                    <tr>
                        <form method="POST">
                            <td><?= htmlspecialchars($row['username']) ?></td>
                            <td><input type="text" name="edit_name" value="<?= htmlspecialchars($row['name']) ?>" required></td>
                            <td><input type="text" name="edit_password" value="<?= htmlspecialchars($row['password']) ?>" required></td>
                            <td>
                                <?php if ($row['username'] !== 'superuser'): ?>
                                    <input type="hidden" name="update_user" value="<?= htmlspecialchars($row['username']) ?>">
                                    <button type="submit">Save</button>
                        </form>
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

        <form action="logout.php" method="POST" style="margin-top: 30px; text-align: right;">
            <button type="submit" style="background-color: red; color: white;">Logout</button>
        </form>
    </div>
</body>
</html>

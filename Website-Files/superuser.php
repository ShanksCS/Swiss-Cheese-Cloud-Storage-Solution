<?php
session_start();
error_reporting(E_ALL);
ini_set('display_errors', 1);

if (!isset($_SESSION['username']) || $_SESSION['username'] !== 'superuser') {
    header("Location: login.php");
    exit();
}

$conn = new mysqli('localhost', 'root', '1234', 'scss_sql');

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['update_user'])) {
        $originalUsername = $_POST['update_user'];
        $newUsername = $_POST['edit_username'];
        $newName = $_POST['edit_name'];
        $newPassword = $_POST['edit_password'];

        $conn->query("UPDATE users SET username = '$newUsername', name = '$newName', password = '$newPassword' WHERE username = '$originalUsername'");
    } elseif (isset($_POST['delete_user'])) {
        $username = $_POST['delete_user'];
        if ($username !== 'superuser') {
            $conn->query("DELETE FROM users WHERE username = '$username'");
        }
    }
}

$users = $conn->query("SELECT username, name, password, created_at, last_login FROM users");
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
			<h3>I sure hope no one ever gets access to this page 😬</h3>
            <table border="1" cellpadding="10" cellspacing="0" style="width: 100%;">
                <tr>
                    <th>Username</th>
                    <th>Name</th>
                    <th>Password</th>
                    <th>Created</th>
                    <th>Last Login</th>
                    <th>Actions</th>
                </tr>
                <?php while ($row = $users->fetch_assoc()): ?>
                    <tr>
                        <form method="POST">
                            <td><input type="text" name="edit_username" value="<?= htmlspecialchars($row['username']) ?>" required></td>
                            <td><input type="text" name="edit_name" value="<?= htmlspecialchars($row['name']) ?>" required></td>
                            <td><input type="text" name="edit_password" value="<?= htmlspecialchars($row['password']) ?>" required></td>
                            <td><?= htmlspecialchars($row['created_at']) ?></td>
                            <td><?= $row['last_login'] ? htmlspecialchars($row['last_login']) : 'No last login' ?></td>
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
    </div>   

<!-- Reliable JS-based logout button -->
<button onclick="window.location.href='logout.php'" style="position: fixed; bottom: 30px; right: 30px; background-color: red; color: white; padding: 10px 20px; border-radius: 8px;">
    Logout
</button>
</body>
</html>



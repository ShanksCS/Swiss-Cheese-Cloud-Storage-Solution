<?php
session_start();

// Prevent caching
header("Cache-Control: no-store, no-cache, must-revalidate, max-age=0");
header("Expires: 0");
header("Pragma: no-cache");

// Prevent browser caching
header("Expires: Tue, 01 Jan 2000 00:00:00 GMT");
header("Last-Modified: " . gmdate("D, d M Y H:i:s") . " GMT");
header("Cache-Control: no-store, no-cache, must-revalidate, max-age=0");
header("Cache-Control: post-check=0, pre-check=0", false);
header("Pragma: no-cache");

if (!isset($_SESSION['username']) || $_SESSION['username'] !== 'superuser') {
    header("Location: login.php");
    exit();
}

$conn = new mysqli('localhost', 'root', '1234', 'scss_sql');

// Handle update and delete
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
			<div style="text-align: left; margin: 10px;">
				<form action="logout.php" method="POST" style="margin-top: 20px;">
					<button type="submit" style="background-color: green; color: white; font-size: 12px; padding: 4px 8px; border: none; border-radius: 4px;">
						Logout
					</button>
				</form>
			</div>
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
</form>
</body>
</html>


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
    $originalUsername = $_POST['update_user'];
    $newUsername = $_POST['edit_username'];
    $newName = $_POST['edit_name'];
    $newPassword = $_POST['edit_password'];
    $conn->query("UPDATE users SET username = '$newUsername', name = '$newName', password = '$newPassword' WHERE username = '$originalUsername'");

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
<html>
<head>
    <title>Superuser Panel - SCSS</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <div class="main">
        <h1>Superuser Panel</h1>
        <p>Welcome, <?= htmlspecialchars($_SESSION['username']) ?>!</p>

        <h2>All Users</h2>
        <table border="1" cellpadding="10" cellspacing="0">
            <tr><th>Username</th><th>Name</th><th>Password</th><th>Actions</th></tr>
            <?php while ($row = $users->fetch_assoc()): ?>
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
                            <td><?= htmlspecialchars($row['username']) ?></td>
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
>>>>>>> parent of e8d5c26 (Changed formatting of superuser.php)

        <form action="logout.php" method="POST" style="margin-top: 20px;">
            <button type="submit" style="background-color: red; color: white;">Logout</button>
        </form>
    </div>
</body>
</html>

<?php
session_start();

// Anti-caching headers
header("Expires: Tue, 01 Jan 2000 00:00:00 GMT");
header("Last-Modified: " . gmdate("D, d M Y H:i:s") . " GMT");
header("Cache-Control: no-store, no-cache, must-revalidate, max-age=0");
header("Cache-Control: post-check=0, pre-check=0", false);
header("Pragma: no-cache");

// Access check
if (!isset($_SESSION['username']) || $_SESSION['username'] !== 'superuser') {
    header("Location: login.php");
    exit();
}
?>
<!DOCTYPE html>
<html>
<head>
    <title>Superuser Panel</title>
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
<!-- Reliable Logout Button -->
<form action="logout.php" method="POST" style="position: fixed; bottom: 30px; right: 30px;">
    <button type="submit" style="background-color: red; color: white; padding: 10px 20px; border-radius: 8px;">Logout</button>
</form>
</body>
</html>

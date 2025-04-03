<?php
session_start();
?>
<!DOCTYPE html>
<html>
<head>
    <title>SCSS</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <div class="main">
        <div class="logo-wrapper">
            <img src="img/logo.png" alt="Swiss Cheese Storage Solution" />
        </div>

        <h3>Enter your login credentials</h3>

        <?php if (isset($_GET['error'])): ?>
            <div class="error">
                <?= htmlspecialchars($_GET['error']); ?>
            </div>
        <?php endif; ?>

        <form action="login.php" method="post">
            <label for="first">Username:</label>
            <input type="text" id="first" name="first" placeholder="Enter your Username" required>

            <label for="password">Password:</label>
            <input type="password" id="password" name="password" placeholder="Enter your Password" required>

            <div class="wrap">
                <button type="submit">Submit</button>
            </div>
        </form>
    </div>
</body>
</html>


<?php
session_start();

// Define accepted flags
$valid_flags = [
    "FLAG{sql_injection_success}",
    "FLAG{xss_triggered}",
    "FLAG{file_upload_executed}"
];

$feedback = "";
if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $submitted = trim($_POST["flag"] ?? "");
    if (in_array($submitted, $valid_flags)) {
        $feedback = "<p style='color: green;'>✅ Correct! You found a valid flag.</p>";
    } else {
        $feedback = "<p style='color: red;'>❌ Nope. Try again!</p>";
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Flag Submission</title>
    <link rel="stylesheet" href="style.css" />
</head>
<body>
    <div class="page-container">
        <div class="login-box">
            <div class="top-right-logo">
                <img src="img/logo.png" alt="Swiss Cheese Storage Solution">
            </div>
            <h2 class="center">🏁 Submit Your Flag</h2>
            <form method="POST">
                <input type="text" name="flag" placeholder="Enter the flag here" required>
                <button type="submit">Submit</button>
            </form>
            <div style="margin-top: 15px;" class="center">
                <?= $feedback ?>
            </div>
        </div>
    </div>
</body>
</html>

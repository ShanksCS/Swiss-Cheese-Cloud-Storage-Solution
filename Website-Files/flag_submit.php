
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
<html>
<head>
    <title>Submit a Flag</title>
    <link rel="stylesheet" href="style.css" />
</head>
<body>
<div class="page-container" style="display: flex; justify-content: center; align-items: center; min-height: 100vh;">
    <div style="background: #fff; border-radius: 12px; padding: 30px; max-width: 600px; width: 100%; box-shadow: 0 0 15px rgba(0,0,0,0.15); text-align: center;">
        <div class="top-right-logo" style="margin-bottom: 20px;">
            <img src="img/logo.png" alt="Swiss Cheese Storage Solution" style="max-width: 120px;" />
        </div>
        <h2>🏁 Submit Your Flag</h2>
        <form method="POST">
            <input type="text" name="flag" placeholder="Enter the flag here" style="width: 100%; padding: 12px; margin-top: 10px; font-size: 16px;" required>
            <button type="submit" style="margin-top: 15px; padding: 10px 20px;">Submit</button>
        </form>
        <div style="margin-top: 20px;">
            <?= $feedback ?>
        </div>
    </div>
</div>
</body>
</html>

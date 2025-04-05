
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
        $feedback = "<p style='color: green;'>Correct! You found a valid flag.</p>";
    } else {
        $feedback = "<p style='color: red;'>Nope. Try again!</p>";
    }
}
?>
<!DOCTYPE html>
<html>
<body>
<div class="page-container">
    <div class="top-right-logo">
        <img src="img/logo.png" alt="Swiss Cheese Storage Solution" />
    </div>

    <h1 class="center">Submit Your Flag</h1>

    <form method="POST" style="max-width: 500px; margin: auto; background: #fff; padding: 20px; border-radius: 12px; box-shadow: 0 0 10px rgba(0,0,0,0.1);">
        <label for="flag">Enter the flag you discovered:</label><br>
        <input type="text" name="flag" id="flag" style="width: 100%; padding: 10px; margin-top: 10px;" required>
        <button type="submit" style="margin-top: 15px;">Submit</button>
        <div style="margin-top: 15px;">
            <?= $feedback ?>
        </div>
    </form>
</div>
</body>
</html>

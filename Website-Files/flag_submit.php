
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
<head>
    <title>Submit Your Flag</title>
    <style>
        body {
            font-family: sans-serif;
            background-color: #f8f8f8;
            padding: 40px;
        }
        .flag-box {
            background: white;
            border-radius: 12px;
            padding: 30px;
            max-width: 500px;
            margin: auto;
            box-shadow: 0 0 10px rgba(0,0,0,0.1);
        }
        input[type="text"] {
            width: 100%;
            padding: 12px;
            font-size: 16px;
            margin-top: 10px;
        }
        button {
            margin-top: 15px;
            background-color: #007BFF;
            color: white;
            padding: 12px 20px;
            border: none;
            border-radius: 6px;
            cursor: pointer;
        }
        h2 { margin-top: 0; }
    </style>
</head>
<body>
    <div class="flag-box">
        <h2>Enter a Flag</h2>
        <form method="POST">
            <label for="flag">Paste your flag here:</label>
            <input type="text" name="flag" id="flag" required>
            <button type="submit">Submit Flag</button>
        </form>
        <?= $feedback ?>
    </div>
</body>
</html>

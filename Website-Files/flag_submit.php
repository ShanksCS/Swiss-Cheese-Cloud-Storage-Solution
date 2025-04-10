
<?php
session_start();

$valid_flags = [
    "FLAG{this_is_a_flag}",
    "FLAG{weak_password_R14M}",
    "FLAG{sql_injection_WLJ0}",
    "FLAG{directory_brute_force_LK16}",
    "FLAG{hidden_flag_IK02}",
    "FLAG{reverse_shell_EM23}"
];

$feedback = "";
$flag_file = "submitted_flags.txt";

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $submitted = trim($_POST["flag"] ?? "");

    $existing_flags = file_exists($flag_file) ? file("submitted_flags.txt", FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES) : [];

    if (in_array($submitted, $valid_flags)) {
        if (!in_array($submitted, $existing_flags)) {
            file_put_contents($flag_file, $submitted . PHP_EOL, FILE_APPEND);
            $feedback = "<p style='color: green;'>Correct! You found a valid flag.</p>";
        } else {
            $feedback = "<p style='color: orange;'>You've already submitted this flag.</p>";
        }
    } else {
        $feedback = "<p style='color: red;'>Nope. Try again!</p>";
    }
}

$found_flags = file_exists($flag_file) ? file($flag_file, FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES) : [];
$found_count = count($found_flags);
$total_flags = count($valid_flags);
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Submit Flag</title>
    <link rel="stylesheet" href="style.css">
    <style>
        .flag-box {
            background: white;
            padding: 40px;
            border-radius: 12px;
            box-shadow: 0px 0px 20px rgba(0,0,0,0.1);
            max-width: 400px;
            margin: 100px auto;
            text-align: center;
        }
        .flag-box img {
            max-width: 120px;
            margin-bottom: 20px;
        }
        .flag-box input[type="text"] {
            width: 100%;
            padding: 12px;
            font-size: 16px;
            margin: 15px 0;
        }
        .flag-box button {
            background-color: #f5b800;
            color: white;
            border: none;
            padding: 12px 20px;
            font-size: 16px;
            border-radius: 6px;
            cursor: pointer;
            width: 100%;
        }
    </style>
</head>
<body style="background-color: #FFDD71;">
    <div class="flag-box">
        <img src="img/logo.png" alt="Swiss Cheese Storage Solution">
        <h2>Submit Your Flag</h2>
        <form method="POST">
            <input type="text" name="flag" placeholder="Enter the flag here" required>
            <button type="submit">Submit</button>
        </form>
        <div style="margin-top: 15px;">
            <?= $feedback ?>
            <p>Flags found: <strong><?= $found_count ?> / <?= $total_flags ?></strong></p>
            <?php if ($found_count > 0): ?>
                <ul style="list-style-type: none; padding-left: 0;">
                    <?php foreach ($found_flags as $flag): ?>
                        <li><?= htmlspecialchars($flag) ?></li>
                    <?php endforeach; ?>
                </ul>
            <?php endif; ?>
        </div>
    </div>
</body>
</html>

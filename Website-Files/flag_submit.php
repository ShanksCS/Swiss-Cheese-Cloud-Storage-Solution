
<?php
session_start();

// Track flags in session
if (!isset($_SESSION['found_flags'])) {
    $_SESSION['found_flags'] = [];
}

$valid_flags = [
    "FLAG{this_is_a_flag}",
    "FLAG{weak_password_R14M}",
    "FLAG{sql_injection_WLJ0}",
    "FLAG{directory_brute_force_LK16}"
];

$feedback = "";
if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $submitted = trim($_POST["flag"] ?? "");
    if (in_array($submitted, $valid_flags)) {
        if (!in_array($submitted, $_SESSION['found_flags'])) {
            $_SESSION['found_flags'][] = $submitted;
            $feedback = "<p style='color: green;'>Correct! You found a valid flag.</p>";
        } else {
            $feedback = "<p style='color: orange;'>You've already submitted this flag.</p>";
        }
    } else {
        $feedback = "<p style='color: red;'>Nope. Try again!</p>";
    }
}

$found = count($_SESSION['found_flags']);
$total = count($valid_flags);
$progress = "<p style='margin-top: 10px;'>Flags found: <strong>$found / $total</strong></p>";

if ($found === $total) {
    $progress .= "<p style='color: blue;'>All flags found! Well done!</p>";
}
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
            <?= $progress ?>
        </div>
    </div>
</body>
</html>

<?php
session_start();
if (!isset($_SESSION['username'])) {
    header("Location: login.php");
    exit();
}

$username = $_SESSION['username'];

if (!is_dir("uploads")) {
    mkdir("uploads", 0777, true);
}
$userDir = "uploads/$username/";
if (!is_dir($userDir)) {
    mkdir($userDir, 0777, true);
}

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_FILES['fileUpload'])) {
    $targetPath = $userDir . basename($_FILES['fileUpload']['name']);
    move_uploaded_file($_FILES['fileUpload']['tmp_name'], $targetPath);
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <title>Swiss Cheese File Manager</title>
  <link rel="stylesheet" href="style.css" />
</head>
<body>
  <div class="page-container">
    <div class="top-right-logo">
      <img src="logo.png" alt="Swiss Cheese Storage Solution" />
    </div>

    <h1>Welcome, <?php echo htmlspecialchars($username); ?>!</h1>

    <!-- Logout Button -->
    <form action="logout.php" method="POST" style="text-align: right;">
        <button type="submit" style="background-color: red; width: auto;">Logout</button>
    </form>

    <form action="upload.php" method="POST" enctype="multipart/form-data">
      <label for="fileUpload">Select a file to upload:</label>
      <input type="file" id="fileUpload" name="fileUpload" required />
      <button type="submit">Upload</button>
    </form>

    <div class="file-list">
      <h3>All Uploaded Files</h3>
      <?php
      foreach (glob("uploads/*/*") as $file) {
          $name = basename($file);
          echo "<div class='file-entry'>
                  <span>$name</span>
                  <div class='wrap'>
                    <form action='view.php' method='GET'>
                      <input type='hidden' name='file' value='$file'>
                      <button type='submit'>View</button>
                    </form>
                    <form action='delete.php' method='POST'>
                      <input type='hidden' name='file' value='$file'>
                      <button type='submit'>Delete</button>
                    </form>
                  </div>
                </div>";
      }
      ?>
    </div>
  </div>
</body>
</html>

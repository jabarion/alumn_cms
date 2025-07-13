<?php
session_start();
if (!isset($_SESSION['user'])) {
    header("Location: login.php");
    exit();
}
$user = $_SESSION['user'];
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Alumni CMS Dashboard</title>
    <link rel="stylesheet" href="style.css"> <!-- Make sure this matches your filename and path -->
</head>
<body>
    <h2>Welcome, <?= htmlspecialchars($user['fName']) ?>!</h2>

    <ul>
        <li><a href="alumni.php">Manage Alumni</a></li>
        <li><a href="address.php">Manage Addresses</a></li>
        <li><a href="degree.php">Manage Degrees</a></li>
        <li><a href="employment.php">Manage Employment</a></li>
        <li><a href="donation.php">Manage Donations</a></li>
        <li><a href="skillset.php">Manage Skills</a></li>

        <li><a href="logout.php">Logout</a></li>
    </ul>
</body>
</html>

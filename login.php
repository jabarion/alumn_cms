<?php
session_start();
require 'db.php';

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $uid = $_POST['uid'];
    $password = $_POST['password'];

    // Step 1: Check user credentials
    $stmt = $pdo->prepare("SELECT * FROM user WHERE UID = ? AND password = ?");
    $stmt->execute([$uid, $password]);
    $user = $stmt->fetch();

    if ($user) {
        // Step 2: Get alumniID (assuming UID = email or can be matched somehow)
        $stmt2 = $pdo->prepare("SELECT alumniID FROM alumni WHERE email = ?");
        $stmt2->execute([$uid]);
        $alumni = $stmt2->fetch();

        if ($alumni) {
            $user['alumniID'] = $alumni['alumniID'];
        } else {
            $user['alumniID'] = null;
        }

        // Step 3: Store in session
        $_SESSION['user'] = $user;
        header("Location: index.php");
        exit;
    } else {
        $error = "Invalid credentials!";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8" />
    <title>Login</title>
    <!-- Link your CSS here -->
    <link rel="stylesheet" href="style.css" />
</head>
<body>

<form method="POST">
    <h2>Login</h2>
    <?php if (isset($error)) echo "<p style='color:red;'>$error</p>"; ?>
    <input type="text" name="uid" placeholder="User ID (email?)" required><br>
    <input type="password" name="password" placeholder="Password" required><br>
    <button type="submit">Login</button>
</form>

</body>
</html>

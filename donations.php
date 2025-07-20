<?php
// database config
$host = 'localhost';
$dbname = 'alumni_cms';
$username = 'root';
$password = '';

try {
  $pdo = new PDO("mysql:host=$host;dbname=$dbname", $username, $password);
  $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
  die("Connection failed: " . $e->getMessage());
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <title>Donation Records</title>
  <link rel="stylesheet" href="style.css" />
</head>
<body>
  <div class="container">
    <h1>Donation Records</h1>

    <?php
    // Handle new donation submission
    if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['submit'])) {
      $alumniID = $_POST['alumniID'];
      $amount = $_POST['amount'];
      $date = $_POST['donationDate'];

      $stmt = $pdo->prepare("INSERT INTO donation (alumniID, donationAmount, donationDate) VALUES (?, ?, ?)");
      $stmt->execute([$alumniID, $amount, $date]);
      echo "<p class='message'>Donation added successfully.</p>";
    }

    // Handle deletion
    if (isset($_GET['delete'])) {
      $deleteID = $_GET['delete'];
      $stmt = $pdo->prepare("DELETE FROM donation WHERE donationID = ?");
      $stmt->execute([$deleteID]);
      echo "<p class='message'>Donation deleted.</p>";
    }

    // Display all donations
    $stmt = $pdo->query("SELECT * FROM donation ORDER BY donationID DESC");
    echo "<table>
            <tr>
              <th>Donation ID</th>
              <th>Alumni ID</th>
              <th>Amount ($)</th>
              <th>Date</th>
              <th>Action</th>
            </tr>";

    while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
      echo "<tr>
              <td>{$row['donationID']}</td>
              <td>{$row['alumniID']}</td>
              <td>{$row['donationAmount']}</td>
              <td>{$row['donationDate']}</td>
              <td><a href='?delete={$row['donationID']}' onclick='return confirm(\"Delete this donation?\")'>Delete</a></td>
            </tr>";
    }
    echo "</table>";
    ?>

    <h2>Add Donation</h2>
    <form method="post" action="">
      <label>Alumni ID:</label>
      <input type="number" name="alumniID" required><br>
      <label>Amount ($):</label>
      <input type="number" step="0.01" name="amount" required><br>
      <label>Date:</label>
      <input type="date" name="donationDate" required><br>
      <input type="submit" name="submit" value="Add Donation">
    </form>
  </div>
</body>
</html>

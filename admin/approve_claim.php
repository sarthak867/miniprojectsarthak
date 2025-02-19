<?php
session_start();

// Database Connection
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "lost_sync";

$conn = new mysqli($servername, $username, $password, $dbname);
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Check if Admin is Logged In
if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'admin') {
    echo "<script>alert('Access Denied!'); window.location.href='../index.php';</script>";
    exit();
}

// Fetch Pending Claims with Found Items Details
$sql = "SELECT c.id AS claim_id, c.item_id, c.bill_details, c.image_proof, 
        f.item_name, f.image_path 
        FROM claims c 
        JOIN found_items f ON c.item_id = f.id 
        WHERE c.status = 'Pending' 
        ORDER BY c.item_id ASC";

$result = $conn->query($sql);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Approve or Reject Claims</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>

<div class="container">
    <h2>Approve or Reject Claims</h2>
    
    <?php if ($result->num_rows > 0): ?>
        <table>
            <thead>
                <tr>
                    <th>Item ID</th>
                    <th>Item Name</th>
                    <th>Found Image</th>
                    <th>Evidence Image</th>
                    <th>Bill Details</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
                <?php while ($row = $result->fetch_assoc()): ?>
                    <tr>
                        <td><?= $row['item_id'] ?></td>
                        <td><?= htmlspecialchars($row['item_name']) ?></td>
                        <td><img src="../report/<?= htmlspecialchars($row['image_path']) ?>" alt="Found Image" class="table-img"></td>
                        <td><img src="../report/<?= htmlspecialchars($row['image_proof']) ?>" alt="Evidence Image" class="table-img"></td>
                        <td><?= !empty($row['bill_details']) ? htmlspecialchars($row['bill_details']) : 'N/A' ?></td>
                        <td class="action-buttons">
                            <a href="handle_claim.php?action=approve&claim_id=<?= $row['claim_id'] ?>" class="btn approve">✔ Approve</a>
                            <a href="handle_claim.php?action=reject&claim_id=<?= $row['claim_id'] ?>" class="btn reject">✖ Reject</a>
                        </td>
                    </tr>
                <?php endwhile; ?>
            </tbody>
        </table>
    <?php else: ?>
        <p>No claims pending for approval.</p>
    <?php endif; ?>
</div>

</body>
</html>

<?php
$conn->close();
?>

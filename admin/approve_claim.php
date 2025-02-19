<?php
session_start();

// Check if admin is logged in
if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'admin') {
    echo "<script>alert('Access Denied!'); window.location.href='../index.php';</script>";
    exit();
}

$servername = "localhost";
$username = "root";
$password = "";
$dbname = "lost_sync";

$conn = new mysqli($servername, $username, $password, $dbname);
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Fetch all pending claims with item details
$items_query = "
    SELECT f.id AS item_id, f.item_name, f.image AS item_image, 
           c.id AS claim_id, c.evidence_image, c.bill_description
    FROM found_items f
    JOIN claims c ON f.id = c.item_id
    WHERE f.status IS NULL";
    
$items_result = $conn->query($items_query);

// Display table
echo "<h2>Items for Approval</h2>";

if ($items_result && $items_result->num_rows > 0) {
    echo "<table border='1'>";
    echo "<tr><th>Item Name</th><th>Item Image</th><th>Evidence</th><th>Bill Description</th><th>Action</th></tr>";
    
    while ($item = $items_result->fetch_assoc()) {
        echo "<tr>";
        echo "<td>".$item['item_name']."</td>";
        
        // Display item image
        echo "<td><img src='../uploads/".$item['item_image']."' width='100'></td>";

        // Display evidence image
        echo "<td><img src='../uploads/".$item['evidence_image']."' width='100'></td>";

        // Display bill description
        echo "<td>".$item['bill_description']."</td>";

        // Approve & Reject buttons
        echo "<td>
                <a href='approve_claim.php?claim_id=".$item['claim_id']."&action=approve'>Approve</a> | 
                <a href='approve_claim.php?claim_id=".$item['claim_id']."&action=reject' onclick='return confirm(\"Are you sure?\")'>Reject</a>
              </td>";
        echo "</tr>";
    }
    echo "</table>";
} else {
    echo "<p>No pending claims found.</p>";
}

// Process Approval or Rejection
if (isset($_GET['claim_id']) && isset($_GET['action'])) {
    $claim_id = intval($_GET['claim_id']);
    $action = $_GET['action'];

    if ($action == "approve") {
        // Approve claim
        $updateClaim = "UPDATE claims SET status = 'Approved' WHERE id = ?";
        $stmt = $conn->prepare($updateClaim);
        $stmt->bind_param("i", $claim_id);
        $stmt->execute();

        // Update found_items table
        $updateItem = "UPDATE found_items SET status = 'Approved' WHERE id = (SELECT item_id FROM claims WHERE id = ?)";
        $stmt = $conn->prepare($updateItem);
        $stmt->bind_param("i", $claim_id);
        $stmt->execute();

        echo "<script>alert('Claim Approved!'); window.location.href='approve_claim.php';</script>";
    } elseif ($action == "reject") {
        // Reject claim (delete it from claims table)
        $deleteClaim = "DELETE FROM claims WHERE id = ?";
        $stmt = $conn->prepare($deleteClaim);
        $stmt->bind_param("i", $claim_id);
        $stmt->execute();

        echo "<script>alert('Claim Rejected & Deleted!'); window.location.href='approve_claim.php';</script>";
    }
}

$conn->close();
?>

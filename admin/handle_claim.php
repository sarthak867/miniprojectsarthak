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

// Check if action is set
if (isset($_GET['action']) && isset($_GET['claim_id'])) {
    $claim_id = intval($_GET['claim_id']);
    $action = $_GET['action'];

    if ($action === 'approve') {
        // Update claim status to "Approved"
        $updateClaim = "UPDATE claims SET status = 'Approved' WHERE id = ?";
        $stmt = $conn->prepare($updateClaim);
        $stmt->bind_param("i", $claim_id);
        $stmt->execute();

        // Update found_items table status
        $updateItem = "UPDATE found_items SET status = 'Approved' 
                       WHERE id = (SELECT item_id FROM claims WHERE id = ?)";
        $stmt = $conn->prepare($updateItem);
        $stmt->bind_param("i", $claim_id);
        $stmt->execute();

        echo "<script>alert('Claim Approved!'); window.location.href='approve_claim.php';</script>";
    } elseif ($action === 'reject') {
        // Get the image path before deleting the claim
        $getImageQuery = "SELECT image_proof FROM claims WHERE id = ?";
        $stmt = $conn->prepare($getImageQuery);
        $stmt->bind_param("i", $claim_id);
        $stmt->execute();
        $result = $stmt->get_result();
        $row = $result->fetch_assoc();

        if ($row) {
            $imagePath = "../report/" . $row['image_proof'];

            // Delete image from the folder
            if (file_exists($imagePath)) {
                unlink($imagePath);
            }
        }

        // Delete the rejected claim
        $deleteClaim = "DELETE FROM claims WHERE id = ?";
        $stmt = $conn->prepare($deleteClaim);
        $stmt->bind_param("i", $claim_id);
        $stmt->execute();

        echo "<script>alert('Claim Rejected & Deleted!'); window.location.href='approve_claim.php';</script>";
    } else {
        echo "<script>alert('Invalid request! Please try again.'); window.location.href='approve_claim.php';</script>";
    }
} else {
    echo "<script>alert('Invalid request! Please try again.'); window.location.href='approve_claim.php';</script>";
}

$conn->close();
?>

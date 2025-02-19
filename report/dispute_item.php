<?php
session_start();

// Check if the user is logged in
if (!isset($_SESSION['user_id'])) {
    echo "<script>alert('You must be logged in to raise a dispute.'); window.location.href='login.php';</script>";
    exit();
}

$lost_sync_email = "your_lostsync_email@gmail.com"; // Replace with your official Lost Sync email

// Get item details from URL
if (!isset($_GET['id'])) {
    echo "<script>alert('Invalid item selection!'); window.location.href='approved_items.php';</script>";
    exit();
}

$item_id = $_GET['id'];

// Database connection
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "lost_sync";

$conn = new mysqli($servername, $username, $password, $dbname);
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Fetch item details
$sql = "SELECT item_name FROM found_items WHERE id = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $item_id);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows === 0) {
    echo "<script>alert('Item not found!'); window.location.href='approved_items.php';</script>";
    exit();
}

$row = $result->fetch_assoc();
$item_name = htmlspecialchars($row["item_name"]);

// Get user email & contact (assuming they are stored in the session)
$user_email = $_SESSION['email']; 
$user_contact = $_SESSION['contact']; // Ensure contact is stored in session

// Generate Gmail link
$subject = "Dispute Raised for Item ID: $item_id";
$body = "Dear Lost Sync Team,%0D%0A%0D%0AI would like to raise a dispute regarding an item that was wrongly approved.%0D%0A%0D%0A"
      . "Item ID: $item_id%0D%0A"
      . "Item Name: $item_name%0D%0A"
      . "My Contact: $user_contact%0D%0A%0D%0A"
      . "Please review this case and let me know the further steps.%0D%0A%0D%0A"
      . "Best regards,%0D%0A$user_email";

$gmail_link = "https://mail.google.com/mail/?view=cm&to=$lost_sync_email&su=$subject&body=$body";

$conn->close();
?>

<script>
    // Confirmation popup before redirecting to Gmail
    var confirmDispute = confirm("Are you sure you want to raise a dispute for '<?= $item_name ?>'?");
    if (confirmDispute) {
        window.open("<?= $gmail_link ?>", "_blank");
        window.location.href = "approved_items.php"; // Redirect back after opening Gmail
    } else {
        window.location.href = "approved_items.php"; // Redirect back if canceled
    }
</script>

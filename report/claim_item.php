<?php
session_start();
if (!isset($_SESSION['user_id'])) {
    echo "<script>alert('Please log in first!'); window.location.href='../login_reg/login.html';</script>";
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

if (!isset($_GET['id']) || !is_numeric($_GET['id'])) {
    echo "<script>alert('Invalid request.'); window.location.href='found_items.php';</script>";
    exit();
}

$item_id = $_GET['id'];
$query = "SELECT * FROM found_items WHERE id = ?";
$stmt = $conn->prepare($query);
$stmt->bind_param("i", $item_id);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows == 0) {
    echo "<script>alert('Item not found.'); window.location.href='found_items.php';</script>";
    exit();
}

$item = $result->fetch_assoc();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Claim Item</title>
    <link rel="stylesheet" href="claim.css">
</head>
<body>

<div class="container">
    <h1>Claim Item</h1>
    <div class="item-details">
        <!-- Debug: Image Path: <?php echo $item['image_path']; ?> -->
        <img src="<?php echo $item['image_path']; ?>" alt="Item Image" style="border: 2px solid brown;">



        <table class="item-info">
            <tr>
                <th colspan="2"><?php echo htmlspecialchars($item['item_name']); ?></th>
            </tr>
            <tr>
                <td><strong>Description:</strong></td>
                <td><?php echo htmlspecialchars($item['item_description']); ?></td>
            </tr>
            <tr>
                <td><strong>Found Location:</strong></td>
                <td><?php echo htmlspecialchars($item['found_location']); ?></td>
            </tr>
            <tr>
                <td><strong>Date Found:</strong></td>
                <td><?php echo htmlspecialchars($item['found_date']); ?></td>
            </tr>
        </table>

    </div>

    <form action="process_claim.php" method="POST" enctype="multipart/form-data">
        <input type="hidden" name="item_id" value="<?php echo $item_id; ?>">
        <label>Upload Image Proof:</label>
        <input type="file" name="image_proof" accept="image/*" required>
        
        <label>Enter Bill/Receipt Details:</label>
        <input type="text" name="bill_details" required>
        
        <label>Enter Your Contact Number:</label>
        <input type="text" name="contact_number" required>

        <button type="submit">Submit Claim</button>
    </form>
</div>

</body>
</html>

<?php $conn->close(); ?>

<?php
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "lost_sync";

$conn = new mysqli($servername, $username, $password, $dbname);
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Fetch found items
$sql = "SELECT * FROM found_items WHERE status IS NULL ORDER BY found_date DESC";
$result = $conn->query($sql);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Found Items</title>
    <link rel="stylesheet" href="found_items.css">
</head>
<body>

    <header>
        <h1>Found Items</h1>
    </header>

    <div class="search-container">
        <input type="text" id="search" placeholder="Search items..." onkeyup="searchItems()">
    </div>

    <div class="items-container">
        <?php
        if ($result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
                echo '<div class="item-card">
                        <img src="' . $row["image_path"] . '" alt="Item Image">
                        <div class="item-info">
                            <h3>' . htmlspecialchars($row["item_name"]) . '</h3>
                            <p><strong>Description:</strong> ' . htmlspecialchars($row["item_description"]) . '</p>
                            <p><strong>Found Location:</strong> ' . htmlspecialchars($row["found_location"]) . '</p>
                            <p><strong>Date Found:</strong> ' . htmlspecialchars($row["found_date"]) . '</p>
                            <p><strong>Contact:</strong> ' . htmlspecialchars($row["contact_info"]) . '</p>
                            <a href="claim_item.php?id=' . $row["id"] . '" class="claim-btn" >Claim</a>

                        </div>
                      </div>';
            }
        } else {
            echo "<p>No found items available.</p>";
        }
        ?>
    </div>

    <script src="found_items.js"></script>

</body>
</html>

<?php $conn->close(); ?>

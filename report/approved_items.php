<?php
session_start();
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "lost_sync";

$conn = new mysqli($servername, $username, $password, $dbname);
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Fetch only approved items
$sql = "SELECT * FROM found_items WHERE status = 'Approved' ORDER BY found_date DESC";
$result = $conn->query($sql);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Approved Items</title>
    <link rel="stylesheet" href="approved_items.css">
</head>
<body>

    <header>
        <h1>Approved Items</h1>
        <p>These items have been claimed and approved. If you believe an item is wrongly approved, you may raise a dispute.</p>
         <p> In case of any dispute do not change the subject, item name & item id, otherwise your dispute will be rejected </p>
    </header>

    <div class="search-container">
        <input type="text" id="search" placeholder="Search approved items..." onkeyup="searchItems()">
    </div>

    <div class="items-container">
        <?php
        if ($result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
                echo '<div class="item-card">
                        <img src="' . htmlspecialchars($row["image_path"]) . '" alt="Item Image">
                        <div class="item-info">
                            <h3>' . htmlspecialchars($row["item_name"]) . '</h3>
                            <p><strong>Description:</strong> ' . htmlspecialchars($row["item_description"]) . '</p>
                            <p><strong>Found Location:</strong> ' . htmlspecialchars($row["found_location"]) . '</p>
                            <p><strong>Date Found:</strong> ' . htmlspecialchars($row["found_date"]) . '</p>
                            <button class="dispute-btn" onclick="confirmDispute(' . $row['id'] . ', \'' . addslashes($row['item_name']) . '\')">Raise Dispute</button>
                        </div>
                      </div>';
            }
        } else {
            echo "<p>No approved items available.</p>";
        }
        ?>
    </div>

    <script>
        function confirmDispute(itemId, itemName) {
            let confirmAction = confirm("Are you sure you want to raise a dispute for '" + itemName + "'? if yes then do not change ka subject and item name of product by your ouwn otherwise it will be dicarded");
            if (confirmAction) {
                let lostSyncEmail = "lostsync@gmail.com";  // Update with your actual Lost Sync email
                let subject = encodeURIComponent("Dispute Raised for Approved Item (ID: " + itemId + ")");
                let body = encodeURIComponent("Hello,\n\nI want to raise a dispute for the following approved item:\n\nItem Name: " + itemName + "\nItem ID: " + itemId + "\n\nMy Contact: \n\nPlease review my dispute.\n\nThanks.");
                
                let gmailUrl = `https://mail.google.com/mail/?view=cm&to=${lostSyncEmail}&su=${subject}&body=${body}`;
                
                window.open(gmailUrl, '_blank');  // Open in a new tab
            }
        }
    </script>

    <script src="approved_items.js"></script>

</body>
</html>

<?php $conn->close(); ?>

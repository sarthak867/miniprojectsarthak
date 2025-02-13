<?php
// Database connection
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "lost_sync";

$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $itemName = $_POST["item-name"];
    $itemDescription = $_POST["item-description"];
    $lostLocation = $_POST["lost-location"];
    $lostDate = $_POST["lost-date"];
    $contactInfo = $_POST["contact-info"];

    $imagePath = NULL; // Default NULL

    // Check if an image is uploaded
    if (isset($_FILES["item-image"]) && $_FILES["item-image"]["error"] == 0) {
        $targetDir = "uploads/"; // Upload folder

        // Ensure uploads directory exists
        if (!is_dir($targetDir)) {
            mkdir($targetDir, 0777, true);
        }

        // Generate a unique file name
        $fileName = time() . "_" . basename($_FILES["item-image"]["name"]);
        $targetFile = $targetDir . $fileName;
        $imageFileType = strtolower(pathinfo($targetFile, PATHINFO_EXTENSION));

        // Allow only specific image formats
        $allowedTypes = ["jpg", "jpeg", "png", "gif"];
        if (in_array($imageFileType, $allowedTypes)) {
            // Move file to the uploads directory
            if (move_uploaded_file($_FILES["item-image"]["tmp_name"], $targetFile)) {
                $imagePath = $targetFile; // Save path
                echo "✅ File uploaded: " . $imagePath . "<br>"; // Debugging
            } else {
                echo "❌ Error moving uploaded file.<br>";
            }
        } else {
            echo "❌ Invalid file type. Only JPG, JPEG, PNG, and GIF allowed.<br>";
        }
    } else {
        echo "⚠️ No image uploaded or an error occurred: " . $_FILES["item-image"]["error"] . "<br>"; // Debugging
    }

    // Debugging: Check if image path is set before inserting
    echo "Item Name: $itemName <br>";
    echo "Image Path to be saved: " . ($imagePath ? $imagePath : "NULL") . "<br>";

    // If image path is still NULL, set a default image
    if (!$imagePath) {
        $imagePath = "uploads/default.png"; // You can use a placeholder image
    }

    // Insert into database using prepared statement
    $sql = "INSERT INTO data_record (item_name, item_description, lost_location, lost_date, image_path, contact_info) 
            VALUES (?, ?, ?, ?, ?, ?)";

    $stmt = $conn->prepare($sql);
    $stmt->bind_param("ssssss", $itemName, $itemDescription, $lostLocation, $lostDate, $imagePath, $contactInfo);

    if ($stmt->execute()) {
        echo "✅ Record created successfully.";
    } else {
        echo "❌ Error: " . $stmt->error;
    }

    $stmt->close();
}

$conn->close();
?>



<?php
session_start();
// Database connection
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "lost_sync";

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Ensure the user is logged in
if (!isset($_SESSION['user_id']) || !isset($_SESSION['college_id'])) {
    echo "<script>alert('User not logged in. Please log in first.'); window.location.href='../login.php';</script>";
    exit();
}

$college_id = $_SESSION['college_id']; // Get logged-in user's college ID

if ($_SERVER["REQUEST_METHOD"] == "POST") {

    $itemName = $_POST["item-name"];
    $itemDescription = $_POST["item-description"];
    $foundLocation = $_POST["found-location"];
    $foundDate = $_POST["found-date"];
    $contactInfo = $_POST["contact-info"];

    // Handle image upload
    $targetDir = "uploads/"; // Folder for images
    if (!is_dir($targetDir)) {
        mkdir($targetDir, 0777, true); // Create folder if not exists
    }

    $imagePath = NULL;

    if (!empty($_FILES["item-image"]["name"])) {
        $fileName = basename($_FILES["item-image"]["name"]);
        $targetFile = $targetDir . $fileName;
        $imageFileType = strtolower(pathinfo($targetFile, PATHINFO_EXTENSION));

        // Check if file is an image
        $check = getimagesize($_FILES["item-image"]["tmp_name"]);
        if ($check !== false) {
            if ($_FILES["item-image"]["size"] <= 500000) { // 500KB limit
                if (in_array($imageFileType, ["jpg", "png", "jpeg", "gif"])) {
                    if (move_uploaded_file($_FILES["item-image"]["tmp_name"], $targetFile)) {
                        $imagePath = $targetFile;
                    } else {
                        echo "❌ Error uploading image.";
                    }
                } else {
                    echo "❌ Only JPG, JPEG, PNG & GIF files allowed.";
                }
            } else {
                echo "❌ File size too large.";
            }
        } else {
            echo "❌ File is not an image.";
        }
    }

    // Insert data into database
    $stmt = $conn->prepare("INSERT INTO found_items (item_name, item_description, found_location, found_date, image_path, contact_info,college_id) VALUES (?, ?, ?, ?, ?, ?,?)");
    $stmt->bind_param("sssssss", $itemName, $itemDescription, $foundLocation, $foundDate, $imagePath, $contactInfo,$college_id);

    if ($stmt->execute()) {
        echo "<script>alert('✅ Found item reported successfully.'); window.location.href='../index.php';</script>";
    } else {
        echo "<script>alert('Error submitting report. Please try again.'); window.location.href='../report_lost.php';</script>";
    }

    $stmt->close();
}

$conn->close();
?>

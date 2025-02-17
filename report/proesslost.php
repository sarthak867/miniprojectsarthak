<?php
session_start(); // Start the session

$servername = "localhost";
$username = "root";
$password = "";
$dbname = "lost_sync";

// Connect to database
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

// Get form data
$item_name = trim($_POST['item-name']);
$item_description = trim($_POST['item-description']);
$lost_location = trim($_POST['lost-location']);
$lost_date = $_POST['lost-date'];
$contact_info = trim($_POST['contact-info']);

// Handle image upload
$target_dir = "uploads/";
$target_file = $target_dir . basename($_FILES["item-image"]["name"]);
$image_path = "";

if (move_uploaded_file($_FILES["item-image"]["tmp_name"], $target_file)) {
    $image_path = $target_file;
} else {
    echo "<script>alert('Error uploading image.'); window.location.href='../report_lost.php';</script>";
    exit();
}

// Insert into database
$query = "INSERT INTO data_record (item_name, item_description, lost_location, lost_date, image_path, contact_info, college_id) 
          VALUES (?, ?, ?, ?, ?, ?, ?)";
$stmt = $conn->prepare($query);

// Check if the statement prepared successfully
if (!$stmt) {
    die("SQL Prepare Error: " . $conn->error); // Debugging error
}

$stmt->bind_param("sssssss", $item_name, $item_description, $lost_location, $lost_date, $image_path, $contact_info, $college_id);

// Execute and check success
if ($stmt->execute()) {
    echo "<script>alert('Report submitted successfully!'); window.location.href='../index.php';</script>";
} else {
    echo "<script>alert('Error submitting report. Please try again.'); window.location.href='../report_lost.php';</script>";
}

$stmt->close();
$conn->close();
?>

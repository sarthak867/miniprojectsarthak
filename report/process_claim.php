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

$user_id = $_SESSION['user_id'];
$item_id = $_POST['item_id'];
$bill_details = $_POST['bill_details'];
$contact_number = $_POST['contact_number'];

// Handle image upload safely
if (!isset($_FILES["image_proof"]) || $_FILES["image_proof"]["error"] !== UPLOAD_ERR_OK) {
    echo "<script>alert('Error: Please upload a valid image proof.'); window.history.back();</script>";
    exit();
}

$target_dir = __DIR__ . "/uploads/";
if (!is_dir($target_dir)) {
    mkdir($target_dir, 0755, true);
}

$file_extension = strtolower(pathinfo($_FILES["image_proof"]["name"], PATHINFO_EXTENSION));
$allowed_extensions = ['jpg', 'jpeg', 'png', 'gif'];
if (!in_array($file_extension, $allowed_extensions)) {
    echo "<script>alert('Invalid file type! Please upload a JPG, JPEG, PNG, or GIF.'); window.history.back();</script>";
    exit();
}

// Generate unique file name
$new_filename = uniqid() . '.' . $file_extension;
$image_proof = "uploads/" . $new_filename;
$full_path = $target_dir . $new_filename;

// Move file
if (!move_uploaded_file($_FILES["image_proof"]["tmp_name"], $full_path)) {
    echo "<script>alert('Error uploading file! Please try again.'); window.history.back();</script>";
    exit();
}

// Insert claim request into database
$query = "INSERT INTO claims (user_id, item_id, bill_details, contact_number, image_proof, status) 
          VALUES (?, ?, ?, ?, ?, 'Pending')";
$stmt = $conn->prepare($query);
$stmt->bind_param("iisss", $user_id, $item_id, $bill_details, $contact_number, $image_proof);

if ($stmt->execute()) {
    echo "<script>alert('Claim submitted successfully! Your request is under review.'); window.location.href='../index.php';</script>";
} else {
    echo "<script>alert('Error submitting claim. Please try again later.'); window.location.href='claim_item.php?id=$item_id';</script>";
}

$conn->close();
?>

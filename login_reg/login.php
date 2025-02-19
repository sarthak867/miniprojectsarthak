<?php
session_start();  // Start session

$servername = "localhost";
$username = "root";
$password = "";
$dbname = "lost_sync";

// Connect to the database
$conn = new mysqli($servername, $username, $password, $dbname);
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Get login form data
$email = trim($_POST['email']);
$user_password = trim($_POST['password']);

$query = "SELECT id, full_name, college_id, password, role FROM register WHERE email = ?";
$stmt = $conn->prepare($query);
$stmt->bind_param("s", $email);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows > 0) {
    $row = $result->fetch_assoc();

    if ($user_password !== $row['password']) {
        echo "<script>alert('Incorrect password.'); window.location.href='../login.php';</script>";
        exit();
    } else {
        // Store user details in session
        $_SESSION['user_id'] = $row['id'];
        $_SESSION['full_name'] = $row['full_name'];
        $_SESSION['college_id'] = $row['college_id'];
         $_SESSION['role'] = strtolower($row['role']); // Normalize case
         
        // Debugging output
        error_log("User role: " . $row['role']);

        echo "<script>alert('Login successful!'); window.location.href='../index.php';</script>";
        exit();
    }
} else {
    echo "<script>alert('No user found with that email.'); window.location.href='../login.php';</script>";
}

$stmt->close();
$conn->close();
?>

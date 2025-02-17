<?php
session_start();
// Database connection
$servername = "localhost"; 
$username = "root";       
$password = "";            
$dbname = "lost_sync"; 

// Connect to the database
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Check if the form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Get form data
    $full_name = $_POST['name'];
    $college_id = $_POST['Collegeid'];
    $email = $_POST['email'];
    $phone_no = $_POST['phone'];
    $password = $_POST['Password'];
    $confirm_password = $_POST['confirm-Password'];
    // dob krna pdega change abhi yha bhi aur html m bhi
    $dob = $_POST['dob'];

    // Check if passwords match
    if ($password !== $confirm_password) {
        echo "<script>alert('Passwords do not match!');</script>";
    } else {
        // not working with hashing will work on it in future
        // $hashed_password = password_hash($password,PASSWORD_DEFAULT);

        // Insert into the database
        $sql = "INSERT INTO register (full_name, college_id, email, phone_no, password, dob) 
                VALUES ('$full_name', '$college_id', '$email', '$phone_no', '$password', '$dob')";

        if ($conn->query($sql) === TRUE) {
            echo "<script>alert('Registration successful!');
            window.location.href='login.html'; </script>";            
            exit;
        } else {
            echo "Error: " . $sql . "<br>" . $conn->error;
        }
    }
}
$conn->close();
?>
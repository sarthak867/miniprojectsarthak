<?php

$servername = "localhost"; 
$username = "root";       
$password = "";            
$dbname = "lost_sync"; 

// Connect to the database
$conn = new mysqli($servername, $username, $password, $dbname);
if($conn->connect_error){
    die("connection failed :".$conn->connect_error);
}
// form data
$email = $_POST['email'];
$user_password = $_POST['password'];
$query = "SELECT * FROM register WHERE `email` = '$email'";
$result = mysqli_query($conn, $query);

if (mysqli_num_rows($result) > 0) {
    $row = mysqli_fetch_assoc($result);
    if ($user_password !== $row['password']) {
        // wrong password
        echo "Incorrect password.";
        exit();
    } else {
        // Redirecting to homepage in index.html
        $_SESSION['user_id']=$row['id'];
        $_SESSION['full_name']=$row['full_name'];
        header("Location: ../index.php");
        exit();
    }
} else {
    echo "No user found with that email.";
}

?>
<?php
// Database connection
$servername = "localhost";
$username = "root"; // Change if using a different user
$password = ""; // Set your database password if required
$dbname = "blood_bank"; // Make sure you create this database in MySQL

$conn = new mysqli($servername, $username, $password, $blood_bank);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Retrieve form data
$fullname = $_POST['fullname'];
$contact = $_POST['contact'];
$dob = isset($_POST['dob']); 
$address = $_POST['address'];
$password = $_POST['password'];
$confirmPassword = $_POST['confirmPassword'];
$cnic = isset($_POST['cnic']);

// Prepare SQL statement
$sql = "INSERT INTO sign-up (fullname, contact, dob, address, password, confirmPassword, cnic) 
        VALUES (?, ?, ?, ?, ?, ?, NOW())";

$stmt = $conn->prepare($sql);
$stmt->bind_param("sssssss", $name, $contact, $dob, $password, $confirmPassword,$cnic, $address);

if ($stmt->execute()) {
    echo "<script>alert('Sign up successfully!'); window.location.href='signup.html';</script>";
} else {
    echo "<script>alert('Error submitting request! Please try again.'); window.location.href='signup.html';</script>";
}

// Close connections
$stmt->close();
$conn->close();
?>

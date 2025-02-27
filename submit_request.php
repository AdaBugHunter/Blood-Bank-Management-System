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
$name = $_POST['name'];
$contact = $_POST['contact'];
$email = isset($_POST['email']) ? $_POST['email'] : null;
$blood_group = $_POST['blood_group'];
$urgency = $_POST['urgency'];
$message = isset($_POST['message']) ? $_POST['message'] : null;

// Prepare SQL statement
$sql = "INSERT INTO blood_requests (name, contact, email, blood_group, urgency, message) 
        VALUES (?, ?, ?, ?, ?, ?, NOW())";

$stmt = $conn->prepare($sql);
$stmt->bind_param("sssssss", $name, $contact, $email, $blood_group, $urgency,$message);

if ($stmt->execute()) {
    echo "<script>alert('Blood request submitted successfully!'); window.location.href='request_blood.html';</script>";
} else {
    echo "<script>alert('Error submitting request! Please try again.'); window.location.href='request_blood.html';</script>";
}

// Close connections
$stmt->close();
$conn->close();
?>

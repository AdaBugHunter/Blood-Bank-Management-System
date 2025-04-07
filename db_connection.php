<?php
$host = "localhost";       // XAMPP default
$db_user = "root";         // XAMPP default user
$db_password = "";         // XAMPP default has no password for root
$db_name = "blood_bank";   // Replace with your database name

// Create connection
$conn = new mysqli($localhost, $root, database:"blood_bank");

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
?>

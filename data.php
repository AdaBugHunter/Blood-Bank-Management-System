<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);

$con = mysqli_connect("localhost", "root", "", "blood_bank");

if (!$con) {
    die("Database connection failed: " . mysqli_connect_error());
}

if ($_SERVER["REQUEST_METHOD"] == "POST") 
{
    $name = $_POST['name'];
    $password = $_POST['password'];
    $cnic = $_POST['cnic'];
    $email = $_POST['email'];
    $phone =$_POST['phone'];
    $location = $_POST['location'];
    $gender = $_POST['gender'];
    $bloodtype = $_POST['blood-type'];
    $weight = $_POST['weight'];
    $medication = $_POST['medication'];
    $illness = $_POST['illness'];
    $recentTravel = $_POST['recent-travel'];
    $riskbehaviour = $_POST['risk-behaviour'];

    $sql = "INSERT INTO blood_donations (name, password, cnic, email, phone, gender, blood-type, weight, location, medication, illness, recent-travel ,risk-behaviour)
            VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";
    
    $stmt = mysqli_prepare($con, $sql);
    mysqli_stmt_bind_param($stmt, "ssssssssssssss", $name, $password, $cnic, $email, $$location, $phone, $bloodtype, $weight, $gender, $recentTravel, $riskbehaviour, $illness, $medication);
    
    if (mysqli_stmt_execute($stmt)) {
        echo "Registration Successful!";
    } else {
        echo "Error: " . mysqli_error($con);
    }
    
    mysqli_stmt_close($stmt);
}

mysqli_close($con);
?>

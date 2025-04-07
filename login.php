<?php
session_start();
require_once 'db_connection.php'; // Include DB connection

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $userType = $_POST['user_type']; // 'admin' or 'donor'
    
    if ($userType === 'admin') {
        $email = mysqli_real_escape_string($conn, $_POST['email']);
        $password = $_POST['password'];

        $sql = "SELECT * FROM admins WHERE email = '$email'";
        $result = mysqli_query($conn, $sql);

        if ($result && mysqli_num_rows($result) === 1) {
            $admin = mysqli_fetch_assoc($result);
            
            if (password_verify($password, $admin['password'])) {
                $_SESSION['admin_id'] = $admin['id'];
                $_SESSION['admin_email'] = $admin['email'];
                header("Location: admin.php");
                exit();
            } else {
                echo "❌ Incorrect password for admin.";
            }
        } else {
            echo "❌ Admin not found.";
        }

    } elseif ($userType === 'donor') {
        $cnic = mysqli_real_escape_string($conn, $_POST['cnic']);
        $password = $_POST['password'];

        $sql = "SELECT * FROM donors WHERE cnic = '$cnic'";
        $result = mysqli_query($conn, $sql);

        if ($result && mysqli_num_rows($result) === 1) {
            $donor = mysqli_fetch_assoc($result);

            if (password_verify($password, $donor['password'])) {
                $_SESSION['donor_id'] = $donor['id'];
                $_SESSION['donor_cnic'] = $donor['cnic'];
                header("Location: donor_dashboard.php");
                exit();
            } else {
                echo "❌ Incorrect password for donor.";
            }
        } else {
            echo "❌ Donor not found.";
        }
    } else {
        echo "❌ Invalid user type.";
    }
}
?>

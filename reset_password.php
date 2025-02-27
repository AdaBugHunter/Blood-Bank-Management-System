<?php
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $token = $_POST['token'];
    $new_password = password_hash($_POST['password'], PASSWORD_DEFAULT);

    // Database Connection
    $conn = new mysqli("localhost", "root", "", "blood_bank");

    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    // Verify Token and Reset Password
    $sql = "SELECT * FROM users WHERE reset_token='$token'";
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        $update = "UPDATE users SET password='$new_password', reset_token=NULL WHERE reset_token='$token'";
        $conn->query($update);
        echo "Password reset successfully!";
    } else {
        echo "Invalid or expired token.";
    }

    $conn->close();
}
?>

<!-- Reset Password Form -->
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Reset Password</title>
</head>
<body>
    <h2>Reset Password</h2>
    <form action="reset_password.php" method="POST">
        <input type="hidden" name="token" value="<?php echo $_GET['token']; ?>">
        <input type="password" name="password" placeholder="Enter new password" required>
        <button type="submit">Reset Password</button>
    </form>
</body>
</html>

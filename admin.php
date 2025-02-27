<?php
session_start();
include 'db_connect.php'; // Database connection file

// Fetch blood donation history
$donationHistory = mysqli_query($conn, "SELECT * FROM blood_donations");

// Fetch blood requests
$bloodRequests = mysqli_query($conn, "SELECT * FROM blood_requests WHERE status='Pending'");

// Fetch blood stock alerts
$lowStock = mysqli_query($conn, "SELECT * FROM blood_stock WHERE quantity < 5");
$expiryAlerts = mysqli_query($conn, "SELECT * FROM blood_stock WHERE expiry_date < NOW()");

// Fetch feedback
$feedbacks = mysqli_query($conn, "SELECT * FROM feedback");
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
</head>
<body>
    <div class="container mt-4">
        <h2 class="text-center">Admin Dashboard</h2>
        
        <!-- Blood Donation History -->
        <h4>Blood Donation History</h4>
        <table class="table table-bordered">
            <tr><th>Donor Name</th><th>Blood Type</th><th>Quantity</th><th>Date</th></tr>
            <?php while ($row = mysqli_fetch_assoc($donationHistory)) { ?>
                <tr><td><?php echo $row['donor_name']; ?></td><td><?php echo $row['blood_type']; ?></td><td><?php echo $row['quantity']; ?> units</td><td><?php echo $row['donation_date']; ?></td></tr>
            <?php } ?>
        </table>
        
        <!-- Blood Requests -->
        <h4>Blood Requests</h4>
        <table class="table table-bordered">
            <tr><th>Patient Name</th><th>Blood Type</th><th>Quantity</th><th>Action</th></tr>
            <?php while ($row = mysqli_fetch_assoc($bloodRequests)) { ?>
                <tr>
                    <td><?php echo $row['patient_name']; ?></td>
                    <td><?php echo $row['blood_type']; ?></td>
                    <td><?php echo $row['quantity']; ?> units</td>
                    <td>
                        <a href="approve_request.php?id=<?php echo $row['id']; ?>" class="btn btn-success">Approve</a>
                        <a href="reject_request.php?id=<?php echo $row['id']; ?>" class="btn btn-danger">Reject</a>
                    </td>
                </tr>
            <?php } ?>
        </table>
        
        <!-- Stock Alerts -->
        <h4>Stock Alerts</h4>
        <p class="text-danger">Low Stock:</p>
        <ul>
            <?php while ($row = mysqli_fetch_assoc($lowStock)) { echo "<li>{$row['blood_type']} - Only {$row['quantity']} units left</li>"; } ?>
        </ul>
        <p class="text-warning">Expiring Soon:</p>
        <ul>
            <?php while ($row = mysqli_fetch_assoc($expiryAlerts)) { echo "<li>{$row['blood_type']} - Expiry: {$row['expiry_date']}</li>"; } ?>
        </ul>
        
        <!-- Feedback Control -->
        <h4>Feedback</h4>
        <table class="table table-bordered">
            <tr><th>Donor Name</th><th>Feedback</th><th>Action</th></tr>
            <?php while ($row = mysqli_fetch_assoc($feedbacks)) { ?>
                <tr>
                    <td><?php echo $row['donor_name']; ?></td>
                    <td><?php echo $row['message']; ?></td>
                    <td>
                        <a href="delete_feedback.php?id=<?php echo $row['id']; ?>" class="btn btn-danger">Delete</a>
                    </td>
                </tr>
            <?php } ?>
        </table>
        
        <!-- Send Notification -->
        <h4>Send Notification</h4>
        <form action="send_notification.php" method="POST">
            <input type="text" name="donor_email" placeholder="Enter Donor Email" class="form-control mb-2" required>
            <textarea name="message" placeholder="Enter Message" class="form-control mb-2" required></textarea>
            <button type="submit" class="btn btn-primary">Send</button>
        </form>
    </div>
</body>
</html>
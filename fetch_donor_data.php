<?php
header('Content-Type: application/json');

// Dummy donor data (should be fetched from MySQL in real app)
$data = [
  "name" => "Ali Raza",
  "last_donation_date" => "2024-12-15",
  "medical_history" => [
    ["date" => "2024-09-10", "report" => "Healthy"],
    ["date" => "2024-12-15", "report" => "Fit for donation"]
  ],
  "pictures" => [
    "images/profile1.jpg",
    "images/profile2.jpg"
  ],
  "admin_notification" => "You are now eligible to donate blood again! Contact the nearest center."
];

echo json_encode($data);
?>

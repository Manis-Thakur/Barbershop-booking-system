<?php
session_start();

$conn = new mysqli("localhost", "root", "", "groomease");
if ($conn->connect_error) {
    die(json_encode(["error" => "Database connection failed"]));
}

// Make sure user is logged in
if (!isset($_SESSION['user_id'])) {
    echo json_encode([]);
    exit;
}

$userId = $_SESSION['user_id'];

$sql = "SELECT service_name, barber_name, booking_date, booking_time, status, payment_amount 
        FROM bookings 
        WHERE user_id = ?
        ORDER BY booking_date DESC";

$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $userId); 
$stmt->execute();
$result = $stmt->get_result();

$appointments = [];
while ($row = $result->fetch_assoc()) {
    $appointments[] = $row;
}

echo json_encode($appointments);
?>

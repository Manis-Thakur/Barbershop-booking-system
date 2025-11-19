<?php
$conn = new mysqli("localhost", "root", "", "groomease");
if ($conn->connect_error) {
    die(json_encode(["error" => "Database connection failed"]));
}

// Read date from GET
$selected_date = $_GET['date'] ?? '';

if ($selected_date === '') {
    echo json_encode([]);
    exit;
}

$sql = "SELECT booking_time FROM bookings WHERE booking_date = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("s", $selected_date);
$stmt->execute();
$result = $stmt->get_result();

$booked = [];

while ($row = $result->fetch_assoc()) {
    // Convert 24h (HH:MM:SS) → 12h (HH:MM AM/PM)
    $time = date("g:i A", strtotime($row['booking_time']));
    $booked[] = $time;
}

echo json_encode($booked);
?>

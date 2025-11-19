<?php
$conn = new mysqli("localhost", "root", "", "groomease");
if ($conn->connect_error) {
    die(json_encode(["error" => "DB connection failed"]));
}

$selected_date = $_GET['date'] ?? '';
$barber_id = $_GET['barber_id'] ?? '';

if ($selected_date === '' || $barber_id === '') {
    echo json_encode([]);
    exit;
}

$sql = "SELECT booking_time FROM bookings 
        WHERE booking_date = ? AND barber_id = ? AND status != 'Cancelled'";
$stmt = $conn->prepare($sql);
$stmt->bind_param("si", $selected_date, $barber_id);
$stmt->execute();
$result = $stmt->get_result();

$booked = [];

while ($row = $result->fetch_assoc()) {
    $time = date("g:i A", strtotime($row['booking_time']));
    $booked[] = $time;
}

echo json_encode($booked);
?>
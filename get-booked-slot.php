<?php
$conn = new mysqli("localhost", "root", "", "groomease");

if ($conn->connect_error) {
    die(json_encode(["error" => "Database connection failed"]));
}

$barber_id = $_GET['barber_id'] ?? '';
$selected_date = $_GET['date'] ?? '';

if ($barber_id === '' || $selected_date === '') {
    echo json_encode([]);
    exit;
}

$sql = "SELECT booking_time FROM bookings 
        WHERE barber_id = ? AND booking_date = ? AND status != 'cancelled'";

$stmt = $conn->prepare($sql);
$stmt->bind_param("is", $barber_id, $selected_date);
$stmt->execute();
$result = $stmt->get_result();

$booked = [];

while ($row = $result->fetch_assoc()) {
    // convert "HH:MM:SS" → "H:MM AM/PM"
    $timeFormatted = date("g:i A", strtotime($row['booking_time']));

    $booked[] = [
        "booking_date" => $selected_date,
        "booking_time" => $timeFormatted
    ];
}

echo json_encode($booked);
?>

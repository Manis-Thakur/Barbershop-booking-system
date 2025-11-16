<?php

$conn = new mysqli("localhost", "root", "", "groomease");
if ($conn->connect_error) {
    die(json_encode(["error" => "Database connection failed"]));
}



$barber_id = $_GET['barber_id'] ?? 0;

$sql = "SELECT booking_date, booking_time 
        FROM bookings 
        WHERE barber_id = ?";

$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $barber_id);
$stmt->execute();
$result = $stmt->get_result();

$booked = [];

while ($row = $result->fetch_assoc()) {
    $booked[] = $row;
}

echo json_encode($booked);
?>

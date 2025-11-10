<?php
$conn = new mysqli("localhost", "root", "", "groomease");
if ($conn->connect_error)
    die("Connection failed");

$result = $conn->query("SELECT service_name, barber_name, booking_date, booking_time, duration, price, status FROM bookings WHERE username='Manish Thakur' ORDER BY booking_date DESC");

$appointments = [];
while ($row = $result->fetch_assoc()) {
    $appointments[] = $row;
}
echo json_encode($appointments);
?>
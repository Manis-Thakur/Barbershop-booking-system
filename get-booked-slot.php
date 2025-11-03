<?php
$conn = new mysqli("localhost", "root", "", "groomease");
if ($conn->connect_error)
    die("Connection failed: " . $conn->connect_error);

if (isset($_GET['barber_name'])) {
    $barber = $_GET['barber_name'];
    $stmt = $conn->prepare("SELECT booking_date, booking_time FROM bookings WHERE barber_name = ? AND status != 'cancelled'");
    $stmt->bind_param("s", $barber);
    $stmt->execute();
    $result = $stmt->get_result();
    $booked = [];
    while ($row = $result->fetch_assoc())
        $booked[] = $row;
    echo json_encode($booked);
}
?>
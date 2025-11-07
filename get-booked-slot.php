<?php
$conn = new mysqli("localhost", "root", "", "groomease");
if ($conn->connect_error)
    die("Connection failed: " . $conn->connect_error);

if (isset($_GET['barber_name'])) {
    $barber = $_GET['barber_name'];

    // Format time for frontend comparison
    $stmt = $conn->prepare("
        SELECT 
            booking_date, 
            DATE_FORMAT(booking_time, '%l:%i %p') AS booking_time
        FROM bookings 
        WHERE barber_name = ? 
        AND status != 'cancelled'
    ");
    $stmt->bind_param("s", $barber);
    $stmt->execute();
    $result = $stmt->get_result();

    $booked = [];
    while ($row = $result->fetch_assoc()) {
        $booked[] = $row;
    }

    header('Content-Type: application/json');
    echo json_encode($booked);
}
?>

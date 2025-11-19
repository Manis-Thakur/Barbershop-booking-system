<?php
session_start();
$conn = new mysqli("localhost", "root", "", "groomease");
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    $user_id = $_SESSION['user_id'];

    $service_name = $_POST['service_name'];
    $barber_id = $_POST['barber_id'];
    $barber_name = $_POST['barber_name'];

    $booking_date = $_POST['booking_date'];
    $booking_time = date("H:i:s", strtotime($_POST['booking_time']));
    $payment_amount = $_POST['payment_amount'];

    // CHECK DOUBLE BOOKING PER BARBER
    $sql = "SELECT * FROM bookings 
            WHERE barber_id = ? AND booking_date = ? AND booking_time = ?
            AND status != 'Cancelled'";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("iss", $barber_id, $booking_date, $booking_time);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        echo "This slot is already booked.";
        exit;
    }

    // INSERT BOOKING
    $status = "Waiting for Confirmation";
    $payment_status = "Paid";

    $insert = "INSERT INTO bookings 
        (user_id, service_name, barber_id, barber_name, booking_date, booking_time, status, payment_amount, payment_status)
        VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?)";

    $stmt = $conn->prepare($insert);
    $stmt->bind_param("isissssds", $user_id, $service_name, $barber_id, $barber_name, $booking_date, $booking_time, $status, $payment_amount, $payment_status);

    if ($stmt->execute()) {
        header("Location: payment-success.php");
        exit;
    } else {
        echo "Error: " . $stmt->error;
    }
}
?>
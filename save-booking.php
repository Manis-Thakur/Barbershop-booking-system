<?php
session_start();
$conn = new mysqli("localhost", "root", "", "groomease");
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $user_id = $_SESSION['user_id'];
    $service_name = $_POST['service_name'];
    $barber_name = $_POST['barber_name'];
    $booking_date = $_POST['booking_date'];
    $booking_time = $_POST['booking_time'];
    $payment_amount = $_POST['payment_amount'];

    // Check for double booking
    $sql = "SELECT * FROM bookings WHERE barber_name = ? AND booking_date = ? AND booking_time = ? AND status != 'cancelled'";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("sss", $barber_name, $booking_date, $booking_time);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        echo "Sorry! This barber is already booked at this time. Please choose another slot.";
        exit;
    }

    // Insert booking
    $status = 'Confirmed';
    $payment_status = 'Paid';
    $created_at = date('Y-m-d H:i:s');

    $insert = "INSERT INTO bookings 
        (user_id, service_name, barber_name, booking_date, booking_time, status, created_at, payment_amount, payment_status)
        VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?)";
    $stmt = $conn->prepare($insert);
    $stmt->bind_param("isssssdss", $user_id, $service_name, $barber_name, $booking_date, $booking_time, $status, $created_at, $payment_amount, $payment_status);

    if ($stmt->execute()) {
        header("Location: payment-success.php");
        exit;
    } else {
        echo "Error: " . $stmt->error;
    }
}
?>
<?php
session_start();
$conn = new mysqli("localhost", "root", "", "groomease");

$user_id = $_SESSION['user_id'] ?? 0;

if (!isset($_GET['id'])) {
    echo "Invalid request.";
    exit;
}

$booking_id = intval($_GET['id']);

// verify booking belongs to this user
$check = $conn->query("SELECT * FROM bookings WHERE id = $booking_id AND user_id = $user_id");

if ($check->num_rows === 0) {
    echo "Unauthorized action!";
    exit;
}

// update status to canceled
$sql = "UPDATE bookings SET status = 'Cancelled' WHERE id = $booking_id";

if ($conn->query($sql)) {
    echo "Booking cancelled successfully.";
} else {
    echo "Failed to cancel booking.";
}
?>
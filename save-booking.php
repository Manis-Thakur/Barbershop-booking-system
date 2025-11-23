<?php
session_start();

$conn = new mysqli("localhost", "root", "", "groomease");
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    die("Invalid request method.");
}

$user_id = $_SESSION['user_id'] ?? null;
if (!$user_id) {
    die("You must be logged in to book.");
}

$service_name = trim($_POST['service_name'] ?? '');
$barber_id = !empty($_POST['barber_id']) ? intval($_POST['barber_id']) : null;
$barber_name = trim($_POST['barber_name'] ?? '');
$booking_date = trim($_POST['booking_date'] ?? '');
$booking_time_i = trim($_POST['booking_time'] ?? '');
$payment_amount = floatval($_POST['payment_amount'] ?? 0);

if ($service_name === '' || $booking_date === '' || $booking_time_i === '' || $payment_amount <= 0) {
    die("Missing required booking fields.");
}

$booking_time = date("H:i:s", strtotime($booking_time_i));
if ($booking_time === false) {
    die("Invalid time format.");
}

// === Resolve barber_id from barber_name if not provided ===
if (!$barber_id && $barber_name !== '') {
    $q = $conn->prepare("SELECT id FROM barbers WHERE name = ? LIMIT 1");
    $q->bind_param("s", $barber_name);
    $q->execute();
    $q->bind_result($found_id);
    if ($q->fetch()) {
        $barber_id = (int) $found_id;
    }
    $q->close();
}

// === Determine which field to use for conflict check ===
$check_sql = $barber_id
    ? "SELECT id FROM bookings WHERE barber_id = ? AND booking_date = ? AND booking_time = ? AND status != 'Cancelled'"
    : "SELECT id FROM bookings WHERE barber_name = ? AND booking_date = ? AND booking_time = ? AND status != 'Cancelled'";

$stmt = $conn->prepare($check_sql);
if (!$stmt)
    die("Prepare failed (check): " . $conn->error);

if ($barber_id) {
    $stmt->bind_param("iss", $barber_id, $booking_date, $booking_time);
} else {
    $stmt->bind_param("sss", $barber_name, $booking_date, $booking_time);
}

$stmt->execute();
$stmt->store_result();
if ($stmt->num_rows > 0) {
    $stmt->close();
    die("Sorry! This slot is already booked. Please choose another time.");
}
$stmt->close();

// === Insert the booking ===
// Always prefer barber_id if available. Only fall back to barber_name.
$status = 'Waiting for Confirmation';
$payment_status = 'Paid';

if ($barber_id) {
    // Normal case: we have barber_id → store both, barber_name optional but nice for display
    $sql = "INSERT INTO bookings 
            (user_id, service_name, barber_id, barber_name, booking_date, booking_time, status, payment_amount, payment_status)
            VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?)";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param(
        "isissssds",
        $user_id,
        $service_name,
        $barber_id,
        $barber_name,
        $booking_date,
        $booking_time,
        $status,
        $payment_amount,
        $payment_status
    );
} else {
    // Rare fallback: no barber_id found → store only barber_name, barber_id = NULL
    $sql = "INSERT INTO bookings 
            (user_id, service_name, barber_id, barber_name, booking_date, booking_time, status, payment_amount, payment_status)
            VALUES (?, ?, NULL, ?, ?, ?, ?, ?, ?)";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param(
        "isssssdss",
        $user_id,
        $service_name,
        $barber_name,
        $booking_date,
        $booking_time,
        $status,
        $payment_amount,
        $payment_status
    );
}

if ($stmt->execute()) {
    header("Location: payment-success.php");
    exit;
} else {
    die("Booking failed: " . $stmt->error);
}
?>
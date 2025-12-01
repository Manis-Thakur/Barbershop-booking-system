<?php
$conn = new mysqli("localhost", "root", "", "groomease");
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$sql = "SELECT b.id, u.email, b.service_name, b.booking_date, b.booking_time
        FROM bookings b
        JOIN users u ON b.user_id = u.id
        WHERE b.reminder_sent = 0
        AND b.reminder_time <= NOW()";

$result = $conn->query($sql);

if ($result && $result->num_rows > 0) {

    while ($row = $result->fetch_assoc()) {

        $email = $row['email'];
        $service = $row['service_name'];
        $date = $row['booking_date'];
        $time = $row['booking_time'];

        $subject = "GroomEase Appointment Reminder";
        $message = "Hello!

This is a reminder for your GroomEase appointment.

Service: $service
Date: $date
Time: $time

Thank you for choosing GroomEase!";

        $headers = "From: no-reply@groomease.com";

        // SEND EMAIL (Will not work on XAMPP without SMTP)
        mail($email, $subject, $message, $headers);

        $conn->query("UPDATE bookings SET reminder_sent = 1 WHERE id = {$row['id']}");
    }

} else {
    echo "No reminders to send.";
}

echo "Cron executed.";
?>
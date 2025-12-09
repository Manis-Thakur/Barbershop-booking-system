<?php
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require 'PHPMailer-master/src/Exception.php';
require 'PHPMailer-master/src/PHPMailer.php';
require 'PHPMailer-master/src/SMTP.php';


// Database connection
$conn = new mysqli("localhost", "root", "", "groomease");
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Get bookings where reminder is not sent and reminder_time <= now
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
        $message = "Hello!\n\nThis is a reminder for your GroomEase appointment.\n\nService: $service\nDate: $date\nTime: $time\n\nThank you for choosing GroomEase!";

        // PHPMailer
        $mail = new PHPMailer(true);
        try {
            $mail->isSMTP();
            $mail->Host = 'smtp.gmail.com';
            $mail->SMTPAuth = true;
            $mail->Username = 'manisthakur2004@gmail.com';
            $mail->Password = 'jako vtmi swaj hink';
            $mail->SMTPSecure = 'tls';
            $mail->Port = 587;

            $mail->setFrom('manisthakur2004@gmail.com', 'GroomEase');
            $mail->addAddress($email);

            $mail->isHTML(false);
            $mail->Subject = $subject;
            $mail->Body = $message;

            $mail->send();

            // Mark reminder as sent
            $conn->query("UPDATE bookings SET reminder_sent = 1 WHERE id = {$row['id']}");

            echo "Reminder sent to $email\n";
        } catch (Exception $e) {
            echo "Mailer Error for $email: {$mail->ErrorInfo}\n";
        }
    }
} else {
    echo "No reminders to send.\n";
}

echo "Cron executed.\n";
?>
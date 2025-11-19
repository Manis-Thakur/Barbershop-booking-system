<?php
session_start();

// Optional: Protect page — only logged-in users can confirm booking
if (!isset($_SESSION['user_id'])) {
    header("Location: signin.html");
    exit();
}

$user_name = $_SESSION['fullname'] ?? '';
$phone = $_SESSION['phone'] ?? '';
?>

<!DOCTYPE html>
<html>

<head>
    <title>Payment Successful</title>
    <style>
        body {
            font-family: 'Segoe UI', sans-serif;
            margin: 0;
            background-color: #faf7f2;
            color: #4d2e14;
            text-align: center;
            display: block;
            /* Remove flex centering */
        }

        .navbar {
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 30px 8%;
            background-color: #fff;
            border-bottom: 1px solid #eee;
        }

        .logo {
            display: flex;
            align-items: center;
            gap: 12px;
        }

        .logo-icon {
            background-color: #5a2e0f;
            color: #fff;
            font-size: 22px;
            padding: 8px 15px;
            border-radius: 8px;
        }

        .logo h2 {
            margin: 0;
            font-size: 20px;
        }

        .logo p {
            margin: 0;
            font-size: 13px;
            color: #6d5f4b;
        }

        .nav-buttons a {
            text-decoration: none;
            font-size: 14px;
            margin-left: 10px;
            padding: 8px 16px;
            border-radius: 8px;
            border: 1px solid #5a2e0f;
        }

        .btn-light {
            background-color: #fff;
            color: #5a2e0f;
        }

        .btn-dark {
            background-color: #5a2e0f;
            color: #fff;
        }

        h1 {
            font-size: 32px;
        }

        p {
            font-size: 18px;
        }

        a {
            display: inline-block;
            margin-top: 20px;
            padding: 10px 20px;
            background: #623817;
            color: #fff;
            border-radius: 8px;
            text-decoration: none;
        }

        .main-content {
            display: flex;
            flex-direction: column;
            justify-content: center;
            align-items: center;
            min-height: calc(100vh - 100px);
            /* full viewport minus navbar height */
            text-align: center;
        }

        .container {
            background-color: #fffaf3;
            border: 1px solid #e0d9cc;
            border-radius: 12px;
            padding: 25px 35px;
            width: 360px;
            box-shadow: 0 2px 6px rgba(0, 0, 0, 0.05);
        }

        .appointment-card h2 {
            text-align: center;
            margin-top: 0;
            margin-bottom: 20px;
            font-size: 18px;
            font-weight: 600;
        }

        .details p,
        .payment p {
            display: flex;
            justify-content: space-between;
            margin: 8px 0;
            font-size: 15px;
            color: #333;
        }

        .details span,
        .payment span {
            font-weight: 600;
            color: #222;
        }

        hr {
            border: none;
            border-top: 1px solid #e0d9cc;
            margin: 15px 0;
        }

        .paid {
            color: #2a9d48;
        }

        .due {
            color: #d9534f;
        }

        @media (max-width: 420px) {
            .appointment-card {
                width: 90%;
                padding: 20px;
            }
        }
    </style>
</head>

<body>
    <!-- Navbar -->
    <header class="navbar">
        <div class="logo">
            <div class="logo-icon">✂</div>
            <div>
                <h2>GroomEase</h2>
                <p>Book Your Appointment</p>
            </div>
        </div>
        <div class="nav-buttons">
            <?php if (!empty($user_name)): ?>
                <span>👋 Hi, <?php echo htmlspecialchars($user_name); ?></span>
                <a href="logout.php" class="btn-light">← Back to Home</a>
            <?php else: ?>
                <a href="index.php" class="btn-light">← Back to Home</a>
                <a href="signin.html" class="btn-light">Sign In</a>
                <a href="signup.html" class="btn-dark">Sign Up</a>
            <?php endif; ?>
        </div>
    </header>
    <div class="main-content">
        <h1>🎉 Payment Successful!</h1>
        <p>Your booking has been confirmed. We’ll see you soon.</p>
        <div class="container">
            <h3>Appointment details</h3>
            <div class="details">
                <p id="service-name"><span>Service: </span></p>
                <p id="barber-name"><span>Barber: </span></p>
                <p id="date"><span>Date: </span></p>
                <p id="time"><span>Time: </span></p>
                <p id="duration"><span>Duration: </span></p>
            </div>
            <hr>
            <div class="payment">
                <p id="totalAmount"><span>Total Amount:</span></p>
                <p class="paid"><span>Deposit paid:</span></p>
            </div>
        </div>
        <a href="index.php">Return Home</a>
    </div>
</body>

<script>
    document.getElementById('service-name').innerHTML += `<span>${localStorage.getItem('selectedService')}</span>`;
    document.getElementById('barber-name').innerHTML += `<span>${localStorage.getItem('selectedBarber')}</span>`;
    document.getElementById('date').innerHTML += `<span>${localStorage.getItem('bookingDate')}</span>`;
    document.getElementById('time').innerHTML += `<span>${localStorage.getItem('bookingTime')}</span>`;
    document.getElementById('duration').innerHTML += `<span>${localStorage.getItem('selectedDuration')}</span>`;

    document.getElementById('totalAmount').innerHTML += `<span>${localStorage.getItem('selectedPrice')}</span>`;
    document.querySelector('.paid').innerHTML += `<span>${localStorage.getItem('paymentAmount')}</span>`;


</script>

</html>
<?php
session_start();

// Optional: Protect page — only logged-in users can confirm booking
if (!isset($_SESSION['user_id'])) {
    header("Location: signin.html");
    exit();
}

$user_name = $_SESSION['fullname'] ?? '';
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Your Information | GroomEase</title>

    <style>
        body {
            font-family: 'Segoe UI', sans-serif;
            background: #faf6ef;
            margin: 0;
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

        .container {
            width: 700px;
            max-width: 90%;
            margin: 60px auto;
            background: #fff;
            padding: 30px;
            border-radius: 15px;
            box-shadow: 0 4px 20px rgba(0, 0, 0, 0.08);
        }

        .steps {
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 20px;
            margin-bottom: 40px;
            padding: 20px 0px;
        }

        .step {
            display: flex;
            align-items: center;
            gap: 10px;
        }

        .circle {
            width: 32px;
            height: 32px;
            border-radius: 50%;
            background-color: #5a2d1a;
            color: #fff;
            display: flex;
            align-items: center;
            justify-content: center;
            font-weight: bold;
        }

        .circle.inactive {
            background-color: #e0d9cf;
            color: #a7a099;
        }

        .line {
            width: 40px;
            height: 3px;
            background-color: #e0d9cf;
        }

        h1 {
            text-align: center;
            margin-top: 25px;
        }

        p.subtitle {
            text-align: center;
            color: #777;
            margin-bottom: 20px;
        }

        label {
            font-size: 15px;
            font-weight: 600;
            color: #3a2c20;
            display: block;
            margin: 12px 0 6px;
        }

        input,
        textarea {
            width: 100%;
            padding: 12px;
            border-radius: 6px;
            border: 1px solid #ddd;
            font-size: 15px;
        }

        textarea {
            resize: none;
            height: 90px;
        }

        .row {
            display: flex;
            gap: 18px;
        }

        button {
            width: 100%;
            background: #623817;
            color: #fff;
            border: none;
            padding: 15px;
            font-size: 16px;
            border-radius: 6px;
            cursor: pointer;
            font-weight: 600;
            margin-top: 25px;
        }

        button:hover {
            background: #4d2e14;
        }

        .back-btn {
            text-align: center;
            margin-top: 24px;
        }

        .back-btn a {
            background: #fff;
            padding: 10px 18px;
            border-radius: 6px;
            border: 1px solid #c7b9a5;
            color: #4d2e14;
            text-decoration: none;
            font-weight: 600;
        }

        .summary {
            font-size: 15px;
            margin-bottom: 15px;
            color: #6b4a29;
        }

        .summary strong {
            color: #000;
        }
    </style>
</head>

<body>
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

    <div class="steps">
        <div class="step">
            <div class="circle">1</div>
            <div class="line"></div>
        </div>
        <div class="step">
            <div class="circle">2</div>
            <div class="line"></div>
        </div>
        <div class="step">
            <div class="circle">3</div>
            <div class="line"></div>
        </div>
        <div class="step">
            <div class="circle">4</div>
            <div class="line"></div>
        </div>
        <div class="step">
            <div class="circle inactive">5</div>
        </div>
    </div>

    <h1>Your Information</h1>
    <p class="subtitle">Confirm your details below</p>

    <div class="container">
        <p id="bookingSummary" class="summary"><strong>Booking Summary</strong><br>Loading your booking details...</p>

        <form id="confirmationForm" action="payment.php" method="POST">
            <div class="row">
                <div style="flex:1">
                    <label>Full Name *</label>
                    <input type="text" name="fullname" id="fullname"
                        value="<?php echo htmlspecialchars($_SESSION['fullname'] ?? ''); ?>" required>
                </div>
                <div style="flex:1">
                    <label>Phone Number *</label>
                    <input type="text" name="phone" id="phone" required>
                </div>
            </div>

            <label>Email Address *</label>
            <input type="email" name="email" id="email"
                value="<?php echo htmlspecialchars($_SESSION['email'] ?? ''); ?>" required>

            <label>Special Requests (Optional)</label>
            <textarea name="notes" placeholder="Any special requests or notes for your barber..."></textarea>

    

            <button type="submit">Continue to Payment</button>
        </form>

        <div class="back-btn">
            <a href="booking3.php">Back to Date & Time</a>
        </div>
    </div>

    <script>

        // Update summary text
        const summary = document.getElementById("bookingSummary");
        if (service && barber && date && time) {
            summary.innerHTML = `<strong>Booking Summary</strong><br>
                ${service} with ${barber} on ${date} at ${time}`;
        } else {
            summary.textContent = "Booking details missing. Please go back and select again.";
        }

        // Fill hidden inputs for form submission
        document.getElementById("service_name").value = service;
        document.getElementById("barber_name").value = barber;
        document.getElementById("booking_date").value = date;
        document.getElementById("booking_time").value = time;
    </script>

</body>

</html>
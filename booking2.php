<?php
session_start();

// You can display the user's name in navbar if logged in
$user_name = $_SESSION['fullname'] ?? '';
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Choose Barber</title>

    <style>
        body {
            font-family: "Segoe UI", sans-serif;
            background: #fcf9f2;
            margin: 0;
            padding: 0;
            text-align: center;
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

        /* Step Progress */
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
            margin-top: 40px;
            font-size: 36px;
            color: #4b2e19;
        }

        .selected {
            margin: 10px 0;
            font-size: 16px;
            color: #555;
        }

        .barber-container {
            display: flex;
            justify-content: center;
            gap: 30px;
            margin: 40px auto;
            max-width: 1100px;
            flex-wrap: wrap;
        }

        .barber-card {
            background: white;
            padding: 30px;
            border-radius: 12px;
            width: 300px;
            box-shadow: 0 2px 8px rgba(0, 0, 0, 0.1);
            cursor: pointer;
            transition: transform 0.3s ease, box-shadow 0.3s ease;
        }

        .barber-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 4px 16px rgba(0, 0, 0, 0.2);
        }

        .barber-title {
            font-size: 20px;
            font-weight: 600;
            margin-bottom: 10px;
        }

        .barber-service,
        .barber-exp {
            font-size: 14px;
            color: #666;
            margin: 5px 0;
        }

        .back-btn {
            margin-top: 30px;
            padding: 12px 30px;
            text-decoration: none;
            border-radius: 8px;
            background: #4b2e19;
            color: #fff;
            border: none;
            cursor: pointer;
            font-size: 16px;
            transition: 0.3s;
        }

        .back-btn:hover {
            background: #2e1a0e;
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


    <!-- Step Progress -->
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
            <div class="circle inactive">3</div>
            <div class="line"></div>
        </div>
        <div class="step">
            <div class="circle inactive">4</div>
            <div class="line"></div>
        </div>
        <div class="step">
            <div class="circle inactive">5</div>
        </div>
    </div>

    <h1>Choose Your Barber</h1>
    <p class="selected">Selected: <strong>Classic Haircut</strong></p>

    <div class="barber-container">
        <div class="barber-card" id="barber-card">
            <div class="barber-title">Barber One</div>
            <div class="barber-service">Haircuts</div>
            <div class="barber-exp">5 years</div>
        </div>

        <div class="barber-card" id="barber-card">
            <div class="barber-title">Barber Two</div>
            <div class="barber-service">Beard Trims</div>
            <div class="barber-exp">3 years</div>
        </div>

        <div class="barber-card" id="barber-card">
            <div class="barber-title">Barber Three</div>
            <div class="barber-service">Styling</div>
            <div class="barber-exp">4 years</div>
        </div>
    </div>

    <a href="Booking.html" class="back-btn">Back to Services</a>
</body>

<script>
    document.querySelectorAll(".barber-card").forEach(card => {
        card.addEventListener("click", () => {
            const barber = card.querySelector(".barber-title").innerText;
            localStorage.setItem("barber", barber);
            window.location.href = "booking3.php";
        });
    });

</script>


</html>
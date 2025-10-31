<?php
session_start();

// Optional: Redirect user if not logged in
if (!isset($_SESSION['user_id'])) {
    header("Location: login.html?error=Please login to book a service");
    exit();
}

// You can display the user's name in navbar if logged in
$user_name = $_SESSION['fullname'] ?? '';
?>



<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>GroomEase | Choose Service</title>
    <style>
        body {
            font-family: "Segoe UI", sans-serif;
            margin: 0;
            background-color: #fdf8f2;
            color: #2d1b0d;
        }

        /* Navbar */
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

        /* Steps */
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

        /* Service Section */
        .services {
            text-align: center;
            padding: 30px 8%;
        }

        .services h1 {
            font-size: 2rem;
            margin-bottom: 8px;
        }

        .services p {
            color: #6d5f4b;
            margin-bottom: 40px;
        }

        .service-grid {
            display: flex;
            justify-content: center;
            flex-wrap: wrap;
            gap: 30px;
        }

        .card {
            background: #fff;
            border-radius: 14px;
            box-shadow: 0 2px 6px rgba(0, 0, 0, 0.05);
            overflow: hidden;
            width: 300px;
            transition: 0.3s ease;
        }

        .card:hover {
            transform: translateY(-6px);
            cursor: pointer;
        }

        .card img {
            width: 100%;
            height: 190px;
            object-fit: contain;
        }

        .card-body {
            padding: 15px;
        }

        .card-body h3 {
            margin: 0 0 10px;
            font-size: 18px;
        }

        .card-info {
            display: flex;
            justify-content: space-between;
            color: #6d5f4b;
        }

        .price {
            background-color: #f5ede5;
            color: #5a2e0f;
            padding: 3px 10px;
            border-radius: 8px;
            font-weight: 600;
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

    <!-- Step Indicator -->
    <div class="steps">
        <div class="step">
            <div class="circle">1</div>
            <div class="line"></div>
        </div>
        <div class="step">
            <div class="circle inactive">2</div>
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

    <!-- Service Selection -->
    <section class="services">
        <h1>Choose Your Service</h1>
        <p>Select the service you'd like to book</p>

        <div class="service-grid" id="service-grid">
            <div class="card">
                <img src="images/classich.jpg   " alt="Classic Haircut">
                <div class="card-body">
                    <h3>Classic Haircut</h3>
                    <div class="card-info">
                        <span>⏱️ 30 minutes</span>
                        <span class="price">₹250</span>
                    </div>
                </div>
            </div>

            <div class="card" id="service-grid">
                <img src="images/beard.jpg" alt="Beard Trim">
                <div class="card-body">
                    <h3>Beard Trim</h3>
                    <div class="card-info">
                        <span>⏱️ 20 minutes</span>
                        <span class="price">₹150</span>
                    </div>
                </div>
            </div>

            <div class="card" id="service-grid">
                <img src="images/cut and beard.webp" alt="Cut & Beard Combo">
                <div class="card-body">
                    <h3>Cut & Beard Combo</h3>
                    <div class="card-info">
                        <span>⏱️ 45 minutes</span>
                        <span class="price">₹500</span>
                    </div>
                </div>
            </div>
            <div class="card" id="service-grid">
                <img src="images/haircolor.jpg" alt="hair color">
                <div class="card-body">
                    <h3>Hair Colour</h3>
                    <div class="card-info">
                        <span>⏱️ 45 minutes</span>
                        <span class="price">₹1,500</span>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <script>
        document.getElementById('service-grid').addEventListener('click', function (e) {
            let card = e.target.closest('.card');
            if (card) {
                let serviceName = card.querySelector('h3').innerText;
                // Store selected service in localStorage
                localStorage.setItem('selectedService', serviceName);
                // Redirect to the next booking step
                window.location.href = 'booking2.php';
            }
        }); x
    </script>

</body>

</html>
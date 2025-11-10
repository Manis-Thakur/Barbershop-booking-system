<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Payment</title>

    <style>
        body {
            font-family: 'Segoe UI', sans-serif;
            background: #faf6ef;
            margin: 0;
            padding-bottom: 50px;
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
            text-align: center;
            margin-top: 40px;
            font-size: 32px;
        }

        p.subtitle {
            text-align: center;
            color: #6e6a64;
            margin-bottom: 35px;
        }

        .payment-cards {
            display: flex;
            justify-content: center;
            gap: 25px;
            margin-bottom: 35px;
        }

        .card {
            width: 210px;
            padding: 20px;
            background: #fff;
            border-radius: 12px;
            text-align: center;
            border: 2px solid #e4d9ca;
        }

        .card.active {
            background: #f0e3d4;
            border-color: #70401b;
        }

        .card h3 {
            font-size: 15px;
            margin: 0;
            color: #4d3828;
        }

        .card .amount {
            font-size: 28px;
            font-weight: bold;
            margin-top: 10px;
            color: #000;
        }

        .card .small-text {
            font-size: 13px;
            color: #6e6a64;
        }

        .container {
            width: 700px;
            max-width: 90%;
            background: #fff;
            padding: 25px;
            margin: auto;
            border-radius: 15px;
            box-shadow: 0 4px 20px rgba(0, 0, 0, 0.08);
        }

        .section-title {
            display: flex;
            align-items: center;
            font-weight: 700;
            font-size: 18px;
            margin-bottom: 10px;
        }

        label {
            font-size: 14px;
            font-weight: 600;
            margin: 10px 0 6px;
            display: block;
        }

        input {
            width: 100%;
            padding: 12px;
            border-radius: 6px;
            border: 1px solid #ddd;
            font-size: 15px;
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
            padding: 14px;
            border-radius: 6px;
            font-size: 17px;
            cursor: pointer;
            margin-top: 22px;
            font-weight: 600;
        }

        button:hover {
            background: #4d2e14;
        }

        .back-btn {
            margin-top: 18px;
            text-align: center;
        }

        .back-btn a {
            font-size: 14px;
            text-decoration: none;
            color: #6b4a29;
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
            <a href="index.html" class="btn-light">← Back to Home</a>
            <a href="signin.html" class="btn-light">Sign In</a>
            <a href="signup.html" class="btn-dark">Sign Up</a>
        </div>
    </header>

    <h1>Payment</h1>
    <p class="subtitle">Complete your partial payment to secure your appointment</p>

    <div class="payment-cards">

        <div class="card">
            <h3>Total Amount</h3>
            <div class="amount" id="choosedPrice">₹800</div>
        </div>

        <div class="card active">
            <h3>Deposit (50%)</h3>
            <div class="amount"></div>
        </div>

        <div class="card">
            <h3>Balance Due</h3>
            <div class="amount" id="due"></div>
            <div class="small-text">Due at appointment</div>
        </div>

    </div>

    <div class="container">
        <div class="section-title">
            💳 Payment Details
        </div>
        <p style="color:#6e6a64; font-size:14px;">Enter your card information to complete the deposit payment</p>

        <form action="save-booking.php" method="POST">

            <label> Name *</label>
            <input type="text" placeholder="Abaya Rana Magar" required>

            <label>Esewa ID *</label>
            <input type="text" maxlength="19" placeholder="9812345678" required>

            <div class="row">
                <div style="flex:1">
                    <label>Esewa MPIN *</label>
                    <input type="text" placeholder="MM/YY" maxlength="5" required>
                </div>

            </div>
            <input type="hidden" name="service_name" value="" id="service_name_input">
            <input type="hidden" name="barber_name" value="" id="barber_name_input">
            <input type="hidden" name="booking_date" value="" id="booking_date_input">
            <input type="hidden" name="booking_time" value="" id="booking_time_input">
            <input type="hidden" name="payment_amount" value="" id="payment_amount_input">

            <button type="submit"></button>
        </form>

        <div class="back-btn">
            <a href="confirmation.php">← Go Back</a>
        </div>
    </div>

    <script>



        let displayPrice = document.getElementById('choosedPrice');
        displayPrice.innerText = localStorage.getItem('selectedPrice');

        let partialAmount = parseFloat(localStorage.getItem('selectedPrice').replace('₹', '').replace(',', '')) / 2;
        document.querySelector('.card.active .amount').innerText = `₹${partialAmount.toFixed(0)}`;
        document.getElementById('due').innerText = `₹${partialAmount.toFixed(0)}`;
        document.querySelector('button').innerText = `Pay ₹${partialAmount.toFixed(0)} Now`;
        localStorage.setItem('paymentAmount', partialAmount);

        // Store the amount in hidden input (so PHP can get it)
        document.getElementById('service_name_input').value = localStorage.getItem('selectedService');
        document.getElementById('barber_name_input').value = localStorage.getItem('selectedBarber');
        document.getElementById('booking_date_input').value = localStorage.getItem('bookingDate');
        document.getElementById('booking_time_input').value = localStorage.getItem('bookingTime');
        document.getElementById('payment_amount_input').value = localStorage.getItem('paymentAmount');
    </script>

</body>

</html>
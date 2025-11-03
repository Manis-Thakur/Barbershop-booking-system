<!DOCTYPE html>
<html>

<head>
    <title>Payment Successful</title>
    <style>
        body {
            font-family: 'Segoe UI', sans-serif;
            display: flex;
            flex-direction: column;
            justify-content: center;
            align-items: center;
            height: 100vh;
            margin: 0;
            background-color: #faf7f2;
            color: #4d2e14;
            text-align: center;
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
</body>

<script>
    document.getElementById('service-name').innerHTML += `<span>${localStorage.getItem('selectedService')}</span>`;
    document.getElementById('barber-name').innerHTML += `<span>${localStorage.getItem('selectedBarber')}</span>`;
    document.getElementById('date').innerHTML += `<span>${localStorage.getItem('bookingDate')}</span>`;
    document.getElementById('time').innerHTML += `<span>${localStorage.getItem('bookingTime')}</span>`;
    document.getElementById('duration').innerHTML += `<span>${localStorage.getItem('selectedDuration')}</span>`;

    document.getElementById('totalAmount').innerHTML += `<span>${localStorage.getItem('selectedPrice')}</span>`;
    document.querySelector('.paid').innerHTML += `<span>₹${localStorage.getItem('paymentAmount')}</span>`;
    
    
    </script>

</html>
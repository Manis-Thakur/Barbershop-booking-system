<?php
session_start();
$user_name = $_SESSION['fullname'] ?? '';
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>My Appointments | GroomEase</title>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;600&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined" />
    <style>
        body {
            font-family: 'Inter', sans-serif;
            margin: 0;
            background-color: #fdf8f2;
            color: #2d1b0d;
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

        main {
            text-align: center;
            padding: 3rem 1rem;
        }

        main h2 {
            font-size: 2rem;
            margin-bottom: 0.3rem;
        }

        main p {
            color: #6a5543;
        }

        .appointments-container {
            display: flex;
            flex-direction: column;
            align-items: center;
            margin-top: 2rem;
        }

        .appointment-card {
            background-color: #fff;
            border-radius: 15px;
            box-shadow: 0 2px 6px rgba(0, 0, 0, 0.1);
            padding: 1.5rem 2rem;
            width: 80%;
            max-width: 800px;
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 1rem;
        }

        .appointment-left {
            display: flex;
            align-items: center;
            gap: 1.2rem;
        }

        .appointment-left img {
            width: 45px;
            height: 45px;
            background-color: #f4ece2;
            border-radius: 12px;
            padding: 8px;
        }

        .appointment-details {
            text-align: left;
        }

        .appointment-details h3 {
            margin: 0;
            font-size: 1.1rem;
            color: #3b240c;
        }

        .appointment-details p {
            margin: 3px 0;
            font-size: 0.9rem;
            color: #6a5543;
        }

        .appointment-right {
            text-align: right;
        }

        .status {
            display: inline-block;
            background-color: #fff4b3;
            color: #856404;
            font-size: 0.8rem;
            padding: 4px 10px;
            border-radius: 8px;
            margin-bottom: 5px;
        }

        .price {
            font-size: 1.2rem;
            font-weight: bold;
        }

        .back-btn {
            margin-top: 2rem;
            background-color: #3b240c;
            color: white;
            padding: 10px 25px;
            border: none;
            border-radius: 10px;
            cursor: pointer;
            font-size: 1rem;
        }

        .cancel-btn {
            margin-top: 8px;
            background-color: #ff4d4d;
            color: white;
            padding: 6px 12px;
            border: none;
            border-radius: 8px;
            cursor: pointer;
            font-size: 0.85rem;
        }

        .cancel-btn:hover {
            background-color: #e63939;
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
            <?php else: ?>
                <a href="signin.html" class="btn-light">Sign In</a>
                <a href="signup.html" class="btn-dark">Sign Up</a>
            <?php endif; ?>
        </div>
    </header>

    <main>
        <h2>My Appointments</h2>
        <p>Your booking history and upcoming appointments</p>

        <div class="appointments-container" id="appointments-container">
            <!-- Appointments will load here -->
        </div>

        <button class="back-btn" onclick="window.location.href='index.php'">Back to Home</button>
    </main>



    <script>
        // Fetch appointments dynamically
        fetch("get-appointment.php")
            .then(res => res.json())
            .then(data => {
                const container = document.getElementById("appointments-container");
                if (data.length === 0) {
                    container.innerHTML = "<p>No appointments found.</p>";
                    return;
                }

                data.forEach(app => {
                    const div = document.createElement("div");
                    div.className = "appointment-card";
                    div.innerHTML = div.innerHTML = `
    <div class="appointment-left">
        <div><span class="material-symbols-outlined">
content_cut
</span></div>

        <div class="appointment-details">
            <h3>${app.service_name}</h3>
            <p>with ${app.barber_name}</p>
            <p>${app.booking_date} &nbsp;&nbsp; ${app.booking_time}</p>
            
        </div>
    </div>
  <div class="appointment-right">
    <span class="status">${app.status}</span>
    <div class="price">₹${app.payment_amount}</div>

    ${app.status === "Confirmed" || app.status === "Pending"
                            ? `<button class="cancel-btn" onclick="cancelBooking(${app.id})">Cancel</button>`
                            : `<small style="color:#999;">Not cancellable</small>`}
</div>

`;
                    container.appendChild(div);
                });
            })
            .catch(err => console.error(err));

        function cancelBooking(id) {
            if (!confirm("Are you sure you want to cancel this appointment?")) return;

            fetch("cancel-booking.php?id=" + id, { method: "GET" })
                .then(res => res.text())
                .then(response => {
                    alert(response);
                    location.reload();
                })
                .catch(err => console.error(err));
        }


    </script>
</body>

</html>
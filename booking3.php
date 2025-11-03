<?php
session_start();

// You can display the user's name in navbar if logged in
$user_name = $_SESSION['fullname'] ?? '';
?>


<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Select Date & Time</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/flatpickr/dist/flatpickr.min.css">
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

        h1 {
            font-size: 2rem;
            font-weight: 700;
            color: #2e1a11;
            margin-bottom: 5px;
        }

        h3 {
            margin-bottom: 15px;
        }

        .subtitle {
            color: #7b6b5d;
            font-size: 1rem;
            margin-bottom: 40px;
        }

        .main-wrapper {
            display: flex;
            gap: 40px;
            flex-wrap: wrap;
            justify-content: center;
        }

        .box {
            background-color: #fff;
            padding: 30px 40px;
            border-radius: 20px;
            box-shadow: 0 2px 8px rgba(0, 0, 0, 0.08);
            min-width: 340px;
        }

        /* Calendar Styles */

        .calendar {
            width: 100%;
            font-size: 1rem;
            border: 1px solid #e2d4c3;
            border-radius: 8px;
            padding: 10px;
            background-color: #f6f0e6;

        }

        /* Time Slots */
        .time-slots {
            display: grid;
            grid-template-columns: repeat(3, 100px);
            gap: 12px;
            justify-content: center;
            margin-top: 10px;
        }

        .time-slot {
            background-color: #f6f0e6;
            border: 1px solid #e2d4c3;
            border-radius: 8px;
            padding: 10px;
            text-align: center;
            cursor: pointer;
            transition: 0.2s;
        }

        .time-slot:hover {
            background-color: #e8d6bf;
        }

        .time-slot.selected {
            background-color: #d29c68;
            color: #fff;
            border-color: #c98d55;
        }

        .time-slot.disabled {
            opacity: 0.5;
            cursor: not-allowed;
            background-color: #ddd;
        }

        .selected-info {
            margin-top: 30px;
            font-size: 1.1rem;
            color: #3b2b20;
            font-weight: 500;
        }

        /* Step Indicators */
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

        /* buttons */
        .buttons {
            display: flex;
            justify-content: space-between;
            padding: 0 20%;
            margin-top: 30px;
        }

        .buttons a {
            padding: 12px 30px;
            font-size: 16px;
            text-decoration: none;
            border-radius: 8px;
            border: none;
            cursor: pointer;
            font-weight: 600;
        }

        .continue-btn {
            background: #5a2c0c;
            color: white;
        }

        .back-btn {
            background: #fff;
            color: #5a2c0c;
            border: 2px solid #5a2c0c;
        }

        .back-btn:hover {
            background: #f2e7de;
        }

        @media (max-width: 760px) {
            .main-wrapper {
                flex-direction: column;
                align-items: center;
            }
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
            <div class="circle">3</div>
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

    <h1>Select Date & Time</h1>
    <p class="subtitle"></p>

    <div class="main-wrapper">
        <!-- Date Container -->
        <div class="box">
            <h3>Choose Date</h3>
            <input type="date" id="calendar" class="calendar" placeholder="Choose the Date">
        </div>

        <!-- Time Container -->
        <div class="box">
            <h3>Choose Time</h3>
            <div class="time-slots" id="timeSlots">
                <div class="time-slot">7:00 AM</div>
                <div class="time-slot">8:00 AM</div>
                <div class="time-slot">9:00 AM</div>
                <div class="time-slot">10:00 AM</div>
                <div class="time-slot">11:00 AM</div>
                <div class="time-slot">12:00 PM</div>
                <div class="time-slot">2:00 PM</div>
                <div class="time-slot">3:00 PM</div>
                <div class="time-slot">4:00 PM</div>
                <div class="time-slot">5:00 PM</div>
            </div>
        </div>
    </div>

    <div class="selected-info" id="selectedInfo">No date/time selected</div>

    <div class="buttons">
        <a href="booking2.php" class="back-btn">Back to Barbers</a>
        <a id="continueBtn" class="continue-btn">Continue to Booking</a>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/flatpickr"></script>
    <script>

        const service = localStorage.getItem("selectedService") || "No Service Selected";
        const barber = localStorage.getItem("selectedBarber") || "No Barber Selected";
        document.querySelector(".subtitle").innerText = `${service} with ${barber}`;

        let selectedDate = null;
        let selectedTime = null;

        // === Calendar Setup ===
        flatpickr("#calendar", {
            minDate: "today",
            maxDate: new Date().fp_incr(14), // allows dates only up to 14 days from today
            onChange: function (selectedDates, dateStr) {
                selectedDate = dateStr;
                updateSelectedInfo();
            }
        });


        // === date Slot Selection ===
        calendar.addEventListener("click", (e) => {
            if (e.target.classList.contains("day")) {
                document.querySelectorAll(".day").forEach(d => d.classList.remove("selected"));
                e.target.classList.add("selected");
                selectedDate = `${monthNames[currentMonth]} ${e.target.textContent}, ${currentYear}`;
                updateSelectedInfo();
            }
        });
        
        // === Fetch Booked Slots from Server ===
        async function fetchBookedSlots() {
            if (!selectedDate || !barber) return;

            const res = await fetch(`get-booked-slots.php?barber_name=${encodeURIComponent(barber)}`);
            const data = await res.json();

            const timeSlots = document.querySelectorAll(".time-slot");
            timeSlots.forEach(btn => {
                btn.classList.remove("disabled");
                btn.style.opacity = "1";
                btn.style.cursor = "pointer";
            });

            data.forEach(slot => {
                if (slot.booking_date === selectedDate) {
                    const bookedTime = slot.booking_time.slice(0, 5);
                    timeSlots.forEach(btn => {
                        if (btn.dataset.time === bookedTime) {
                            btn.classList.add("disabled");
                            btn.style.opacity = "0.5";
                            btn.style.cursor = "not-allowed";
                        }
                    });
                }
            });
        }

        // === Time Slot Selection ===
        const timeSlots = document.querySelectorAll(".time-slot");
        timeSlots.forEach(slot => {
            slot.addEventListener("click", () => {
                timeSlots.forEach(s => s.classList.remove("selected"));
                slot.classList.add("selected");
                selectedTime = slot.textContent;
                updateSelectedInfo();
            });
        });

        // === Display Selection ===
        function updateSelectedInfo() {
            const info = document.getElementById("selectedInfo");

            if (selectedDate) {
                localStorage.setItem("bookingDate", selectedDate);
            }
            if (selectedTime) {
                localStorage.setItem("bookingTime", selectedTime);
            }

            if (selectedDate && selectedTime) {
                info.textContent = `Selected: ${selectedDate} at ${selectedTime}`;
            } else if (selectedDate) {
                info.textContent = `Selected date: ${selectedDate}`;
            } else if (selectedTime) {
                info.textContent = `Selected time: ${selectedTime}`;
            } else {
                info.textContent = "No date/time selected";
            }
        }

        // === Continue Button Logic ===
        document.getElementById("continueBtn").addEventListener("click", () => {
            if (!selectedDate || !selectedTime) {
                alert("Please select both a date and time to continue.");
                return;
            }
            window.location.href = "confirmation.php";
        });

    </script>

</body>

</html>
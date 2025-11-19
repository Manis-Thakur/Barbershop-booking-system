<?php
session_start();
if (!isset($_SESSION['admin_name'])) {
    header("Location: admin-login.html");
    exit();
}

// Database connection
$conn = new mysqli("localhost", "root", "", "groomease");
if ($conn->connect_error) {
    die("Database connection failed: " . $conn->connect_error);
}

// Handle status updates
if (isset($_POST['update_status'])) {
    $booking_id = $_POST['booking_id'];
    $new_status = $_POST['new_status'];

    $stmt = $conn->prepare("UPDATE bookings SET status = ? WHERE id = ?");
    $stmt->bind_param("si", $new_status, $booking_id);
    $stmt->execute();
    $stmt->close();
}

// Dashboard stats
$today = date("Y-m-d");
$weekStart = date("Y-m-d", strtotime('monday this week'));
$weekEnd = date("Y-m-d", strtotime('sunday this week'));

$todayAppointments = $conn->query("
    SELECT COUNT(*) AS count 
    FROM bookings 
    WHERE booking_date = CURDATE()
")->fetch_assoc()['count'];


$thisWeekAppointments = $conn->query("SELECT COUNT(*) AS count FROM bookings WHERE booking_date BETWEEN '$weekStart' AND '$weekEnd'")->fetch_assoc()['count'];
$activeBarbers = $conn->query("SELECT COUNT(*) AS count FROM barbers WHERE status = 'active'")
    ->fetch_assoc()['count'];

// Fetch appointments
$appointments = $conn->query("
    SELECT id, service_name, barber_name, booking_date, booking_time, payment_amount, status 
    FROM bookings 
    ORDER BY id DESC
");



?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard</title>
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined" />
    <link rel="stylesheet" href="css/admin.css">
    <style>
        .appointment-card {
            display: flex;
            justify-content: space-between;
            align-items: center;
            background: #fff;
            border-radius: 12px;
            padding: 15px 20px;
            margin-bottom: 15px;
            box-shadow: 0 2px 6px rgba(0, 0, 0, 0.1);
        }

        .app-left {
            display: flex;
            flex-direction: column;
        }

        .dnt {
            color: #6b4e3d;
            font-size: 14px;
            margin-top: 4px;
        }

        .status {
            padding: 5px 10px;
            border-radius: 6px;
            font-size: 13px;
            font-weight: 600;
        }

        .pending {
            background-color: #fff5c4;
            color: #856404;
        }

        .confirmed {
            background-color: #d4edda;
            color: #155724;
        }

        .completed {
            background-color: #cce5ff;
            color: #004085;
        }

        .cancelled {
            background-color: #f8d7da;
            color: #721c24;
        }

        .actions {
            position: relative;
        }

        .action-btn {
            background: none;
            border: none;
            font-size: 22px;
            cursor: pointer;
        }

        .dropdown {
            display: none;
            position: absolute;
            right: 0;
            background: #fff;
            box-shadow: 0 3px 8px rgba(0, 0, 0, 0.1);
            border-radius: 8px;
            overflow: hidden;
            z-index: 10;
        }

        .dropdown button {
            background: none;
            border: none;
            width: 160px;
            text-align: left;
            padding: 10px 15px;
            font-size: 14px;
            cursor: pointer;
        }

        .dropdown button:hover {
            background-color: #f5f0eb;
        }

        .action-btn.disabled {
            opacity: 0.4;
            cursor: not-allowed;
        }


        .addBarber {
            display: inline-block;
            margin-top: 20px;
            padding: 10px 15px;
            background-color: #3e2e1f;
            color: #fff;
            text-decoration: none;
            border-radius: 6px;
            transition: background-color 0.3s ease;
        }
    </style>
</head>

<body>

    <header class="navbar">
        <div class="logo">
            <div class="logo-icon">✂</div>
            <div>
                <h2 class="welcome-text"><?php echo htmlspecialchars($_SESSION['admin_name']); ?></h2>
            </div>
        </div>

        <div class="nav-buttons">
            <a href="manage-service.php" class="btn-light"> Service</a>
            <a href="index.php" class="btn-light">View customer site</a>
            <a href="admin-logout.php" class="btn-light">Sign out</a>
        </div>
    </header>


    <div class="dashboard-container">

        <!-- Stats -->
        <div class="stats-grid">
            <div class="card">
                <span class="card-label">Today's Appointments</span>
                <span class="card-value"><?php echo $todayAppointments; ?></span>
            </div>
            <div class="card">
                <span class="card-label">This Week</span>
                <span class="card-value"><?php echo $thisWeekAppointments; ?></span>
            </div>
            <div class="card">
                <span class="card-label">Active Barbers</span>
                <span class="card-value"><?php echo $activeBarbers; ?></span>
            </div>
        </div>

        <!-- Tabs -->
        <div class="tabs">
            <div class="tab active" onclick="switchTab('appointments')">Appointments</div>
            <div class="tab" onclick="switchTab('barbers')">Barbers</div>
            <div class="tab" onclick="switchTab('customers')">Customers</div>
        </div>

        <!-- Appointments Section -->
        <section id="appointments-section">
            <?php if ($appointments->num_rows > 0): ?>
                <?php while ($row = $appointments->fetch_assoc()): ?>
                    <?php
                    $date = date("M d, Y", strtotime($row['booking_date']));
                    $time = date("g:i A", strtotime($row['booking_time']));
                    $statusClass = strtolower($row['status']);

                    // Check if appointment time has passed
                    $appointmentDateTime = strtotime($row['booking_date'] . ' ' . $row['booking_time']);
                    $currentTime = time();
                    $isPast = $appointmentDateTime < $currentTime;
                    ?>
                    <div class="appointment-card">
                        <div class="app-left">
                            <span><strong><?php echo htmlspecialchars($row['service_name']); ?></strong> with
                                <?php echo htmlspecialchars($row['barber_name']); ?></span>
                            <div class="dnt">
                                <span class="material-symbols-outlined">calendar_month</span>
                                <?php echo $date; ?> — ⏱ <?php echo $time; ?>
                            </div>
                        </div>

                        <div style="display:flex; align-items:center; gap:15px;">
                            <span class="status <?php echo $statusClass; ?>">
                                <?php echo htmlspecialchars($row['status']); ?>
                            </span>

                            <strong><?php echo htmlspecialchars($row['payment_amount']); ?></strong>

                            <div class="actions">

                                <!-- If time passed: Disable menu -->
                                <?php if ($isPast): ?>
                                    <button class="action-btn disabled" disabled>⋮</button>

                                <?php else: ?>
                                    <!-- Normal Active Dropdown -->
                                    <button class="action-btn" onclick="toggleDropdown(this)">⋮</button>
                                    <div class="dropdown">
                                        <form method="POST">
                                            <input type="hidden" name="booking_id" value="<?php echo $row['id']; ?>">
                                            <input type="hidden" name="new_status" value="Confirmed">
                                            <button type="submit" name="update_status">Mark Confirmed</button>
                                        </form>
                                        <form method="POST">
                                            <input type="hidden" name="booking_id" value="<?php echo $row['id']; ?>">
                                            <input type="hidden" name="new_status" value="Completed">
                                            <button type="submit" name="update_status">Mark Completed</button>
                                        </form>
                                        <form method="POST">
                                            <input type="hidden" name="booking_id" value="<?php echo $row['id']; ?>">
                                            <input type="hidden" name="new_status" value="Cancelled">
                                            <button type="submit" name="update_status">Cancel Appointment</button>
                                        </form>
                                    </div>
                                <?php endif; ?>

                            </div>
                        </div>
                    </div>
                <?php endwhile; ?>
            <?php else: ?>
                <p style="margin: 20px;">No appointments found.</p>
            <?php endif; ?>
        </section>


        <!-- Barbers Section -->
        <section id="barbers-section" style="display:none; margin-top:25px;">
            <div class="barbers-grid" style="display: flex; gap: 20px; flex-wrap: wrap;">
                <?php
                // Fetch all barbers from the database
                $barbers = $conn->query("SELECT * FROM barbers ORDER BY name ASC");

                if ($barbers && $barbers->num_rows > 0) {
                    while ($b = $barbers->fetch_assoc()) {
                        $barberId = $b['id']; // Make sure you have an `id` column
                        $barberName = htmlspecialchars($b['name']);
                        $initials = strtoupper(substr($barberName, 0, 2));
                        $specialty = htmlspecialchars($b['specialty']);
                        $experience = htmlspecialchars($b['experience'] ?? 'N/A');
                        $status = htmlspecialchars($b['status'] ?? 'active');

                        echo "<div class='barber-card' id='barber-{$barberId}' style='background:#fff; border-radius:15px; padding:20px; width:320px; box-shadow:0 2px 6px rgba(0,0,0,0.08);'>
                    <div style='display:flex; align-items:center; gap:12px;'>
                        <div class='avatar' style='background:#f5f0eb; width:45px; height:45px; border-radius:50%; display:flex; justify-content:center; align-items:center; font-weight:bold; color:#3e2e1f; font-size:16px;'>{$initials}</div>
                        <div>
                            <strong style='font-size:16px;'>{$barberName}</strong>
                            <div class='specialty' style='color:#8a7663; font-size:14px;'>{$specialty}</div>
                        </div>
                    </div>
                    <div style='margin-top:15px; color:#7a6656; font-size:14px;'>
                        <p><strong>Experience:</strong> {$experience} years</p>
                        <p><strong>Status:</strong> " . ucfirst($status) . "</p>
                    </div>
                    <button class='remove-btn' data-id='{$barberId}' style='margin-top:10px; padding:8px 12px; background:#c0392b; color:#fff; border:none; border-radius:6px; cursor:pointer;'>Remove</button>
                </div>";
                    }
                } else {
                    echo "<p>No barbers found in the database.</p>";
                }
                ?>
            </div>
            <div style="text-align: center; margin-top: 20px;">
                <a href="add_barber.php" class="addBarber">Add Barber</a>
            </div>
        </section>




        <!-- Customers Section -->
        <section id="customers-section" style="display:none; margin-top:25px;">
            <div class="customers-container">
                <h2>Customer Database</h2>
                <p>View and manage customer information</p>

                <?php
                $customers = $conn->query("
            SELECT u.id, u.fullname, u.phone, u.email,
                   COUNT(b.id) AS total_appointments,
                   MAX(b.booking_date) AS last_visit
            FROM users u
            LEFT JOIN bookings b ON u.id = b.user_id
            GROUP BY u.id
            ORDER BY u.fullname ASC
        ");

                if (!$customers) {
                    die('SQL Error: ' . $conn->error);
                }

                if ($customers->num_rows > 0) {
                    while ($cust = $customers->fetch_assoc()) {

                        $initials = strtoupper(substr($cust['fullname'], 0, 2));
                        $lastVisit = $cust['last_visit'] ? date("M d, Y", strtotime($cust['last_visit'])) : "N/A";

                        echo "
                    <div class='customer-card'>
                        <div class='customer-left'>
                            <div class='initials'>{$initials}</div>
                            <div>
                                <strong>{$cust['fullname']}</strong><br>
                                <span>📞 {$cust['phone']}</span> &nbsp; ✉️ {$cust['email']}
                            </div>
                        </div>
                        <div class='customer-right'>
                            <strong>{$cust['total_appointments']} appointments</strong><br>
                            <small>Last visit: {$lastVisit}</small>
                        </div>
                    </div>
                ";
                    }
                } else {
                    echo "<p>No customers found.</p>";
                }
                ?>
            </div>
        </section>



    </div>
    <script>
        function switchTab(tabName) {
            document.querySelectorAll(".tab").forEach(tab => tab.classList.remove("active"));
            document.querySelectorAll("section").forEach(sec => sec.style.display = "none");
            document.querySelector(`[onclick="switchTab('${tabName}')"]`).classList.add("active");
            document.querySelector(`#${tabName}-section`).style.display = "block";
        }

        function toggleDropdown(btn) {
            const dropdown = btn.nextElementSibling;
            const all = document.querySelectorAll('.dropdown');
            all.forEach(d => { if (d !== dropdown) d.style.display = 'none'; });
            dropdown.style.display = dropdown.style.display === 'block' ? 'none' : 'block';
        }

        window.addEventListener('click', function (e) {
            if (!e.target.closest('.actions')) {
                document.querySelectorAll('.dropdown').forEach(d => d.style.display = 'none');
            }
        });


        document.querySelectorAll('.remove-btn').forEach(btn => {
            btn.addEventListener('click', () => {
                const barberId = btn.dataset.id;
                if (confirm("Are you sure you want to remove this barber?")) {
                    fetch('remove_barber.php', {
                        method: 'POST',
                        headers: { 'Content-Type': 'application/x-www-form-urlencoded' },
                        body: 'id=' + barberId
                    })
                        .then(response => response.json())
                        .then(data => {
                            if (data.status === 'success') {
                                // Remove the card from frontend
                                const card = document.getElementById('barber-' + barberId);
                                card.remove();
                            } else {
                                alert("Error: " + data.message);
                            }
                        });
                }
            });
        });
    </script>


</body>

</html>
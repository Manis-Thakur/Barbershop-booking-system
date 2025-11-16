<?php
session_start();

$conn = new mysqli("localhost", "root", "", "groomease");

// Check DB connection
if ($conn->connect_error) {
    die("Database Connection Failed: " . $conn->connect_error);
}

// Delete service
if (isset($_GET['delete'])) {
    $id = intval($_GET['delete']); // security
    $conn->query("DELETE FROM services WHERE service_id = $id");
    header("Location: manage-service.php?deleted=1");
    exit;
}

// Fetch services
$services = $conn->query("SELECT * FROM services ORDER BY service_id DESC");

// Show SQL error
if (!$services) {
    die("SQL Error: " . $conn->error);
}
?>
<!DOCTYPE html>
<html>

<head>
    <title>Manage Services</title>
    <style>
        body {
            font-family: Arial;
            background: #f7f3ee;
            padding: 20px;
        }

        .service-list {
            display: flex;
            flex-wrap: wrap;
            gap: 20px;
        }

        .service-card {
            width: 250px;
            background: #fff;
            border-radius: 10px;
            padding: 15px;
            box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1);
        }

        .service-card img {
            width: 100%;
            height: 160px;
            object-fit: cover;
            border-radius: 8px;
            background: #eee;
        }

        .btn-add {
            padding: 10px 15px;
            background: #3e2e1f;
            color: #fff;
            text-decoration: none;
            border-radius: 6px;
        }

        .delete-btn {
            background: #c0392b;
            color: #fff;
            padding: 6px 10px;
            border-radius: 5px;
            text-decoration: none;
            display: inline-block;
            margin-top: 10px;
        }
    </style>
</head>

<body>

    <h2>Manage Services</h2>

    <a href="add-service.php" class="btn-add">+ Add New Service</a>

    <br><br>

    <div class="service-list">

        <?php if ($services->num_rows == 0): ?>
            <p>No services added yet.</p>
        <?php endif; ?>

        <?php while ($row = $services->fetch_assoc()): ?>
            <div class="service-card">

                <img src="./images/<?php echo htmlspecialchars($row['service_image']); ?>" alt="Service Image">

                <h3><?php echo htmlspecialchars($row['service_name']); ?></h3>
                <p>Duration: <?php echo $row['duration']; ?> mins</p>
                <p>Price: <?php echo $row['price']; ?></p>

                <a class="delete-btn" href="manage-service.php?delete=<?php echo $row['service_id']; ?>"
                    onclick="return confirm('Delete this service?');">
                    Delete
                </a>
            </div>
        <?php endwhile; ?>
    </div>

</body>

</html>
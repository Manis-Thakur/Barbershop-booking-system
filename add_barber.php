<?php
session_start();
if (!isset($_SESSION['admin_name'])) {
    header("Location: admin-login.html");
    exit();
}

$conn = new mysqli("localhost", "root", "", "groomease");
if ($conn->connect_error) {
    die("Database connection failed: " . $conn->connect_error);
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $name = $conn->real_escape_string($_POST['name']);
    $specialty = $conn->real_escape_string($_POST['specialty']);
    $experience = (int) $_POST['experience'];
    $status = $conn->real_escape_string($_POST['status']);
    $email = $conn->real_escape_string($_POST['email']);
    $phone = $conn->real_escape_string($_POST['phone']);

    $sql = "INSERT INTO barbers (name, specialty, experience, email, phone, status) 
        VALUES ('$name', '$specialty', '$experience', '$email', '$phone', '$status')";
    if ($conn->query($sql)) {
        header("Location: admin-dashboard.php?msg=Barber added successfully");
    } else {
        echo "Error: " . $conn->error;
    }
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>

<body>

    <!-- Add Barber Section -->

    <section id="add-barber-section"
        style="margin-top:25px; background:#fdf8f2; padding:20px; border-radius:15px; box-shadow:0 2px 6px rgba(0,0,0,0.08);">
        <h2 style="margin-bottom:15px; color:#3e2e1f;">Add New Barber</h2>
        <form action="add_barber.php" method="POST"
            style="display:flex; flex-direction:column; gap:12px; max-width:400px;">
            <input type="text" name="name" placeholder="Barber Name" required
                style="padding:8px; border-radius:6px; border:1px solid #ccc;">
            <input type="text" name="specialty" placeholder="Specialty" required
                style="padding:8px; border-radius:6px; border:1px solid #ccc;">
            <input type="number" name="experience" placeholder="Experience (years)" min="0"
                style="padding:8px; border-radius:6px; border:1px solid #ccc;">
            <input type="email" name="email" placeholder="Email" required
                style="padding:8px; border-radius:6px; border:1px solid #ccc;">
            <input type="tel" name="phone" placeholder="Phone Number" required
                style="padding:8px; border-radius:6px; border:1px solid #ccc;">
            <select name="status" style="padding:8px; border-radius:6px; border:1px solid #ccc;">
                <option value="active">Active</option>
                <option value="inactive">Inactive</option>
            </select>
            <button type="submit"
                style="padding:10px; background:#3e2e1f; color:#fff; border:none; border-radius:6px; cursor:pointer;">Add
                Barber</button>
        </form>
    </section>


</body>

</html>
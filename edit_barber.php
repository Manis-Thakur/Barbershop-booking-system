<?php
session_start();
if (!isset($_SESSION['admin_name'])) {
    header("Location: admin-login.html");
    exit();
}

$conn = new mysqli("localhost", "root", "", "groomease");
if ($conn->connect_error) die("DB Error: " . $conn->connect_error);

// GET barber info
if (!isset($_GET['id'])) {
    die("Invalid barber ID");
}

$id = (int)$_GET['id'];

$barber = $conn->query("SELECT * FROM barbers WHERE id = $id")->fetch_assoc();
if (!$barber) die("Barber not found");

// SAVE UPDATES
if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    $name = $conn->real_escape_string($_POST['name']);
    $specialty = $conn->real_escape_string($_POST['specialty']);
    $experience = (int)$_POST['experience'];
    $email = $conn->real_escape_string($_POST['email']);
    $phone = $conn->real_escape_string($_POST['phone']);
    $status = $conn->real_escape_string($_POST['status']);

    $sql = "UPDATE barbers SET 
            name='$name',
            specialty='$specialty',
            experience='$experience',
            email='$email',
            phone='$phone',
            status='$status'
            WHERE id=$id";

    if ($conn->query($sql)) {
        header("Location: admin-dashboard.php?msg=Barber updated successfully");
        exit();
    } else {
        echo "Error: " . $conn->error;
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Edit Barber</title>
    <style>
        body { font-family: Arial; background:#f7f3ef; padding:40px; }
        .form-box {
            background:#fff; padding:25px; border-radius:10px;
            box-shadow:0 2px 6px rgba(0,0,0,0.1); max-width:450px; margin:auto;
        }
        input, select {
            width:100%; padding:10px; margin:7px 0;
            border:1px solid #ccc; border-radius:6px;
        }
        button {
            width:100%; padding:10px; margin-top:10px;
            background:#3e2e1f; color:#fff; border:none; border-radius:6px;
            cursor:pointer;
        }
    </style>
</head>

<body>
    <div class="form-box">
        <h2>Edit Barber</h2>

        <form method="POST">
            <input type="text" name="name" value="<?= $barber['name'] ?>" required>
            <input type="text" name="specialty" value="<?= $barber['specialty'] ?>" required>
            <input type="number" name="experience" value="<?= $barber['experience'] ?>" required>
            <input type="email" name="email" value="<?= $barber['email'] ?>" required>
            <input type="tel" name="phone" value="<?= $barber['phone'] ?>" required>

            <select name="status">
                <option value="active" <?= $barber['status']=='active' ? 'selected' : '' ?>>Active</option>
                <option value="inactive" <?= $barber['status']=='inactive' ? 'selected' : '' ?>>Inactive</option>
            </select>

            <button type="submit">Save Changes</button>
        </form>
    </div>
</body>
</html>

<?php
session_start();
$conn = new mysqli("localhost", "root", "", "groomease");
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $email = trim($_POST['email']);
    $password = trim($_POST['password']);

    // Query the admins table
    $stmt = $conn->prepare("SELECT * FROM admins WHERE email = ?");
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows === 1) {
        $admin = $result->fetch_assoc();

        // Verify password
        if (password_verify($password, $admin['password'])) {
            // Correct login, start session
            $_SESSION['admin_name'] = $admin['fullname'];
            $_SESSION['admin_id'] = $admin['id'];

            // Redirect to dashboard
            header("Location: admin-dashboard.php");
            exit();
        } else {
            // Wrong password
            header("Location: admin-login.html?error=Invalid password");
        }
    } else {
        // Admin not found
        header("Location: admin-login.html?error=Email not found");

    }

    $stmt->close();
    $conn->close();
} else {
    // If accessed directly, redirect to login page
    header("Location: admin-dashboard.php");
    exit();
}
?>
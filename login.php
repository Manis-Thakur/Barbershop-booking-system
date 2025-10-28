<?php
session_start();

// Database connection
$conn = new mysqli("localhost", "root", "", "groomease");
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$email = $_POST['email'];
$password = $_POST['password'];

// Fetch user by email
$stmt = $conn->prepare("SELECT id, fullname, password FROM users WHERE email = ?");
$stmt->bind_param("s", $email);
$stmt->execute();
$stmt->store_result();

if ($stmt->num_rows > 0) {
    $stmt->bind_result($id, $fullname, $hashed_password);
    $stmt->fetch();

    if (password_verify($password, $hashed_password)) {
        // Set session
        $_SESSION['user_id'] = $id;
        $_SESSION['fullname'] = $fullname;

        // Redirect to dashboard
        header("Location: index.php");
        exit();
    } else {
        header("Location: login.html?error=Invalid password");
    }
} else {
    header("Location: login.html?error=Email not registered");
}

$stmt->close();
$conn->close();
?>
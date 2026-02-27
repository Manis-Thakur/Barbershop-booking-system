<?php
// Start session (optional if you want auto-login after signup)
session_start();

// Database connection
$conn = new mysqli("localhost", "root", "", "groomease");
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Get POST data
$fullname = $_POST['fullname'];
$email = $_POST['email'];
$phone = $_POST['phone'];
$password = $_POST['password'];
$confirm = $_POST['confirm'];

// Check password match
if ($password !== $confirm) {
    die("Passwords do not match!");
}

// Check if email already exists
$stmt = $conn->prepare("SELECT id FROM users WHERE email = ?");
$stmt->bind_param("s", $email);
$stmt->execute();
$stmt->store_result();
if ($stmt->num_rows > 0) {
    die("Email already registered!");
}
$stmt->close();

// Hash password
$hashed_password = password_hash($password, PASSWORD_DEFAULT);

// Insert user into database
$stmt = $conn->prepare("INSERT INTO users (fullname, email, phone, password) VALUES (?, ?, ?, ?)");
$stmt->bind_param("ssss", $fullname, $email, $phone, $hashed_password);

if ($stmt->execute()) {
    // Optional: Auto-login after signup
    $_SESSION['user_id'] = $stmt->insert_id;
    $_SESSION['fullname'] = $fullname;
    $_SESSION['email'] = $email;
    $_SESSION['phone'] = $phone;
    header("Location: index.php");
    exit();
} else {
    echo "Error: " . $stmt->error;
}

$stmt->close();
$conn->close();
?>
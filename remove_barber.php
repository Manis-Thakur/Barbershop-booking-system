<?php
session_start();
if (!isset($_SESSION['admin_name'])) {
    echo json_encode(['status' => 'error', 'message' => 'Not authorized']);
    exit;
}

$conn = new mysqli("localhost", "root", "", "groomease");
if ($conn->connect_error) {
    die(json_encode(['status' => 'error', 'message' => 'DB connection failed']));
}

if (isset($_POST['id'])) {
    $id = (int)$_POST['id'];
    $sql = "DELETE FROM barbers WHERE id=$id";
    if ($conn->query($sql)) {
        echo json_encode(['status' => 'success']);
    } else {
        echo json_encode(['status' => 'error', 'message' => $conn->error]);
    }
} else {
    echo json_encode(['status' => 'error', 'message' => 'Invalid ID']);
}
?>

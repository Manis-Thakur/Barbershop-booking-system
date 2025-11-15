<?php
session_start();

$conn = new mysqli("localhost", "root", "", "groomease");

if (isset($_POST['submit'])) {
    $name = $_POST['service_name'];
    $duration = $_POST['duration'];
    $price = $_POST['price'];

    // File Upload Handling
    $imageName = $_FILES['service_image']['name'];
    $tmpName = $_FILES['service_image']['tmp_name'];

    // Correct path (same directory as add-service.php)
    $uploadPath = "images/" . $imageName;

    // Move uploaded file to images folder
    if (move_uploaded_file($tmpName, $uploadPath)) {

        $sql = "INSERT INTO services (service_name, service_image, duration, price)
                VALUES ('$name', '$imageName', '$duration', '$price')";

        if ($conn->query($sql)) {
            header("Location: manage-service.php?success=1");
            exit;
        } else {
            echo "Database Error: " . $conn->error;
        }
    } else {
        echo "Image Upload Failed!";
    }
}
?>

<!DOCTYPE html>
<html>

<head>
    <title>Add Service</title>
    <style>
        body {
            font-family: "Segoe UI", sans-serif;
            background: #fdf8f2;
            margin: 0;
            padding: 40px;
            color: #3e2e1f;
        }

        .form-container {
            max-width: 500px;
            background: #fff;
            padding: 30px;
            border-radius: 14px;
            margin: auto;
            box-shadow: 0 3px 10px rgba(0, 0, 0, 0.08);
            border: 1px solid #eee;
        }

        h2 {
            text-align: center;
            margin-bottom: 25px;
            font-size: 24px;
            color: #5a2e0f;
        }

        label {
            font-weight: 600;
            display: block;
            margin-bottom: 6px;
            color: #5a2e0f;
        }

        input[type="text"],
        input[type="number"],
        input[type="file"] {
            width: 100%;
            padding: 12px;
            border-radius: 8px;
            border: 1px solid #d2c7b8;
            font-size: 15px;
            background: #fefcf9;
            outline: none;
            transition: 0.2s;
        }

        input:focus {
            border-color: #5a2e0f;
            box-shadow: 0px 0px 4px rgba(90, 46, 15, 0.3);
        }

        button {
            width: 100%;
            background: #3e2e1f;
            color: #fff;
            padding: 12px;
            font-size: 16px;
            border-radius: 8px;
            border: none;
            cursor: pointer;
            transition: 0.25s ease;
            margin-top: 10px;
        }

        button:hover {
            background: #5a2e0f;
            transform: translateY(-2px);
        }
    </style>
</head>

<body>

    <div class="form-container">
        <h2>Add New Service</h2>

        <form action="" method="POST" enctype="multipart/form-data">
            <label>Service Name:</label>
            <input type="text" name="service_name" required>

            <br><br>

            <label>Upload Image:</label>
            <input type="file" name="service_image" accept="image/*" required>

            <br><br>

            <label>Duration (minutes):</label>
            <input type="number" name="duration" required>

            <br><br>

            <label>Price (₹):</label>
            <input type="number" name="price" required>

            <br><br>

            <button type="submit" name="submit">Add Service</button>
        </form>
    </div>

</body>

</html>
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
    <style>
        .center-wrapper {
            display: flex;
            justify-content: center;
            margin-top: 40px;
            width: 100%;
        }


        .add-section {
            background: #fdf8f2;
            padding: 25px;
            border-radius: 15px;
            box-shadow: 0 2px 6px rgba(0, 0, 0, 0.08);
            max-width: 500px;
            width: 100%;
        }

        .add-section h2 {
            margin-bottom: 15px;
            color: #3e2e1f;
            font-size: 22px;
        }

        /* Form */
        .add-form {
            display: flex;
            flex-direction: column;
            gap: 20px;
        }

        /* Inputs */
        .add-form input,
        .add-form select {
            padding: 10px;
            border-radius: 8px;
            border: 1px solid #d6c8b8;
            background: #fff;
            font-size: 15px;
            color: #3e2e1f;
            transition: 0.2s ease;
        }

        .add-form input:focus,
        .add-form select:focus {
            border-color: #3e2e1f;
            outline: none;
            box-shadow: 0 0 4px rgba(62, 46, 31, 0.2);
        }

        /* Submit Button */
        .btn-submit {
            padding: 12px;
            background: #3e2e1f;
            color: #fff;
            border: none;
            border-radius: 8px;
            cursor: pointer;
            font-size: 15px;
            font-weight: 600;
            transition: 0.3s ease;
        }

        .btn-submit:hover {
            background: #2c1f14;
        }
    </style>
</head>

<body>

    <!-- Add Barber Section -->
    <div class="center-wrapper">
        <section id="add-barber-section" class="add-section">
            <h2>Add New Barber</h2>

            <form action="add_barber.php" method="POST" class="add-form">
                <input type="text" name="name" placeholder="Barber Name" required>
                <input type="text" name="specialty" placeholder="Specialty" required>
                <input type="number" name="experience" placeholder="Experience (years)" min="0" required>
                <input type="email" name="email" placeholder="Email" required>
                <input type="tel" name="phone" placeholder="Phone Number" required>

                <select name="status">
                    <option value="active">Active</option>
                    <option value="inactive">Inactive</option>
                </select>

                <button type="submit" class="btn-submit">Add Barber</button>
            </form>
        </section>
    </div>

    <script>
        document.addEventListener("DOMContentLoaded", () => {
            const form = document.querySelector(".add-form");

            form.addEventListener("submit", function (e) {

                const email = form.email.value.trim();
                const phone = form.phone.value.trim();

                const emailRegex = /^[A-Za-z][A-Za-z0-9._%+-]*@[A-Za-z0-9.-]+\.[A-Za-z]{2,}$/;
                const phoneRegex = /^(98|97)[0-9]{8}$/;

                let errors = [];


                if (!emailRegex.test(email)) {
                    errors.push("Invalid email format.");
                }
                if (!phoneRegex.test(phone)) {
                    errors.push("Phone must start with 98 or 97 and be exactly 10 digits.");
                }

                if (errors.length > 0) {
                    e.preventDefault();
                    alert(errors.join("\n"));
                }
            });
        });
    </script>




</body>

</html>
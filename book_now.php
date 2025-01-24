<?php
session_start();

if (!isset($_SESSION['logged_in']) || $_SESSION['logged_in'] !== true) {
    header("Location: login_register.php");
    exit();
}

if (!isset($_GET['room']) || !isset($_GET['price'])) {
    die("Invalid booking request.");
}

$room_name = $_GET['room'];
$price = $_GET['price'];

// اتصال بقاعدة البيانات
$host = "localhost";
$dbname = "reg";
$username = "root";
$password = "";

$conn = new mysqli($host, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// التحقق من توفر الغرفة
$sql = "SELECT available FROM rooms WHERE name = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("s", $room_name);
$stmt->execute();
$stmt->bind_result($available);
$stmt->fetch();
$stmt->close();

if ($available <= 0) {
    die("Sorry, the room is no longer available.");
}

// عرض نموذج الحجز
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // استقبال البيانات المدخلة من المستخدم
    $check_in = $_POST['check_in'];
    $check_out = $_POST['check_out'];

    // تحقق من أن تاريخ check-out بعد تاريخ check-in
    if (strtotime($check_out) <= strtotime($check_in)) {
        die("Error: Check-out date must be after Check-in date.");
    }

    // إدخال الحجز في قاعدة البيانات
    $username = $_SESSION['username']; // اسم المستخدم من الجلسة
    $sql = "INSERT INTO bookings (username, room_name, price, check_in, check_out) VALUES (?, ?, ?, ?, ?)";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("ssdss", $username, $room_name, $price, $check_in, $check_out);
    $stmt->execute();
    $stmt->close();

    // تحديث حالة الغرفة
    $sql = "UPDATE rooms SET available = available - 1 WHERE name = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("s", $room_name);
    $stmt->execute();
    $stmt->close();

    header("Location: your_logs.php");
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Book Now - Sunset Hotel</title>
    <link rel="stylesheet" href="css/animate.css">
    <link rel="stylesheet" href="css/icomoon.css">
    <link rel="stylesheet" href="css/bootstrap.css">
    <link rel="stylesheet" href="css/superfish.css">
    <link rel="stylesheet" href="css/style.css">
    <link rel="icon" href="Initial H Letter Real Estate Logo Design.png" type="image/x-icon">
    <style>
        body {
            margin: 0;
            font-family: Arial, sans-serif;
            background-image: url('https://pbs.twimg.com/media/Excr7o_VcAcrsvX.jpg:large');
            background-size: cover;
            background-position: center;
            background-attachment: fixed;
            color: #333;
        }
        .header {
            text-align: center;
            padding: 20px;
            color: #007bff;
        }
        .header h1 {
    margin: 0;
    cursor: pointer;
    font-size: 24px; 
    color: white; 
}

        .container {
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            height: 80vh;
        }
        .booking-form {
            background: rgba(0, 0, 0, 0.8);
            padding: 20px;
            border-radius: 10px;
            width: 350px;
            box-shadow: 0px 4px 10px rgba(0, 0, 0, 0.3);
            text-align: center;
        }
        .booking-form h2 {
            margin-bottom: 20px;
            color: #fff;
            font-size: 22px;
        }
        .booking-form img {
            width: 140px;
            height: auto;
            margin-bottom: 20px;
        }
        .booking-form label {
            display: block;
            margin-bottom: 10px;
            font-size: 16px;
            color: #fff;
        }
        .booking-form input {
            width: 90%; 
            padding: 10px; 
            margin-bottom: 15px;
            border: 1px solid #ccc;
            border-radius: 5px;
            font-size: 14px; 
        }
        .buttons {
            display: flex;
            flex-direction: column;
            align-items: center; 
            gap: 15px; 
        }
        .buttons button {
            padding: 10px 20px;
            border: none;
            border-radius: 5px;
            font-size: 14px; 
            cursor: pointer;
            transition: all 0.3s ease;
            color: #fff;
        }
        .btn-confirm {
            background-color: #28a745; 
            width: 70%; 
        }
        .btn-confirm:hover {
            background-color: #1e7e34;
        }
        .btn-back {
            background-color: #dc3545; 
            width: 50%; 
            padding: 8px 15px;
            text-align: center;  
            margin: 0 auto;  
            border-radius: 20px; 
            font-size: 14px;  
        }
        .btn-back:hover {
            background-color: #a71d2a; 
        }
        footer {
            text-align: center;
            padding: 10px; 
            background: none; 
            color: white; 
            position: relative;
        }
        input[type="date"]::-webkit-calendar-picker-indicator {
            color: #007bff; 
        }
        input[type="date"] {
            direction: ltr; 
        }
    </style>
</head>
<body>
    <div class="header">
        <h1>Confirming Booking</h1>
    </div>

    <div class="container">
        <div class="booking-form">
            <img src="Initial H Letter Real Estate Logo Design.png" alt="Sunset Hotel Logo">
            <h2>Set the best date for yourself</h2>
            <form method="POST">
                <label for="check_in">Check-in:</label>
                <input type="date" id="check_in" name="check_in" required>

                <label for="check_out">Check-out:</label>
                <input type="date" id="check_out" name="check_out" required>

                <div class="buttons">
                    <button type="submit" class="btn-confirm">Confirm Booking</button>
                    <a href="reservation.php" class="btn-back">Return</a>
                </div>
            </form>
        </div>
    </div>

    <footer>
        <div class="row">
            <div class="col-md-6 col-md-offset-3 text-center">
                <p style="font-size: 14px; line-height: 1.6;">
                <a href="#" style="font-size: 18px; font-weight: bold; color:rgb(144, 200, 238);">Sunset Hotel</a>
                <span style="font-size: 14px; color: #ffffff;">All Rights Reserved.</span><br>
                    <span style="font-size: 14px; color: #ffffff;">Made by UQU Students</span><br><br>
                    <span style="font-size: 14px; color: #ffffff;">Contact with us</span><br>
                    <i class="icon-mail" style="font-size: 16px; color: #ffffff;"></i>
                    <span style="font-size: 14px; color: #ffffff;"> S444002968@uqu.edu.sa</span>
                    <i class="icon-mail" style="font-size: 16px; color: #ffffff;"></i>
                    <span style="font-size: 14px; color: #ffffff;"> S444008038@uqu.edu.sa </span>
                    <i class="icon-mail" style="font-size: 16px; color: #ffffff;"> </i>
                    <br>
              <span style="font-size: 14px; color: #ffffff;"> S444005537@uqu.edu.sa </span>
              <i class="icon-mail" style="font-size: 16px; color: #ffffff;"> </i>
              <span style="font-size: 14px; color: #ffffff;"> S444006563@uqu.edu.sa </span>
              <br>
              <i class="icon-mail" style="font-size: 16px; color: #ffffff;"> </i>
              <span style="font-size: 14px; color: #ffffff;"> S444007503@uqu.edu.sa</span>
                </p>
            </div>
        </div>
    </footer>
</body>
</html>

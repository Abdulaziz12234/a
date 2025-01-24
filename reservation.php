<?php
session_start();

// التحقق من تسجيل الدخول
if (!isset($_SESSION['logged_in']) || $_SESSION['logged_in'] !== true) {
    if (isset($_COOKIE['user_logged_in']) && $_COOKIE['user_logged_in'] === 'true') {
        $_SESSION['logged_in'] = true;
        $_SESSION['username'] = $_COOKIE['username'];
    } else {
        header("Location: login_register.php");
        exit();
    }
}

// الاتصال بقاعدة البيانات
$host = "localhost"; // اسم الخادم
$dbname = "reg"; // اسم قاعدة البيانات
$username = "root"; // اسم المستخدم
$password = ""; // كلمة المرور

$conn = new mysqli($host, $username, $password, $dbname);

// التحقق من الاتصال
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// جلب بيانات الغرف من قاعدة البيانات
$sql = "SELECT * FROM rooms";
$result = $conn->query($sql);

$rooms = [];
if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $rooms[] = $row;
    }
}

$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Hotel Reservation System</title>
    <link href="https://fonts.googleapis.com/css2?family=Open+Sans:wght@300;400;600&display=swap" rel="stylesheet">
    <link rel="icon" href="Initial H Letter Real Estate Logo Design.png" type="image/x-icon">
    <h1 id="fh5co-logo"><a href="index.php">Sunset Hotel</a></h1>
    
    <style>
   
        body {
            font-family: 'Open Sans', sans-serif;
            margin: 0;
            padding: 0;
            background-color:rgb(247, 235, 207);
        }

        header {
            background: linear-gradient(to right, #FF7E5F, #FEB47B);
            color: white;
            padding: 100px 20px;
            text-align: center;
        }

        header h1 {
            font-size: 50px;
            margin: 0;
            font-weight: 700;
        }

        header p {
            font-size: 22px;
            margin-top: 10px;
        }

        /* Navigation Bar */
        .nav-bar {
            text-align: center;
            background-color: #2c3e50;
            padding: 15px;
        }

        .nav-bar a {
            text-decoration: none;
            color: white;
            font-size: 18px;
            margin: 0 15px;
            padding: 10px 20px;
            border-radius: 5px;
            transition: background-color 0.3s ease;
        }
        .room-card button {
    margin-top: 10px;
    padding: 10px;
    font-size: 16px;
    background-color: green; 
    color: #fff;
    border: none;
    border-radius: 5px;
    cursor: pointer;
    transition: background-color 0.3s;
}

        .nav-bar a:hover {
            background-color:rgb(95, 159, 255);
        }



        /* Reservation Section */
        .reservation-section {
            padding: 50px 20px;
            background-color:rgb(235, 233, 227);
        }

        .reservation-section h2 {
            font-size: 30px;
            color: #333;
            text-align: center;
            margin-bottom: 20px;
        }

        .filters {
            max-width: 800px;
            margin: 0 auto;
            margin-bottom: 30px;
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 20px;
            background: #f9f9f9;
            border-radius: 10px;
            box-shadow: 0 8px 16px rgba(0, 0, 0, 0.1);
        }

        .filters label {
            font-size: 16px;
            font-weight: 600;
        }

        .filters select, .filters input {
            padding: 10px;
            font-size: 16px;
            border-radius: 5px;
            border: 1px solid #ddd;
        }

        .rooms {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 20px;
            max-width: 800px;
            margin: 0 auto;
        }

        .room-card {
            padding: 20px;
            border-radius: 10px;
            background: #fff;
            box-shadow: 0 8px 16px rgba(0, 0, 0, 0.1);
            position: relative;
        }

        .room-card h3 {
            font-size: 20px;
            margin-bottom: 10px;
        }

        .room-card p {
            margin: 5px 0;
        }

        .room-card .price {
            color:rgb(95, 255, 167);
            font-weight: 600;
        }

        

        .room-card button:disabled {
            background-color: #ddd;
            cursor: not-allowed;
        }

        .room-card.available {
            border-left: 10px solid green;
        }

        .room-card.unavailable {
            border-left: 10px solid red;
        }

        /* Footer */
        footer {
            background-color: #2c3e50;
            color: white;
            padding: 20px;
            text-align: center;
        }

        footer p {
            margin: 0;
            font-size: 14px;
        }
        .room-card {
    padding: 20px;
    border-radius: 10px;
    background: #fff;
    box-shadow: 0 8px 16px rgba(0, 0, 0, 0.1);
    position: relative;
    overflow: hidden;
    background-size: cover;
    background-position: center; 
    height: 250px; 
    display: flex;
    flex-direction: column;
    justify-content: flex-end; 
    color: black; 
    background-size: cover; 
    box-shadow: 0 8px 16px rgba(0, 0, 0, 0.1);
    position: relative;
    transition: transform 0.3s ease, box-shadow 0.3s ease, background-size 0.3s ease;
}
.room-card:hover {
    transform: scale(1.05);
    box-shadow: 0 16px 32px rgba(0, 0, 0, 0.2);
    background-size: 110%; }

.room-card h3,
.room-card p {
    color: white; 
    text-shadow: 0 0 10px black, 0 0 20px black, 0 0 30px black; }



            </style>
               <link rel="stylesheet" href="css/animate.css">
     <link rel="stylesheet" href="css/icomoon.css">
     <link rel="stylesheet" href="css/bootstrap.css">
     <link rel="stylesheet" href="css/superfish.css">
     <link rel="stylesheet" href="css/style.css">
</head>
<body>

<div class="nav-bar">
    <a href="index.php">Home</a>
    <a href="your_logs.php">Your Logs</a> 
    <a href="logout.php">Log Out</a>
    <?php echo htmlspecialchars($_SESSION['username']); ?>
</div>
<section class="reservation-section">
    <h2>Rooms</h2>

    <div class="filters">
        <label for="price-range">Price:</label>
        <input type="number" id="price-range" min="100" max="300" placeholder="Enter your budget">
        
        <label for="room-availability">Availability:</label>
        <select id="room-availability">
            <option value="">All</option>
            <option value="available">Available</option>
            <option value="unavailable">Unavailable</option>
        </select>
        
        <label for="search-bar">Search Rooms:</label>
        <input type="text" id="search-bar" placeholder="Name or description">
        
    </div>

    <div class="rooms" id="rooms-container">
    </div>
</section>

<!-- Footer Section -->
<footer>
        <div class="row">
          <div class="col-md-6 col-md-offset-3 text-center">
            <p style="font-size: 14px; line-height: 1.6;">
                   <a href="#" style="font-size: 18px; font-weight: bold; color:rgb(144, 200, 238);">Sunset Hotel</a>
            <span style="font-size: 14px; color: #ffffff;">All Rights Reserved.</span><br>
              <span style="font-size: 14px; color: #ffffff;">Made by UQU Students</span><br><br>
              <span style="font-size: 14px; color: #ffffff;">Contact with us</span><br>
              <i class="icon-mail" style="font-size: 16px; color: #ffffff;"> </i>
              <span style="font-size: 14px; color: #ffffff;"> S444002968@uqu.edu.sa</span>
              <i class="icon-mail" style="font-size: 16px; color: #ffffff;"> </i>
              <span style="font-size: 14px; color: #ffffff;"> S444008038@uqu.edu.sa </span>
              <br>
              <i class="icon-mail" style="font-size: 16px; color: #ffffff;"> </i>
              <span style="font-size: 14px; color: #ffffff;"> S444005537@uqu.edu.sa </span>
              <i class="icon-mail" style="font-size: 16px; color: #ffffff;"> </i>
              <span style="font-size: 14px; color: #ffffff;"> S444006563@uqu.edu.sa </span>
              <br>
              <i class="icon-mail" style="font-size: 16px; color: #ffffff;"> </i>
              <span style="font-size: 14px; color: #ffffff;"> S444007503@uqu.edu.sa</span>
            </p>
          </div>
        </div>
      </div>
  </footer>

<script>
    
    // جلب الغرف من PHP ككائن JSON
    const rooms = <?php echo json_encode($rooms); ?>;

    const roomsContainer = document.getElementById('rooms-container');
    const filterBtn = document.getElementById('filter-btn');
    const priceRangeInput = document.getElementById('price-range');
    const searchBar = document.getElementById('search-bar');
    const roomAvailabilityInput = document.getElementById('room-availability');

    function displayRooms(filteredRooms) {
    roomsContainer.innerHTML = '';
    if (filteredRooms.length === 0) {
        roomsContainer.innerHTML = '<p>No rooms available based on your search criteria.</p>';
        return;
    }

    filteredRooms.forEach(room => {
        const roomCard = document.createElement('div');
        roomCard.classList.add('room-card');
        roomCard.classList.add(room.available > 0 ? 'available' : 'unavailable');
        
        // تعيين الصورة كخلفية للـ div
        roomCard.style.backgroundImage = `url(${room.image_url})`;

        roomCard.innerHTML = `
            <h3>${room.name}</h3>
            <p>${room.description}</p>
            <p class="price">SR ${room.price} per night</p>
            <button 
                ${room.available <= 0 ? 'disabled' : ''} 
                onclick="window.location.href='book_now.php?room=${encodeURIComponent(room.name)}&price=${room.price}'">
                ${room.available > 0 ? 'Book Now' : 'Unavailable'}
            </button>
        `;
        roomsContainer.appendChild(roomCard);
    });
}


function filterRooms() {
    const maxPrice = parseInt(priceRangeInput.value, 10);
    const roomAvailability = roomAvailabilityInput.value;
    const searchTerm = searchBar.value.toLowerCase();

    let filteredRooms = rooms;

    console.log('Room Availability:', roomAvailability);

    if (!isNaN(maxPrice) && maxPrice >= 0) {
        filteredRooms = filteredRooms.filter(room => room.price <= maxPrice);
    }

    if (roomAvailability) {
        // فلترة حسب التوافر
        if (roomAvailability === "available") {
            filteredRooms = filteredRooms.filter(room => room.available > 0); // الغرف المتوفرة
        } else if (roomAvailability === "unavailable") {
            filteredRooms = filteredRooms.filter(room => room.available == 0); // الغرف غير المتوفرة
        }
    }

    if (searchTerm) {
        filteredRooms = filteredRooms.filter(room => 
            room.name.toLowerCase().includes(searchTerm) || 
            room.description.toLowerCase().includes(searchTerm)
        );
    }

    console.log('Filtered Rooms:', filteredRooms);

    displayRooms(filteredRooms);
}
    searchBar.addEventListener('input', filterRooms);
    priceRangeInput.addEventListener('input', filterRooms);
    roomAvailabilityInput.addEventListener('input', filterRooms);

    displayRooms(rooms);
</script>
</body>
</html>

<?php
session_start();

if (!isset($_SESSION['logged_in']) || $_SESSION['logged_in'] !== true) {
    header("Location: login_register.php");
    exit();
}

$userName = $_SESSION['username'];

// الاتصال بقاعدة البيانات
$host = "localhost";
$dbname = "reg";
$username = "root";
$password = "";

$conn = new mysqli($host, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// تحديد الترتيب الافتراضي (الأحدث أولاً)
$order = 'DESC';

// التحقق من وجود فلتر ترتيب في الرابط
if (isset($_GET['order'])) {
    $order = $_GET['order'] == 'ASC' ? 'ASC' : 'DESC';  // التأكد من صحة الخيار
}

// جلب بيانات الحجز الخاصة بالمستخدم مع الترتيب بناءً على الخيار
$sql = "SELECT * FROM bookings WHERE username = ? ORDER BY check_in $order";
$stmt = $conn->prepare($sql);
$stmt->bind_param("s", $userName);
$stmt->execute();
$result = $stmt->get_result();

// التحقق من طلب الحذف
if (isset($_GET['delete_id'])) {
    $delete_id = $_GET['delete_id'];

    // استرجاع اسم الغرفة من الحجز المحذوف
    $get_room_sql = "SELECT room_name FROM bookings WHERE id = ?";
    $get_room_stmt = $conn->prepare($get_room_sql);
    $get_room_stmt->bind_param("i", $delete_id);
    $get_room_stmt->execute();
    $get_room_stmt->bind_result($room_name);
    $get_room_stmt->fetch();
    $get_room_stmt->close();

    // حذف الحجز
    $delete_sql = "DELETE FROM bookings WHERE id = ?";
    $delete_stmt = $conn->prepare($delete_sql);
    $delete_stmt->bind_param("i", $delete_id);
    if ($delete_stmt->execute()) {
        // تحديث عدد الغرف المتاحة بعد الحذف
        $update_room_sql = "UPDATE rooms SET available = available + 1 WHERE name = ?";
        $update_room_stmt = $conn->prepare($update_room_sql);
        $update_room_stmt->bind_param("s", $room_name);
        $update_room_stmt->execute();
        $update_room_stmt->close();

        echo "<script>alert('Booking deleted successfully. Room availability updated.'); window.location.href='your_logs.php';</script>";
    } else {
        echo "<script>alert('Error deleting booking.');</script>";
    }
    $delete_stmt->close();
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Your Bookings</title>
    
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f9;
            margin: 0;
            padding: 0;
        }

        h2 {
            text-align: center;
            color: #333;
            padding-top: 20px;
        }

        table {
            width: 80%;
            margin: 20px auto;
            border-collapse: collapse;
            background-color: #fff;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        }

        th, td {
            padding: 12px;
            text-align: center;
            border: 1px solid #ddd;
        }

        th {
            background-color: #4CAF50;
            color: white;
        }

        tr:nth-child(even) {
            background-color: #f2f2f2;
        }

        tr:hover {
            background-color: #ddd;
        }

        p {
            text-align: center;
            font-size: 18px;
            color: #555;
        }

        .filter-container {
            text-align: left;
            margin: 20px auto;
            width: 80%;
        }

        .filter-button {
            background-color: #3498db;
            color: white;
            padding: 6px 12px;
            border: none;
            border-radius: 4px;
            font-size: 14px;
            cursor: pointer;
            transition: background-color 0.3s ease;
        }

        .filter-button:hover {
            background-color: #2980b9;
        }

        .filter-button:focus {
            outline: none;
        }

        .filter-container .date-col {
            text-align: center;
        }

        .nav-buttons {
            text-align: center;
            margin: 20px;
        }

        .nav-button {
            background-color: #2ecc71;
            color: white;
            padding: 10px 20px;
            border: none;
            border-radius: 4px;
            font-size: 16px;
            margin: 5px;
            cursor: pointer;
            transition: background-color 0.3s ease;
        }

        .nav-button:hover {
            background-color: #27ae60;
        }

        .nav-button:focus {
            outline: none;
        }

        .delete-button {
            background-color: #e74c3c;
            color: white;
            padding: 6px 12px;
            border: none;
            border-radius: 4px;
            font-size: 12px;
            cursor: pointer;
            transition: background-color 0.3s ease;
        }

        .delete-button:hover {
            background-color: #c0392b;
        }

        .delete-button:focus {
            outline: none;
        }
    </style>
</head>
<body>
    <h2>Your Bookings </h2>
    
    <div class="filter-container">
        <button class="filter-button" onclick="toggleSort()">Sort</button>
    </div>

    <?php if ($result->num_rows > 0): ?>
        <table>
            <tr>
                <th>Room Name</th>
                <th>Price</th>
                <th class="date-col">Check-in</th>
                <th class="date-col">Check-out</th>
                <th>Action</th> 
            </tr>
            <?php while ($row = $result->fetch_assoc()): ?>
                <tr>
                    <td><?php echo htmlspecialchars($row['room_name']); ?></td>
                    <td><?php echo htmlspecialchars($row['price']); ?></td>
                    <td><?php echo htmlspecialchars($row['check_in']); ?></td>
                    <td><?php echo htmlspecialchars($row['check_out']); ?></td>
                    <td>
                        <a href="your_logs.php?delete_id=<?php echo $row['id']; ?>" onclick="return confirm('Are you sure you want to delete this booking?');">
                            <button class="delete-button">Delete</button>
                        </a>
                    </td>
                </tr>
            <?php endwhile; ?>
        </table>
    <?php else: ?>
        <p>No bookings found.</p>
    <?php endif; ?>

    <div class="nav-buttons">
        <button class="nav-button" onclick="window.location.href='index.php'">Home</button>
        <button class="nav-button" onclick="window.location.href='reservation.php'">Another Book</button>
    </div>

    <script>
        function toggleSort() {
            let currentOrder = "<?php echo $order; ?>";
            let newOrder = currentOrder === "DESC" ? "ASC" : "DESC"; // تبديل الترتيب

            // تحديث الرابط مع المعلمة الجديدة للترتيب
            window.location.href = "your_logs.php?order=" + newOrder;
        }
    </script>
</body>
</html>

<?php
$stmt->close();
$conn->close();
?>

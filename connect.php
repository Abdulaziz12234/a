<?php
// استلام البيانات من الفورم
$conn = new mysqli('localhost', 'root', '', 'reg');
if ($conn->connect_error) {
    die('Connection Failed: ' . $conn->connect_error);
}

// إذا تم إرسال بيانات التسجيل
if (isset($_POST['register'])) {
    $Username = $_POST['Username'];
    $Email = $_POST['Email'];
    $Password = $_POST['Password'];
            'image_url' => $row['image_url']

    // تحضير استعلام لتخزين بيانات المستخدم
    $stmt = $conn->prepare("INSERT INTO Registration (Username, Email, Password) VALUES (?, ?, ?)");
    if ($stmt === false) {
        die('Error preparing the statement: ' . $conn->error);
    }
    $stmt->bind_param("sss", $Username, $Email, $Password);

    // تنفيذ الاستعلام
    if ($stmt->execute()) {
        echo "Registration successful!";
    } else {
        echo "Error: " . $stmt->error;
    }

    // إغلاق الاتصال
    $stmt->close();
}

$conn->close();
?>

<!-- نموذج التسجيل -->
<form method="POST" action="register.php">
    <input type="text" name="Username" placeholder="Username" required><br>
    <input type="email" name="Email" placeholder="Email" required><br>
    <input type="password" name="Password" placeholder="Password" required><br>
    <input type="submit" name="register" value="Register">
</form>

<?php
session_start();

// التحقق من إذا كان المستخدم قد سجل دخوله بالفعل باستخدام الجلسات أو الكوكيز
if (isset($_SESSION['logged_in']) && $_SESSION['logged_in'] === true) {
    header("Location: index.php");
    exit();
} elseif (isset($_COOKIE['user_logged_in']) && $_COOKIE['user_logged_in'] === 'true') {
    $_SESSION['logged_in'] = true;
    $_SESSION['username'] = $_COOKIE['username'];
    header("Location: index.php");
    exit();
}

// التحقق من بيانات تسجيل الدخول
if (isset($_POST['login'])) {
    $Email = $_POST['Email'];
    $Password = $_POST['Password'];

    $conn = new mysqli('localhost', 'root', '', 'reg');
    if ($conn->connect_error) {
        die('Connection Failed: ' . $conn->connect_error);
    }

    $stmt = $conn->prepare("SELECT * FROM Registration WHERE Email = ?");
    $stmt->bind_param("s", $Email);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
        if ($Password === $row['Password']) {
            $_SESSION['logged_in'] = true;
            $_SESSION['username'] = $row['Username'];

            // إنشاء كوكي لحفظ الجلسة لمدة 30 يوم
            setcookie("user_logged_in", "true", time() + (30 * 24 * 60 * 60), "/");  // 30 يوم
            setcookie("username", $row['Username'], time() + (30 * 24 * 60 * 60), "/");  // 30 يوم

            header("Location: index.php");
            exit();
        } else {
            $error_message = "Invalid password!";
        }
    } else {
        $error_message = "No user found with this email!";
    }

    $stmt->close();
    $conn->close();
}

// التحقق من عملية التسجيل
if (isset($_POST['register'])) {
    $username = $_POST['username'];
    $email = $_POST['email'];
    $password = $_POST['password'];

    $conn = new mysqli('localhost', 'root', '', 'reg');
    if ($conn->connect_error) {
        die('Connection Failed: ' . $conn->connect_error);
    }

    $stmt = $conn->prepare("INSERT INTO Registration (Username, Email, Password) VALUES (?, ?, ?)");
    $stmt->bind_param("sss", $username, $email, $password);
    $stmt->execute();

    $_SESSION['logged_in'] = true;
    $_SESSION['username'] = $username;

    // إنشاء كوكي لحفظ الجلسة لمدة 30 يوم
    setcookie("user_logged_in", "true", time() + (30 * 24 * 60 * 60), "/");
    setcookie("username", $username, time() + (30 * 24 * 60 * 60), "/");

    header("Location: index.php");
    exit();

    $stmt->close();
    $conn->close();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Sign Up / Login</title>
    <link href="https://fonts.googleapis.com/css2?family=Jost:wght@500&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <div class="main">
        <input type="checkbox" id="chk" aria-hidden="true">

        <div class="signup">
            <form method="POST" action="">
                <label for="chk" aria-hidden="true">Sign up</label>
                <input type="text" name="username" placeholder="User name" required>
                <input type="email" name="email" placeholder="Email" required>
                <input type="password" name="password" placeholder="Password" required>
                <button type="submit" name="register">Sign up</button>
            </form>
        </div>

        <div class="login">
            <form method="POST" action="">
                <label for="chk" aria-hidden="true">Login</label>
                <input type="email" name="Email" placeholder="Email" required>
                <input type="password" name="Password" placeholder="Password" required>
                <button type="submit" name="login">Login</button>
            </form>
            <?php if (isset($error_message)): ?>
                <p style="color:red;"><?php echo $error_message; ?></p>
            <?php endif; ?>
        </div>
    </div>
</body>
</html>

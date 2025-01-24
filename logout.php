<?php
session_start();

// تدمير الجلسة
session_unset();
session_destroy();

// مسح الكوكي إذا كان موجودًا
setcookie("user_logged_in", "", time() - 3600, "/");
setcookie("username", "", time() - 3600, "/");

header("Location: login_register.php");
exit();
?>

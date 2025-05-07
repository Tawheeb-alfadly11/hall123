<?php
$host = "localhost"; // أو 127.0.0.1
$user = "root";
$password = ""; // كلمة مرور قاعدة البيانات، غالبًا تكون فارغة في XAMPP
$database = "hall_reservations"; // غيّرها إذا كان اسم قاعدة بياناتك مختلف

$conn = mysqli_connect($host, $user, $password, $database);

// التحقق من الاتصال
if (!$conn) {
    die("فشل الاتصال بقاعدة البيانات: " . mysqli_connect_error());
}
?>

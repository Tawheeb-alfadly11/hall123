<?php
session_start();
$servername = 'localhost'; 
$username = 'root'; 
$password = ''; 
$dbname = 'wedding_halls'; 

// إنشاء الاتصال
$conn = new mysqli($servername, $username, $password, $dbname);

// تحقق من الاتصال
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// بيانات الأدمن المراد إدخالها
$admin_username = 'ahmedessam'; 
$admin_password = '780730739'; 
$admin_email = 'ahmed.aladimi.2004@gmail.com'; 
$admin_user_type = 'admin'; 

// تجزئة كلمة السر لضمان الأمان
$hashed_password = password_hash($admin_password, PASSWORD_DEFAULT);

// إدخال بيانات الأدمن
$stmt = $conn->prepare("INSERT INTO users (username, password, email, user_type) VALUES (?, ?, ?, ?)");
$stmt->bind_param("ssss", $admin_username, $hashed_password, $admin_email, $admin_user_type);

if ($stmt->execute()) {
    echo "تم إضافة المستخدم بنجاح!";
} else {
    echo "خطأ: " . $stmt->error;
}

$stmt->close();
$conn->close();
?>
<?php
session_start();
$conn = new mysqli('localhost', 'root', '', 'wedding_halls');

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// تحقق مما إذا كان المستخدم متجاوز
if (!isset($_SESSION['user_id'])) {
    die("يجب تسجيل الدخول لتقديم تقييم.");
}

// معالجة طلب التقييم
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $hall_id = $_POST['hall_id'];
    $rating = $_POST['rating'];
    $review = $_POST['review'];
    $user_id = $_SESSION['user_id'];

    // إدخال التقييم في جدول reviews
    $stmt = $conn->prepare("INSERT INTO reviews (hall_id, user_id, rating, review) VALUES (?, ?, ?, ?)");
    $stmt->bind_param("iiis", $hall_id, $user_id, $rating, $review);
    
    if ($stmt->execute()) {
        echo "تم إضافة تقييمك بنجاح!";
    } else {
        echo "خطأ: " . $stmt->error;
    }

    $stmt->close();
}

$conn->close();
?>
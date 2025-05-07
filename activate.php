<?php
$conn = new mysqli('localhost', 'root', '', 'wedding_halls');

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

if (isset($_GET['email']) && isset($_GET['code'])) {
    $email = $_GET['email'];
    $code = $_GET['code'];

    // تحديث حالة التفعيل في قاعدة البيانات
    $stmt = $conn->prepare("UPDATE users SET activated = 1 WHERE email = ? AND MD5(email) = ?");
    $stmt->bind_param("ss", $email, $code);
    if ($stmt->execute()) {
        echo "تم تفعيل حسابك بنجاح!";
    } else {
        echo "حدث خطأ أثناء تفعيل الحساب.";
    }
    $stmt->close();
}
$conn->close();
?>
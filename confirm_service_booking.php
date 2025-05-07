<?php
session_start();
$conn = new mysqli('localhost', 'root', '', 'wedding_halls');

if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}

// تأكد من وجود user_id في الجلسة
if (!isset($_SESSION['user_id'])) {
    echo "يجب عليك تسجيل الدخول لحجز الخدمة.";
    exit();
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $service_id = $_POST['service_id'];
    $user_id = $_SESSION['user_id'];
    $account_number = $_POST['account_number'];
    $service_price = $_POST['service_price']; // المبلغ المدفوع

    // محاكاة عملية الدفع
    $payment_received = true; // فرضية أن عملية الدفع تمت بنجاح

    if ($payment_received) {
        // إضافة المدفوعات إلى قاعدة البيانات
        $stmt_payment = $conn->prepare("INSERT INTO payments (amount, account_number) VALUES (?, ?)");
        $stmt_payment->bind_param("ds", $service_price, $account_number);
        if ($stmt_payment->execute()) {
            echo "تم حجز الخدمة بنجاح!";
        } else {
            echo "خطأ: " . $stmt_payment->error;
        }
        $stmt_payment->close();
    } else {
        echo "فشلت عملية الدفع. يرجى المحاولة مرة أخرى.";
    }
} else {
    echo "طلب غير صالح.";
}

$conn->close();
?>

<?php
session_start();
$conn = new mysqli('localhost', 'root', '', 'wedding_halls');

if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}

// تحقق من وجود بيانات POST
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $hall_id = $_POST['hall_id'];
    $user_id = $_SESSION['user_id'];
    $date = $_POST['date'];
    $account_number = $_POST['account_number'];
    $hall_account_number = $_POST['hall_account_number'];
    $payment_amount = $_POST['payment_amount']; // المبلغ المدفوع

    // التأكد من أن التاريخ غير متاح مسبقًا
    $check = $conn->prepare("SELECT * FROM bookings WHERE hall_id = ? AND booking_date = ?");
    $check->bind_param("is", $hall_id, $date);
    $check->execute();
    $check_result = $check->get_result();

    if ($check_result->num_rows > 0) {
        echo "عذراً، القاعة محجوزة في هذا التاريخ.";
    } else {
        // محاكاة عملية الدفع
        $payment_received = true; // فرضية نجاح الدفع

        if ($payment_received) {
            // إنشاء حجز في قاعدة البيانات
            $stmt = $conn->prepare("INSERT INTO bookings (hall_id, user_id, booking_date) VALUES (?, ?, ?)");
            $stmt->bind_param("iis", $hall_id, $user_id, $date);
            if ($stmt->execute()) {
                // الحصول على معرف الحجز
                $booking_id = $stmt->insert_id;

                // تسجيل المدفوعات
                $stmt_payment = $conn->prepare("INSERT INTO payments (booking_id, amount, account_number) VALUES (?, ?, ?)");
                $stmt_payment->bind_param("dss", $booking_id, $payment_amount, $account_number);
                if ($stmt_payment->execute()) {
                    echo "تم حجز القاعة بنجاح!";
                } else {
                    echo "خطأ في تسجيل الدفع: " . $stmt_payment->error;
                }
                $stmt_payment->close();
            } else {
                echo "خطأ: " . $stmt->error;
            }
            $stmt->close();
        } else {
            echo "فشلت عملية الدفع. يرجى المحاولة مرة أخرى.";
        }
    }
    $check->close();
} else {
    echo "طلب غير صالح.";
}

$conn->close();
?>

<?php
session_start();
$conn = new mysqli('localhost', 'root', '', 'wedding_halls');

if ($conn->connect_error) {
    die("فشل الاتصال: " . $conn->connect_error);
}

// تحقق من تسجيل الدخول
if (!isset($_SESSION['user_id'])) {
    die("يجب تسجيل الدخول لحجز القاعة.");
}

// تأكد من طلب POST
if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    die("طريقة الطلب غير صالحة.");
}

// استخراج البيانات
$hall_id = $_POST['hall_id'] ?? null;
$date = $_POST['date'] ?? '';
$account_number = $_POST['account_number'] ?? '';
$payment_amount = $_POST['payment_amount'] ?? 0;

// تحقق من وجود جميع الحقول
if (empty($hall_id) || empty($date) || empty($account_number) || empty($payment_amount)) {
    echo "يرجى ملء جميع الحقول.";
    exit();
}

// تحقق من صيغة التاريخ (YYYY-MM-DD)
if (!strtotime($date)) { // تأكد من صحة التاريخ
    echo "التاريخ غير صحيح.";
    exit();
}

// تحقق من توفر القاعة
$stmt = $conn->prepare("SELECT 1 FROM bookings WHERE hall_id = ? AND booking_date = ?");
$stmt->bind_param("is", $hall_id, $date);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows > 0) {
    echo "عذراً، القاعة محجوزة في هذا التاريخ.";
    $stmt->close();
    exit();
}

// محاكاة عملية الدفع (استبدلها بنظام دفع حقيقي)
$payment_received = false;

// لغرض الاختبار، افترض أن الدفع ناجح
if ($payment_amount > 0) {
    $payment_received = true;
}

if ($payment_received) {
    // إضافة الحجز إلى قاعدة البيانات
    $stmt = $conn->prepare("INSERT INTO bookings (hall_id, user_id, booking_date, amount_paid) VALUES (?, ?, ?, ?)");
    // تغيير "iids" إلى "iiss"
    $stmt->bind_param("iiss", $hall_id, $_SESSION['user_id'], $date, $payment_amount);

    if ($stmt->execute()) {
        $_SESSION['booking_success'] = "تم الحجز بنجاح! سيتم التواصل معك لتأكيد التفاصيل.";
        header("Location: book_success.php"); // توجيه إلى صفحة نجاح الحجز
        exit();
    } else {
        echo "خطأ في الحجز: " . $stmt->error;
    }
} else {
    echo "فشل الدفع. يرجى المحاولة مرة أخرى.";
}

$stmt->close();
$conn->close();
?>
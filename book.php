<?php
session_start();
$conn = new mysqli('localhost', 'root', '', 'wedding_halls');

if ($conn->connect_error) {
    die("فشل الاتصال: " . $conn->connect_error);
}

// تأكد من وجود ID القاعة في الرابط
$id = $_GET['id'] ?? null;
if (empty($id)) {
    die("يجب تحديد رقم القاعة");
}

// تحقق من تسجيل الدخول
if (!isset($_SESSION['user_id'])) {
    die("يجب تسجيل الدخول لحجز القاعة.");
}

// استعلام لاستخراج تفاصيل القاعة
$stmt = $conn->prepare("SELECT name, price, bank_account_number, bank_name FROM halls WHERE id = ?");
$stmt->bind_param("i", $id);
$stmt->execute();
$stmt->bind_result($hall_name, $hall_price, $hall_account, $hall_bank);
$stmt->fetch();
$stmt->close();

// تحقق من وجود القاعة
if (empty($hall_name)) {
    die("القاعة غير موجودة");
}
?>

<!DOCTYPE html>
<html lang="ar">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>حجز القاعة</title>
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            font-family: Arial, sans-serif;
        }
        .container {
            max-width: 800px;
        }
        .form-group {
            margin-bottom: 20px;
        }
        label {
            font-weight: bold;
        }
        .card {
            border-radius: 10px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            padding: 20px;
        }
    </style>
</head>
<body>
    <div class="container mt-5">
        <h2 class="text-center mb-4">حجز القاعة: <?= htmlspecialchars($hall_name) ?></h2>
        <form action="submit_booking.php" method="POST">
            <!-- معلومات القاعة (مخفي) -->
            <input type="hidden" name="hall_id" value="<?= htmlspecialchars($id) ?>">
            <input type="hidden" name="hall_account_number" value="<?= htmlspecialchars($hall_account) ?>">
            
            <!-- حقل التاريخ -->
            <div class="form-group">
                <label for="date">تاريخ الحجز:</label>
                <input type="date" class="form-control" name="date" required>
            </div>
            
            <!-- حقل رقم الحساب البنكي للمستخدم -->
            <div class="form-group">
                <label for="account_number">رقم حسابك البنكي:</label>
                <input type="text" class="form-control" name="account_number" placeholder="مثال: SA0123456789" required>
            </div>
            
            <!-- معلومات القاعة (غير قابلة للتعديل) -->
            <div class="form-group">
                <label>رقم حساب القاعة:</label>
                <input type="text" class="form-control" value="<?= htmlspecialchars($hall_account) ?>" readonly>
            </div>
            
            <!-- مبلغ الحجز -->
            <div class="form-group">
                <label>مبلغ الحجز:</label>
                <input type="number" step="0.01" class="form-control" name="payment_amount" 
                    value="<?= htmlspecialchars($hall_price) ?>" readonly>
            </div>
            
            <!-- زر التأكيد -->
            <button type="submit" class="btn btn-success btn-block">تأكيد الحجز</button>
        </form>
    </div>
</body>
</html>
<?php
session_start();

// التأكد من أن المستخدم هو مزود الخدمة
if (!isset($_SESSION['user_id']) || $_SESSION['user_type'] !== 'service_provider') {
    header("Location: login.php"); // إذا لم يكن مزود الخدمة، أعاده إلى تسجيل الدخول
    exit();
}

$conn = new mysqli('localhost', 'root', '', 'wedding_halls'); // الاتصال بقاعدة البيانات
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// معالجة بيانات إضافة صالة
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $hall_name = $_POST['hall_name'];
    $capacity = $_POST['capacity'];
    $price = $_POST['price'];
    $location = $_POST['location']; // موقع الصالة
    $bank_account_number = $_POST['bank_account_number'];
    $bank_name = $_POST['bank_name'];
    $image_url = $_POST['image_url']; // رابط الصورة

    // التأكد من صحة URL الصورة
    if (filter_var($image_url, FILTER_VALIDATE_URL)) {
        // إدخال بيانات الصالة في قاعدة البيانات
        $stmt = $conn->prepare("INSERT INTO halls (name, capacity, price, location, image_url, bank_account_number, bank_name) 
                               VALUES (?, ?, ?, ?, ?, ?, ?)");
        // تغيير "sidsisi" إلى "sidssss" (كل الأعمدة نص إلا السعة والسعر)
        $stmt->bind_param("sidssss", $hall_name, $capacity, $price, $location, $image_url, $bank_account_number, $bank_name);

        if ($stmt->execute()) {
            echo "<div class='alert alert-success'>تم إضافة الصالة بنجاح!</div>";
        } else {
            echo "<div class='alert alert-danger'>خطأ في إضافة الصالة: " . $stmt->error . "</div>";
        }
        $stmt->close(); // إغلاق الاستعلام
    } else {
        echo "<div class='alert alert-danger'>يرجى إدخال رابط صورة صحيح.</div>";
    }
}

$conn->close(); // إغلاق الاتصال بقاعدة البيانات
?>

<!DOCTYPE html>
<html lang="ar">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>إضافة قاعة جديدة</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
</head>
<body>
    <div class="container mt-5">
        <h2>إضافة قاعة جديدة</h2>
        <form action="service_provider.php" method="POST">
            <div class="form-group">
                <label for="hall_name">اسم القاعة:</label>
                <input type="text" class="form-control" name="hall_name" required>
            </div>
            <div class="form-group">
                <label for="capacity">السعة:</label>
                <input type="number" class="form-control" name="capacity" required>
            </div>
            <div class="form-group">
                <label for="price">السعر:</label>
                <input type="number" class="form-control" name="price" step="0.01" required>
            </div>
            <div class="form-group">
                <label for="location">موقع القاعة:</label>
                <input type="text" class="form-control" name="location" required>
            </div>
            <div class="form-group">
                <label for="image_url">رابط صورة القاعة:</label>
                <input type="url" class="form-control" name="image_url" required placeholder="http://example.com/image.jpg">
            </div>
            <div class="form-group">
                <label for="bank_account_number">رقم الحساب البنكي:</label>
                <input type="text" class="form-control" name="bank_account_number" required>
            </div>
            <div class="form-group">
                <label for="bank_name">اسم البنك:</label>
                <input type="text" class="form-control" name="bank_name" required>
            </div>
            <button type="submit" class="btn btn-primary">إضافة القاعة</button>
        </form>
    </div>

    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.5.2/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
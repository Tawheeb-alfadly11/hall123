<?php
session_start();
$conn = new mysqli('localhost', 'root', '', 'wedding_halls'); 

// تحقق من اتصال قاعدة البيانات
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// التحقق مما إذا تم إرسال البيانات
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // جمع البيانات من النموذج
    $service_name = $_POST['service_name'];
    $description = $_POST['description'];
    $price = $_POST['price'];
    $image = $_POST['image'];
    $hall_id = $_POST['hall_id'];

    // إدخال البيانات في جدول services
    $stmt = $conn->prepare("INSERT INTO services (service_name, description, price, image, hall_id) VALUES (?, ?, ?, ?, ?)");
    $stmt->bind_param("ssdsi", $service_name, $description, $price, $image, $hall_id);

    if ($stmt->execute()) {
        echo "تم إضافة الخدمة بنجاح!";
    } else {
        echo "خطأ: " . $stmt->error;
    }
    $stmt->close();
}

// استعلام لجلب جميع المحلات
$halls_result = $conn->query("SELECT * FROM halls");
?>

<!DOCTYPE html>
<html lang="ar">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>إضافة خدمة</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
</head>
<body>
    <div class="container">
        <h1 class="mt-5">إضافة خدمة جديدة لمحل</h1>
        <form action="" method="post" class="mt-4">
            <div class="form-group">
                <label for="service_name">اسم الخدمة:</label>
                <input type="text" class="form-control" name="service_name" required>
            </div>
            <div class="form-group">
                <label for="description">وصف الخدمة:</label>
                <textarea class="form-control" name="description" required></textarea>
            </div>
            <div class="form-group">
                <label for="price">السعر:</label>
                <input type="number" class="form-control" name="price" required>
            </div>
            <div class="form-group">
                <label for="image">رابط الصورة:</label>
                <input type="text" class="form-control" name="image" required>
                <small class="form-text text-muted">قم بإدخال رابط الصورة للخدمة (من الإنترنت).</small>
            </div>
            <div class="form-group">
                <label for="hall_id">اختر المحل:</label>
                <select class="form-control" name="hall_id" required>
                    <?php while ($hall = $halls_result->fetch_assoc()): ?>
                        <option value="<?php echo $hall['id'];?>"><?php echo htmlspecialchars($hall['name']);?></option>
                    <?php endwhile; ?>
                </select>
            </div>
            <button type="submit" class="btn btn-primary">إضافة الخدمة</button>
        </form>
    </div>
</body>
</html>

<?php
$conn->close();
?>
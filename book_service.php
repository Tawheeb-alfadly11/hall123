<?php
session_start();
$conn = new mysqli('localhost', 'root', '', 'wedding_halls'); 

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// استعلام لجلب جميع الخدمات
$services_result = $conn->query("SELECT * FROM services");

// استعلام لجلب جميع القاعات
$halls_result = $conn->query("SELECT * FROM halls");

// تحقق من إرسال البيانات للحجز
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $hall_id = $_POST['hall_id']; 
    $service_id = $_POST['service_id']; 
    $booking_date = $_POST['booking_date']; 
    $user_id = $_SESSION['user_id'];

    // إدخال الحجز في جدول bookings
    $stmt = $conn->prepare("INSERT INTO bookings (hall_id, service_id, booking_date, user_id) VALUES (?, ?, ?, ?)");
    $stmt->bind_param("iisi", $hall_id, $service_id, $booking_date, $user_id);

    if ($stmt->execute()) {
        echo "تم حجز الخدمة بنجاح!";
    } else {
        echo "خطأ: " . $stmt->error;
    }
    $stmt->close();
}
?>

<!DOCTYPE html>
<html lang="ar">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>حجز الخدمة</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
</head>
<body>
    <div class="container">
        <h1 class="mt-5">حجز خدمة</h1>
        <form action="" method="post" class="mt-4">
            <div class="form-group">
                <label for="service_id">اختر الخدمة:</label>
                <select class="form-control" name="service_id" required>
                    <?php while ($service = $services_result->fetch_assoc()): ?>
                        <option value="<?php echo $service['id']; ?>">
                            <?php echo htmlspecialchars($service['service_name']); ?> (<?php echo htmlspecialchars($service['price']); ?> د.إ)
                        </option>
                    <?php endwhile; ?>
                </select>
            </div>
            <div class="form-group">
                <label for="hall_id">اختر القاعة:</label>
                <select class="form-control" name="hall_id" required>
                    <?php while ($hall = $halls_result->fetch_assoc()): ?>
                        <option value="<?php echo $hall['id']; ?>"><?php echo htmlspecialchars($hall['name']); ?></option>
                    <?php endwhile; ?>
                </select>
            </div>
            <div class="form-group">
                <label for="booking_date">تاريخ الحجز:</label>
                <input type="date" class="form-control" name="booking_date" required>
            </div>
            <button type="submit" class="btn btn-primary">حجز الخدمة</button>
        </form>
    </div>
</body>
</html>

<?php
$conn->close();
?>
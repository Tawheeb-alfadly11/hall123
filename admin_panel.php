<?php
session_start();
$conn = new mysqli('localhost', 'root', '', 'wedding_halls');

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// تأكد من أن المستخدم هو المشرف
if (!isset($_SESSION['user_type']) || $_SESSION['user_type'] !== 'admin') {
    die("Access denied!");
}

// إدخال بيانات الأدمن إذا لم يكن موجودًا
$admin_username = 'ahmedessam'; 
$admin_password = '780730739'; 
$admin_email = 'ahmed.aladimi.2004@gmail.com'; 
$admin_user_type = 'admin'; 

// تحقق من وجود أدمن بالفعل
$stmt = $conn->prepare("SELECT * FROM users WHERE username = ?");
$stmt->bind_param("s", $admin_username);
$stmt->execute();
$stmt->store_result();

if ($stmt->num_rows == 0) {
    // تجزئة كلمة السر لضمان الأمان
    $hashed_password = password_hash($admin_password, PASSWORD_DEFAULT);

    // إدخال بيانات الأدمن
    $stmt = $conn->prepare("INSERT INTO users (username, password, email, user_type) VALUES (?, ?, ?, ?)");
    $stmt->bind_param("ssss", $admin_username, $hashed_password, $admin_email, $admin_user_type);
    if ($stmt->execute()) {
        echo "<div class='alert alert-success'>تم إضافة المستخدم بنجاح!</div>";
    } else {
        echo "<div class='alert alert-danger'>خطأ: " . $stmt->error . "</div>";
    }
}
$stmt->close();

// احصائيات
$halls_count = $conn->query("SELECT COUNT(*) FROM halls")->fetch_array()[0];
$bookings_count = $conn->query("SELECT COUNT(*) FROM bookings")->fetch_array()[0];
$users_count = $conn->query("SELECT COUNT(*) FROM users")->fetch_array()[0];
$reviews_count = $conn->query("SELECT COUNT(*) FROM reviews")->fetch_array()[0];
?>

<!DOCTYPE html>
<html lang="ar">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>لوحة التحكم</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <style>
        .metric { background-color: #f8f9fa; border-radius: 5px; padding: 20px; text-align: center; margin-bottom: 15px; }
    </style>
</head>
<body>
    <div class="container mt-5">
        <h2>لوحة التحكم</h2>
        <div class="row">
            <div class="col-md-3">
                <div class="metric">
                    <h4>عدد الصالات</h4>
                    <p><?php echo $halls_count; ?></p>
                </div>
            </div>
            <div class="col-md-3">
                <div class="metric">
                    <h4>عدد الحجوزات</h4>
                    <p><?php echo $bookings_count; ?></p>
                </div>
            </div>
            <div class="col-md-3">
                <div class="metric">
                    <h4>عدد المستخدمين</h4>
                    <p><?php echo $users_count; ?></p>
                </div>
            </div>
            <div class="col-md-3">
                <div class="metric">
                    <h4>عدد التقييمات</h4>
                    <p><?php echo $reviews_count; ?></p>
                </div>
            </div>
        </div>
        <h3 class="mt-4">إدارة الصالات</h3>
        <a href="add_hall.php" class="btn btn-success">إضافة قاعة جديدة</a>
        <a href="view_halls.php" class="btn btn-primary">عرض جميع الصالات</a>
        <h3 class="mt-4">إدارة المستخدمين</h3>
        <a href="view_users.php" class="btn btn-primary">عرض جميع المستخدمين</a>
        <h3 class="mt-4">إدارة التقييمات</h3>
        <a href="view_reviews.php" class="btn btn-primary">عرض جميع التقييمات</a>
        <a href="index.php" class="btn btn-dark mt-4">عودة إلى الصفحة الرئيسية</a>
    </div>
    
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.5.2/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>

<?php
$conn->close();
?>
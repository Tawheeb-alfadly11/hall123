<?php
session_start();
$conn = new mysqli('localhost', 'root', '', 'wedding_halls');

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// تحقق من أن المستخدم هو المشرف
if (!isset($_SESSION['user_type']) || $_SESSION['user_type'] !== 'admin') {
    die("Access denied!");
}

// استعلام لجلب جميع الصالات
$result = $conn->query("SELECT * FROM halls");
?>

<!DOCTYPE html>
<html lang="ar">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>عرض الصالات</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
</head>
<body>
    <div class="container mt-5">
        <h2>عرض الصالات</h2>
        <table class="table table-bordered">
            <thead>
                <tr>
                    <th>اسم القاعة</th>
                    <th>الموقع</th>
                    <th>السعة</th>
                    <th>السعر</th>
                    <th>صورة</th>
                    <th>الإجراءات</th>
                </tr>
            </thead>
            <tbody>
                <?php while ($row = $result->fetch_assoc()): ?>
                    <tr>
                        <td><?php echo htmlspecialchars($row['name']); ?></td>
                        <td><?php echo htmlspecialchars($row['location']); ?></td>
                        <td><?php echo htmlspecialchars($row['capacity']); ?></td>
                        <td><?php echo htmlspecialchars($row['price']); ?> د.إ</td>
                        <td><img src="<?php echo htmlspecialchars($row['image_path']); ?>" alt="<?php echo htmlspecialchars($row['name']); ?>" style="width: 100px;"></td>
                        <td>
                            <a href="edit_hall.php?id=<?php echo $row['id']; ?>" class="btn btn-warning">تعديل</a>
                            <a href="?delete=<?php echo $row['id']; ?>" class="btn btn-danger" onclick="return confirm('هل أنت متأكد أنك تريد حذف هذه القاعة؟')">حذف</a>
                        </td>
                    </tr>
                <?php endwhile; ?>
            </tbody>
        </table>
        <a href="admin_panel.php" class="btn btn-secondary mt-3">عودة إلى لوحة التحكم</a>
    </div>

    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.5.2/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>

<?php
$conn->close();
?>

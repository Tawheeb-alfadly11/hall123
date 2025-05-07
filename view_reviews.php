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

$result = $conn->query("SELECT reviews.*, halls.name AS hall_name, users.username AS user_name FROM reviews JOIN halls ON reviews.hall_id = halls.id JOIN users ON reviews.user_id = users.id");
?>

<!DOCTYPE html>
<html lang="ar">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>عرض التقييمات</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
</head>
<body>
    <div class="container mt-5">
        <h2>عرض التقييمات</h2>
        <table class="table table-bordered">
            <thead>
                <tr>
                    <th>اسم القاعة</th>
                    <th>اسم المستخدم</th>
                    <th>التقييم</th>
                    <th>التعليق</th>
                    <th>الإجراءات</th>
                </tr>
            </thead>
            <tbody>
                <?php while ($row = $result->fetch_assoc()): ?>
                    <tr>
                        <td><?php echo htmlspecialchars($row['hall_name']); ?></td>
                        <td><?php echo htmlspecialchars($row['user_name']); ?></td>
                        <td><?php echo htmlspecialchars($row['rating']); ?></td>
                        <td><?php echo htmlspecialchars($row['review']); ?></td>
                        <td>
                            <a href="delete_review.php?id=<?php echo $row['id']; ?>" class="btn btn-danger" onclick="return confirm('هل أنت متأكد أنك تريد حذف هذا التقييم؟')">حذف</a>
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
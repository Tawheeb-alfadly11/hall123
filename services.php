<?php
session_start();
$conn = new mysqli('localhost', 'root', '', 'wedding_halls');

// التحقق من نجاح الاتصال
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// استعلام للحصول على جميع الخدمات
$stmt = $conn->prepare("SELECT * FROM services");
$stmt->execute();
$result = $stmt->get_result();
?>

<!DOCTYPE html>
<html lang="ar">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>خدماتنا</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <link rel="stylesheet" href="style.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css"> <!-- إضافة Font Awesome -->
</head>
<body>
    <div class="container mt-5">
        <h1>خدماتنا</h1>
        <?php if ($result->num_rows > 0): ?>
            <ul class="list-group mt-4">
                <?php while ($row = $result->fetch_assoc()): ?>
                    <li class="list-group-item">
                        <h5><?php echo htmlspecialchars($row['name']); ?></h5>
                        <p><?php echo htmlspecialchars($row['description']); ?></p>
                        <p>السعر: <?php echo htmlspecialchars($row['price']); ?> د.إ</p>
                        <img src="<?php echo htmlspecialchars($row['image']); ?>" class="img-fluid" alt="<?php echo htmlspecialchars($row['name']); ?>">

                        <!-- زر عرض الصور -->
                        <button class="btn btn-primary" data-toggle="modal" data-target="#modalService<?php echo $row['id']; ?>">عرض الصور</button>

                        <!-- مودال لعرض مجموعة من الصور -->
                        <div class="modal fade" id="modalService<?php echo $row['id']; ?>" tabindex="-1" role="dialog">
                            <div class="modal-dialog" role="document">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h5 class="modal-title">صور الخدمة: <?php echo htmlspecialchars($row['name']); ?></h5>
                                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                            <span aria-hidden="true">&times;</span>
                                        </button>
                                    </div>
                                    <div class="modal-body">
                                        <?php
                                        // استعلام للحصول على صور الخدمة
                                        $service_id = $row['id'];
                                        $images_stmt = $conn->prepare("SELECT * FROM service_images WHERE service_id = ?");
                                        $images_stmt->bind_param("i", $service_id);
                                        $images_stmt->execute();
                                        $images_result = $images_stmt->get_result();
                                        while ($image_row = $images_result->fetch_assoc()):
                                        ?>
                                            <img src="<?php echo htmlspecialchars($image_row['image_url']); ?>" class="img-fluid" alt="صورة الخدمة">
                                        <?php endwhile; ?>
                                    </div>
                                    <div class="modal-footer">
                                        <button type="button" class="btn btn-secondary" data-dismiss="modal">إغلاق</button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </li>
                <?php endwhile; ?>
            </ul>
        <?php else: ?>
            <p>لا توجد خدمات متاحة حاليًا.</p>
        <?php endif; ?>
    </div>

    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.5.2/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>

<?php
$stmt->close();
$conn->close();
?>

<?php
session_start();
$conn = new mysqli('localhost', 'root', '', 'wedding_halls');

if (!isset($_SESSION['user_id']) || !isset($_GET['hall_id'])) {
    header("Location: login.php");
    exit();
}

$user_id = $_SESSION['user_id'];
$hall_id = $_GET['hall_id'];

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $rating = $_POST['rating'];
    $review = $_POST['review'];

    $stmt = $conn->prepare("INSERT INTO reviews (hall_id, user_id, rating, review) VALUES (?, ?, ?, ?)");
    $stmt->bind_param("iiis", $hall_id, $user_id, $rating, $review);
    if ($stmt->execute()) {
        echo "تم إضافة التقييم بنجاح!";
    } else {
        echo "خطأ: " . $stmt->error;
    }
}
?>

<!DOCTYPE html>
<html lang="ar">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>إضافة تقييم</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
</head>
<body>
    <div class="container">
        <h1>أضف تقييمك للقاعة</h1>
        <form action="" method="post">
            <input type="hidden" name="hall_id" value="<?php echo $hall_id; ?>">
            <div class="form-group">
                <label for="rating">تقييم:</label>
                <select class="form-control" name="rating" required>
                    <option value="1">1 نجمة</option>
                    <option value="2">2 نجوم</option>
                    <option value="3">3 نجوم</option>
                    <option value="4">4 نجوم</option>
                    <option value="5">5 نجوم</option>
                </select>
            </div>
            <div class="form-group">
                <label for="review">التعليق:</label>
                <textarea class="form-control" name="review" required></textarea>
            </div>
            <button type="submit" class="btn btn-primary">إرسال التقييم</button>
        </form>
        <h2 class="mt-5">تقييمات القاعة:</h2>
        <ul class="list-group">
            <?php
            $result_reviews = $conn->query("SELECT r.rating, r.review, u.username FROM reviews r JOIN users u ON r.user_id = u.id WHERE r.hall_id = $hall_id");
            while ($review = $result_reviews->fetch_assoc()) {
                echo "<li class='list-group-item'>{$review['username']} - {$review['rating']} نجوم: {$review['review']}</li>";
            }
            ?>
        </ul>
    </div>
</body>
</html>

<?php
$conn->close();
?>

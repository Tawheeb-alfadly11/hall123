<?php
session_start();
$conn = new mysqli('localhost', 'root', '', 'wedding_halls');

if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

$user_id = $_SESSION['user_id'];

$stmt = $conn->prepare("SELECT 
    b.id, 
    b.booking_date, 
    h.name AS hall_name, 
    b.amount_paid 
FROM bookings b 
JOIN halls h ON b.hall_id = h.id 
WHERE b.user_id = ?");
$stmt->bind_param("i", $user_id);
$stmt->execute();
$result = $stmt->get_result();
?>

<!DOCTYPE html>
<html lang="ar">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>حجوزاتك</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
</head>
<body>
    <div class="container mt-5">
        <h1>حجوزاتك</h1>
        <table class="table mt-4">
            <thead>
                <tr>
                    <th>رقم الحجز</th>
                    <th>اسم القاعة</th>
                    <th>تاريخ الحجز</th>
                    <th>المبلغ المدفوع</th>
                </tr>
            </thead>
            <tbody>
                <?php while ($row = $result->fetch_assoc()): ?>
                    <tr>
                        <td><?= htmlspecialchars($row['id']) ?></td>
                        <td><?= htmlspecialchars($row['hall_name']) ?></td>
                        <td><?= htmlspecialchars($row['booking_date']) ?></td>
                        <td><?= htmlspecialchars($row['amount_paid']) ?> د.إ</td>
                    </tr>
                <?php endwhile; ?>
            </tbody>
        </table>
    </div>
</body>
</html>

<?php
$stmt->close();
$conn->close();
?>
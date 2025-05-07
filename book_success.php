<?php
session_start();
if (!isset($_SESSION['booking_success'])) {
    header("Location: index.php");
    exit();
}
?>

<!DOCTYPE html>
<html lang="ar">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>تم الحجز بنجاح</title>
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
    <div class="container mt-5">
        <div class="alert alert-success text-center">
            <h2><?= htmlspecialchars($_SESSION['booking_success']) ?></h2>
            <p>سيتم إرسال تأكيد الحجز إلى بريدك الإلكتروني قريباً.</p>
            <a href="index.php" class="btn btn-primary mt-3">العودة إلى الصفحة الرئيسية</a>
        </div>
    </div>
</body>
</html>

<?php
unset($_SESSION['booking_success']);
?>
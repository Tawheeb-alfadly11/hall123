<?php
session_start(); // بدء الجلسة

$conn = new mysqli('localhost', 'root', '', 'wedding_halls'); // إعداد معلومات قاعدة البيانات
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// الدالة لإرسال رسالة التأكيد عبر البريد الإلكتروني
function sendEmailConfirmation($email) {
    require 'src/PHPMailer.php'; // إضافة مكتبة PHPMailer
    require 'src/SMTP.php';
    require 'src/Exception.php';

    $mail = new PHPMailer\PHPMailer\PHPMailer();
    
    try {
        $mail->isSMTP();
        $mail->Host = 'smtp.example.com'; // استبدال هذا بالخادم المناسب
        $mail->SMTPAuth = true;
        $mail->Username = 'your_email@example.com'; // البريد الإلكتروني المستخدم
        $mail->Password = 'your_email_password'; // كلمة المرور
        $mail->SMTPSecure = 'tls'; // أو 'ssl'
        $mail->Port = 587; // أو 465 إذا كنت تستخدم ssl

        // إعداد المستلم
        $mail->setFrom('your_email@example.com', 'Wedding Halls');
        $mail->addAddress($email); // البريد الإلكتروني الخاص بالمستخدم
        $mail->Subject = 'تأكيد البريد الإلكتروني';

        // رابط التأكيد
        $activation_link = "http://localhost/wedding_halls/activate.php?email=$email&code=" . md5($email);
        $mail->Body = "يرجى النقر على الرابط لتأكيد بريدك الإلكتروني: $activation_link";

        $mail->send();
    } catch (Exception $e) {
        echo "لم تتمكن من إرسال بريد التأكيد. {$mail->ErrorInfo}";
    }
}

// معالجة بيانات التسجيل
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = $_POST['username'];
    $password = $_POST['password'];
    $email = $_POST['email'];
    $user_type = $_POST['user_type']; // نوع المستخدم

    // تحقق مما إذا كان اسم المستخدم أو البريد الإلكتروني موجودًا بالفعل
    $stmt = $conn->prepare("SELECT * FROM users WHERE username = ? OR email = ?");
    $stmt->bind_param("ss", $username, $email);
    $stmt->execute();
    $stmt->store_result();

    if ($stmt->num_rows > 0) {
        echo "اسم المستخدم أو البريد الإلكتروني موجود بالفعل.";
    } else {
        // إدخال بيانات المستخدم
        $hashed_password = password_hash($password, PASSWORD_DEFAULT); // تجزئة كلمة المرور
        $stmt = $conn->prepare("INSERT INTO users (username, password, email, user_type) VALUES (?, ?, ?, ?)");
        $stmt->bind_param("ssss", $username, $hashed_password, $email, $user_type);

        if ($stmt->execute()) {
            sendEmailConfirmation($email); // إرسال بريد التأكيد
            echo "تم التسجيل بنجاح! يرجى التحقق من بريدك الإلكتروني لتأكيد الحساب.";
        } else {
            echo "خطأ: " . $stmt->error;
        }
    }

    $stmt->close(); // إغلاق الاستعلام
}

$conn->close(); // إغلاق الاتصال بقاعدة البيانات
?>

<!DOCTYPE html>
<html lang="ar">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>تسجيل مستخدم جديد</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
</head>
<body>
    <div class="container mt-5">
        <h2>تسجيل مستخدم جديد</h2>
        <form action="register.php" method="POST">
            <div class="form-group">
                <label for="username">اسم المستخدم:</label>
                <input type="text" class="form-control" name="username" required>
            </div>
            <div class="form-group">
                <label for="password">كلمة السر:</label>
                <input type="password" class="form-control" name="password" required>
            </div>
            <div class="form-group">
                <label for="email">البريد الإلكتروني:</label>
                <input type="email" class="form-control" name="email" required>
            </div>
            <div class="form-group">
                <label for="user_type">نوع المستخدم:</label>
                <select class="form-control" name="user_type" required>
                    <option value="regular_user">مستخدم عادي</option>
                    <option value="service_provider">مزود خدمة</option>
                </select>
            </div>
            <button type="submit" class="btn btn-primary">تسجيل</button>
        </form>
        <p class="mt-3">لديك حساب بالفعل؟ <a href="login.php">تسجيل الدخول</a></p>
    </div>

    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.5.2/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
<?php
session_start();
$conn = new mysqli('localhost', 'root', '', 'wedding_halls');

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = $_POST['username'];
    $password = $_POST['password'];

    // استعلام لجلب بيانات المستخدم
    $stmt = $conn->prepare("SELECT id, password, user_type FROM users WHERE username = ?");
    $stmt->bind_param("s", $username);
    $stmt->execute();
    $stmt->store_result();

    if ($stmt->num_rows > 0) {
        $stmt->bind_result($user_id, $hashed_password, $user_type);
        $stmt->fetch();

        // تحقق من كلمة المرور
        if (password_verify($password, $hashed_password)) {
            $_SESSION['username'] = $username;
            $_SESSION['user_id'] = $user_id;
            $_SESSION['user_type'] = $user_type;

            setcookie("username", $username, time() + (86400 * 30), "/");
            setcookie("user_type", $user_type, time() + (86400 * 30), "/");

            if ($user_type == 'admin') {
                header("Location: admin_panel.php");
            } elseif ($user_type == 'service_provider') {
                header("Location: service_provider.php");
            } else {
                header("Location: index.php");
            }
            exit();
        } else {
            echo "كلمة السر غير صحيحة.";
        }
    } else {
        echo "اسم المستخدم غير صحيح.";
    }

    $stmt->close();
}
?>

<!DOCTYPE html>
<html lang="ar">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>تسجيل الدخول</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
</head>
<body>
    <div class="container mt-5">
        <h2>تسجيل الدخول</h2>
        <form action="login.php" method="POST">
            <div class="form-group">
                <label for="username">اسم المستخدم:</label>
                <input type="text" class="form-control" name="username" required>
            </div>
            <div class="form-group">
                <label for="password">كلمة السر:</label>
                <input type="password" class="form-control" name="password" required>
            </div>
            <button type="submit" class="btn btn-primary">تسجيل الدخول</button>
        </form>
        <p class="mt-3">ليس لديك حساب؟ <a href="register.php">التسجيل</a></p>
    </div>

    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.5.2/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
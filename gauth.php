<?php
require 'vendor/autoload.php'; // تأكد من وجود مكتبة Google Client

$client = new Google_Client();
$client->setClientId('YOUR_CLIENT_ID'); // استبدل بـ Client ID الخاص بك
$client->setClientSecret('YOUR_CLIENT_SECRET'); // استبدل بـ Client Secret الخاص بك

$id_token = $_POST['id_token'];

// تحقق من صحة التوكن
$ticket = $client->verifyIdToken($id_token);
if ($ticket) {
    $data = $ticket; // يحتوي على معلومات المستخدم (مثل: email, name)
    $email = $data['email'];

    // تسجيل الدخول، تحقق مما إذا كان المستخدم موجودًا بالفعل
    $conn = new mysqli('localhost', 'root', '', 'wedding_halls'); // الاتصال بقاعدة البيانات
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    $stmt = $conn->prepare("SELECT * FROM users WHERE email = ?");
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $stmt->store_result();

    if ($stmt->num_rows > 0) {
        // المستخدم موجود، قم بإعداد الجلسة وتسجيل الدخول
        $stmt->fetch();
        $_SESSION['user_id'] = $user['id']; 
        $_SESSION['email'] = $email; 
        echo "success"; // استجابة بنجاح
    } else {
        // إذا لم يكن موجودًا، قم بإضافته إلى قاعدة البيانات
        $username = $data['name'];
        $hashed_password = password_hash(uniqid(), PASSWORD_DEFAULT); // إنشاء كلمة مرور مؤقتة
        
        $stmt = $conn->prepare("INSERT INTO users (username, password, email, user_type) VALUES (?, ?, ?, 'regular_user')");
        $stmt->bind_param("sss", $username, $hashed_password, $email);
        $stmt->execute();
        
        $_SESSION['user_id'] = $stmt->insert_id; 
        $_SESSION['email'] = $email; 
        echo "success"; // استجابة بنجاح
    }

    $stmt->close();
    $conn->close();
} else {
    echo "فشلت عملية التحقق من التوكن.";
}
?>
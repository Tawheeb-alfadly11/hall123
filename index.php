<?php
session_start();
$conn = new mysqli('localhost', 'root', '', 'wedding_halls');

if ($conn->connect_error) {
    die("فشل الاتصال: " . $conn->connect_error);
}
?>

<!DOCTYPE html>
<html lang="ar">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>حجز صالات الأعراس</title>
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/4.1.1/animate.min.css"/>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.css">
    <style>
        /* styles here... */
        body {
            font-family: 'Arial', sans-serif;
        }
        .navbar {
            background: linear-gradient(45deg, #007bff, #28a745);
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
            border-radius: 0;
        }
        .navbar-brand {
            font-weight: bold;
            font-size: 1.5rem;
            color: white;
        }
        .nav-link {
            color: white !important;
            transition: background-color 0.3s;
        }
        .nav-link:hover {
            background-color: #0056b3;
            border-radius: 5px;
        }
        .welcome-banner {
            background-color: #28a745;
            color: white;
            padding: 10px 0;
            text-align: center;
            border-radius: 10px;
        }
        .card {
            transition: transform 0.3s;
            border-radius: 10px;
            overflow: hidden;
            margin-bottom: 20px;
        }
        .card:hover {
            transform: scale(1.05);
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        }
        .card-img-top {
            height: 250px;
            object-fit: cover;
        }
        .card-body {
            padding: 15px;
        }
        .service-box {
            background-color: #007bff;
            color: white;
            border-radius: 10px;
            padding: 20px;
            margin: 10px;
            text-align: center;
            transition: transform 0.3s;
        }
        .service-box:hover {
            transform: scale(1.05);
        }
        .star-rating {
            direction: rtl;
            display: inline-block;
            font-size: 24px;
            color: #ccc;
        }
        .star-rating input {
            display: none;
        }
        .star-rating label {
            cursor: pointer;
        }
        .star-rating input:checked ~ label {
            color: #f39c12;
        }
        .star-rating label:hover,
        .star-rating label:hover ~ label {
            color: #f39c12;
        }
        .footer {
            background-color: #343a40;
            color: white;
            padding: 20px;
            text-align: center;
        }
    </style>
</head>
<body>
    <!-- Navbar -->
    <nav class="navbar navbar-expand-lg navbar-light">
        <a class="navbar-brand" href="index.php">حجز صالات الأعراس</a>
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarNav">
            <ul class="navbar-nav ml-auto">
                <li class="nav-item">
                    <a class="nav-link" href="index.php">الرئيسية</a>
                </li>
                <?php if (isset($_SESSION['username'])): ?>
                    <li class="nav-item">
                        <a class="nav-link" href="logout.php">تسجيل الخروج</a>
                    </li>
                <?php else: ?>
                    <li class="nav-item">
                        <a class="nav-link" href="login.php">تسجيل الدخول</a>
                    </li>
                <?php endif; ?>
                <li class="nav-item">
                    <a class="nav-link" href="#services">خدماتنا</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="#contact">تواصل معنا</a>
                </li>
            </ul>
        </div>
    </nav>

    <!-- Welcome Banner -->
    <div class="welcome-banner">
        <?php if (isset($_SESSION['username'])): ?>
            <p>مرحباً بك، <?php echo htmlspecialchars($_SESSION['username']); ?>! استمتع بحجز قاعتك!</p>
        <?php else: ?>
            <p>مرحباً بك في موقع حجوزات صالات الأعراس!</p>
        <?php endif; ?>
    </div>

    <!-- Halls List -->
    <div class="container mt-5">
        <h2 class="text-center mb-4"> صالات الأعراس</h2>
        <div class="row">
            <?php
            $result = $conn->query("SELECT * FROM halls");
            if ($result && $result->num_rows > 0) {
                while ($row = $result->fetch_assoc()) {
                    echo '<div class="col-md-4 mb-4">';
                    echo '<div class="card">';
                    if (!empty($row['image_url'])) {
                        echo '<img src="' . htmlspecialchars($row['image_url']) . '" class="card-img-top" alt="' . htmlspecialchars($row['name']) . '">';
                    } else {
                        echo '<div class="card-img-top" style="background-color: #ccc; display: flex; align-items: center; justify-content: center; color: white; font-size: 24px;">لا توجد صورة</div>';
                    }
                    echo '<div class="card-body">';
                    echo '<h5 class="card-title">' . htmlspecialchars($row['name']) . '</h5>';
                    echo '<p class="card-text">الموقع: ' . htmlspecialchars($row['location']) . '</p>';
                    echo '<p class="card-text">السعة: ' . htmlspecialchars($row['capacity']) . '</p>';
                    echo '<p class="card-text">السعر: ' . htmlspecialchars($row['price']) . ' د.إ</p>';

                    // Rating Stars
                    echo '<div class="star-rating">';
                    echo '<input type="radio" id="star5-' . $row['id'] . '" name="rating-' . $row['id'] . '" value="5" /><label for="star5-' . $row['id'] . '">★</label>';
                    echo '<input type="radio" id="star4-' . $row['id'] . '" name="rating-' . $row['id'] . '" value="4" /><label for="star4-' . $row['id'] . '">★</label>';
                    echo '<input type="radio" id="star3-' . $row['id'] . '" name="rating-' . $row['id'] . '" value="3" /><label for="star3-' . $row['id'] . '">★</label>';
                    echo '<input type="radio" id="star2-' . $row['id'] . '" name="rating-' . $row['id'] . '" value="2" /><label for="star2-' . $row['id'] . '">★</label>';
                    echo '<input type="radio" id="star1-' . $row['id'] . '" name="rating-' . $row['id'] . '" value="1" /><label for="star1-' . $row['id'] . '">★</label>';
                    echo '</div>';

                    // Buttons
                    echo '<a href="book.php?id=' . $row['id'] . '" class="btn btn-primary mt-2">حجز الآن</a>';
                    echo '<a href="reviews.php?hall_id=' . $row['id'] . '" class="btn btn-secondary mt-2">أضف تقييم</a>';
                    echo '</div></div></div>';
                }
            } else {
                echo '<div class="col-md-12">';
                echo '<div class="alert alert-info text-center">لا توجد صالات متاحة حالياً.</div>';
                echo '</div>';
            }
            ?>
        </div>
    </div>

    <!-- Services Section -->
    <div class="container mt-5" id="services">
        <h2 class="text-center mb-4">خدماتنا</h2>
        <div class="row justify-content-center">
            <div class="col-md-3 service-box mb-4">
                <div class="card-body">
                    <i class="fas fa-gift fa-2x text-white mb-3"></i>
                    <h5 class="card-title">تنسيق الحفلات</h5>
                    <p class="card-text">نقدم خدمات تنسيق الحفلات الفاخرة.</p>
                </div>
            </div>
            <div class="col-md-3 service-box mb-4">
                <div class="card-body">
                    <i class="fas fa-lightbulb fa-2x text-white mb-3"></i>
                    <h5 class="card-title">الإضاءة والصوت</h5>
                    <p class="card-text">أنظمة إضاءة وصوت حديثة.</p>
                </div>
            </div>
            <div class="col-md-3 service-box mb-4">
                <div class="card-body">
                    <i class="fas fa-camera fa-2x text-white mb-3"></i>
                    <h5 class="card-title">خدمات التصوير</h5>
                    <p class="card-text">تصوير فوتوغرافي وفيديو عالي الجودة.</p>
                </div>
            </div>
        </div>
    </div>

    <!-- Contact Section -->
    <div class="container mt-5" id="contact">
        <h2 class="text-center mb-4">تواصل معنا</h2>
        <p class="text-center">لأي استفسارات، يمكنك التواصل معنا على:</p>
        <ul class="list-group list-group-flush">
            <?php
            $contact_result = $conn->query("SELECT * FROM contact_info LIMIT 1");
            if ($contact_result && $contact_result->num_rows > 0) {
                $contact_info = $contact_result->fetch_assoc();
                ?>
                <li class="list-group-item d-flex align-items-center">
                    <i class="fas fa-phone mr-3"></i>
                    <a href="tel:<?php echo htmlspecialchars($contact_info['phone']); ?>" class="text-dark">
                        <strong>الهاتف:</strong> <?php echo htmlspecialchars($contact_info['phone']); ?>
                    </a>
                </li>
                <li class="list-group-item d-flex align-items-center">
                    <i class="fab fa-whatsapp mr-3"></i>
                    <a href="https://wa.me/<?php echo htmlspecialchars($contact_info['whatsapp']); ?>" target="_blank" class="text-dark">
                        <strong>الواتساب:</strong> <?php echo htmlspecialchars($contact_info['whatsapp']); ?>
                    </a>
                </li>
                <li class="list-group-item d-flex align-items-center">
                    <i class="fas fa-envelope mr-3"></i>
                    <a href="mailto:<?php echo htmlspecialchars($contact_info['email']); ?>" class="text-dark">
                        <strong>البريد الإلكتروني:</strong> <?php echo htmlspecialchars($contact_info['email']); ?>
                    </a>
                </li>
            <?php } else { ?>
                <li class="list-group-item">لا توجد معلومات للتواصل.</li>
            <?php } ?>
        </ul>
    </div>

    <!-- Footer -->
    <footer class="footer mt-5">
        <p>© 2025 جميع الحقوق محفوظة - موقع حجز صالات الأعراس</p>
    </footer>

    <!-- Scripts -->
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.5.2/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js"></script>
    <script>
        $(document).ready(function() {
            // Show booking success message
            <?php if (isset($_SESSION['booking_success'])): ?>
                toastr.success("<?php echo $_SESSION['booking_success']; ?>");
                <?php unset($_SESSION['booking_success']); ?>
            <?php endif; ?>

            // Star rating hover effect
            $('.star-rating label').on('mouseover', function() {
                $(this).prevAll().addClass('hover');
                $(this).nextAll().removeClass('hover');
            }).on('mouseout', function() {
                $(this).prevAll().removeClass('hover');
            });

            // Prevent multiple submissions
            $('form').submit(function() {
                $(this).find('button[type="submit"]').prop('disabled', true);
            });
        });
    </script>
</body>
</html>

<?php
$conn->close();
?>

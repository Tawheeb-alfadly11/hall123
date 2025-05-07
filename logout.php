<?php
session_start();
session_unset();
session_destroy(); // تدمير الجلسة
header("Location: index.php");
exit();
?>
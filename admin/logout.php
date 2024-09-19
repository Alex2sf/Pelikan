<?php
session_start(); // Mulai sesi
session_destroy(); // Mengakhiri semua sesi
header("Location: admin_login.php"); // Arahkan ke halaman login setelah logout
exit;
?>

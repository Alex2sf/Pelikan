<?php
session_start(); // Memulai sesi

// Menghentikan semua sesi
session_unset(); // Menghapus semua variabel sesi
session_destroy(); // Menghancurkan sesi

// Mengarahkan pengguna ke halaman login atau halaman lain
header("Location: ../login_new.php");
exit(); // Pastikan skrip berhenti berjalan
?>

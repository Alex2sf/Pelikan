<?php
// Detail koneksi database
$host = "localhost"; // Nama host, biasanya "localhost"
$username = "root"; // Username database
$password = ""; // Password database, biasanya kosong untuk local server
$database = "sigh"; // Nama database yang akan digunakan

// Membuat koneksi
$conn = new mysqli($host, $username, $password, $database);

// Cek koneksi
if ($conn->connect_error) {
    die("Koneksi gagal: " . $koneksi->connect_error);
} else {
}
?>
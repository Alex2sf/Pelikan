<?php
session_start();
include '../koneksi.php';

// Periksa apakah pengguna sudah login dan memiliki peran penilai
if (!isset($_SESSION['id_akun']) || $_SESSION['role'] != 'penilai') {
    header("Location: login.php");  // Redirect jika tidak login atau bukan penilai
    exit();
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $id_organisasi = $_POST['id_organisasi'];
    $nilai = $_POST['nilai'];
    $catatan = $_POST['catatan'];
    $id_penilai = $_SESSION['id_akun'];  // Ambil id_penilai dari session

    // Simpan penilaian ke database
    $query = "INSERT INTO kuesioner (id_organisasi, nilai, catatan, id_penilai) 
              VALUES (:id_organisasi, :nilai, :catatan, :id_penilai)";
    $stmt = $pdo->prepare($query);
    $stmt->bindParam(':id_organisasi', $id_organisasi);
    $stmt->bindParam(':nilai', $nilai);
    $stmt->bindParam(':catatan', $catatan);
    $stmt->bindParam(':id_penilai', $id_penilai);
    
    if ($stmt->execute()) {
        // Redirect ke halaman sukses atau daftar organisasi lagi
        header("Location: list_organisasi.php");
    } else {
        echo "Gagal menyimpan penilaian.";
    }
}
?>

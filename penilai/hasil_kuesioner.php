<?php
session_start();
include '../koneksi.php';

// Periksa apakah pengguna sudah login dan memiliki peran penilai
if (!isset($_SESSION['id_akun']) || $_SESSION['role'] != 'penilai') {
    header("Location: login.php");  // Redirect jika tidak login atau bukan penilai
    exit();
}

if (isset($_GET['id_organisasi'])) {
    $id_organisasi = $_GET['id_organisasi'];

    // Query untuk mendapatkan total nilai yang sudah disubmit
    $query = "SELECT total_nilai FROM organisasi WHERE id_organisasi = :id_organisasi";
    $stmt = $pdo->prepare($query);
    $stmt->bindParam(':id_organisasi', $id_organisasi);
    $stmt->execute();
    $result = $stmt->fetch(PDO::FETCH_ASSOC);

    if ($result) {
        $total_nilai = $result['total_nilai'];
    } else {
        $total_nilai = 0;
    }
} else {
    // Jika id_organisasi tidak ditemukan, arahkan ke halaman lain atau tampilkan pesan error
    header("Location: list_organisasi.php");
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Hasil Kuesioner</title>
</head>
<body>
    <h1>Hasil Kuesioner untuk Organisasi</h1>
    <p>Total Nilai: <?php echo $total_nilai; ?></p>

    <!-- Tampilkan hasil penilaian lainnya jika diperlukan -->
</body>
</html>

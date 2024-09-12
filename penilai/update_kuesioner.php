<?php
// session_start();
// if (!isset($_SESSION['id_akun']) || $_SESSION['role'] != 'penilai') {
//     header("Location: login_penilai.php");
//     exit();
// }

$conn = new mysqli('localhost', 'root', '', 'emone'); // Ganti dengan kredensial database Anda

$id_akun = $_SESSION['id_akun'];

// Ambil detail penilai dan akses ke organisasi
$sql = "SELECT id_penilai FROM Profile_Penilai WHERE id_akun='$id_akun'";
$result = $conn->query($sql);
$row = $result->fetch_assoc();
$id_penilai = $row['id_penilai'];

foreach ($_POST['update'] as $id_kuesioner => $update) {
    $nilai = $_POST['nilai'][$id_kuesioner];
    $catatan = $_POST['catatan'][$id_kuesioner];
    $verifikasi = isset($_POST['verifikasi'][$id_kuesioner]) ? 1 : 0;

    $sql = "UPDATE Kuesioner SET nilai='$nilai', catatan='$catatan', verifikasi='$verifikasi' WHERE id_kuesioner='$id_kuesioner' AND id_penilai='$id_penilai'";
    
    if ($conn->query($sql) !== TRUE) {
        echo "Error: " . $conn->error;
    }
}

header("Location: penilai_dashboard.php");
exit();

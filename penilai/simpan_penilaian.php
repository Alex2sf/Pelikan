<?php
session_start();

// Cek apakah pengguna sudah login dan memiliki hak sebagai penilai
if (!isset($_SESSION['id_akun']) || $_SESSION['role'] != 'penilai') {
    header("Location: login_penilai.php");
    exit();
}

// Koneksi ke database
include '../koneksi.php';


// Cek apakah form telah disubmit
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $id_organisasi = $_POST['id_organisasi'];
    
    // Ambil nilai kategori dari form
    $nilai_kategori1 = $_POST['nilai_kategori1'];
    $nilai_kategori2 = $_POST['nilai_kategori2'];
    $nilai_kategori3 = $_POST['nilai_kategori3'];
    $nilai_kategori4 = $_POST['nilai_kategori4'];
    $nilai_kategori5 = $_POST['nilai_kategori5'];

    // Update nilai di tabel organisasi
    $sql = "UPDATE organisasi 
            SET nilai_kategori1 = ?, nilai_kategori2 = ?, nilai_kategori3 = ?, nilai_kategori4 = ?, nilai_kategori5 = ?
            WHERE id_organisasi = ?";

    $stmt = $conn->prepare($sql);
    if ($stmt === false) {
        die("Error in preparing statement: " . $conn->error);
    }

    // Bind parameter
    $stmt->bind_param("iiiiii", $nilai_kategori1, $nilai_kategori2, $nilai_kategori3, $nilai_kategori4, $nilai_kategori5, $id_organisasi);

    // Eksekusi statement
    if ($stmt->execute()) {
        echo "Penilaian berhasil disimpan.";
        header("Location: penilai_beranda.php"); // Redirect ke halaman beranda atau halaman lain setelah berhasil menyimpan
        exit();
    } else {
        echo "Error: " . $stmt->error;
    }

    $stmt->close();
} else {
    echo "Invalid request method.";
}

// Tutup koneksi database
$conn->close();
?>

<?php
// Mulai sesi
session_start();

// Koneksi ke database
$conn = new mysqli('localhost', 'root', '', 'emone'); // Ganti dengan kredensial database Anda

// Cek koneksi database
if ($conn->connect_error) {
    die("Koneksi gagal: " . $conn->connect_error);
}

// Cek jika id_kategori di-set
if (isset($_GET['id_kategori']) && !empty($_GET['id_kategori'])) {
    $id_kategori = $_GET['id_kategori'];

    // Query untuk mengambil data berdasarkan kategori
    $sql = "SELECT P.pertanyaan, K.kategori, SK1.subkategori1, SK2.subkategori2, SK3.subkategori3, P.bobot, P.web 
            FROM Pertanyaan P 
            JOIN Kategori K ON P.id_kategori = K.id_kategori
            JOIN SubKategori1 SK1 ON P.id_subkategori1 = SK1.id_subkategori1
            JOIN SubKategori2 SK2 ON P.id_subkategori2 = SK2.id_subkategori2
            JOIN SubKategori3 SK3 ON P.id_subkategori3 = SK3.id_subkategori3
            WHERE P.id_kategori = '$id_kategori'";

    $result = $conn->query($sql);

    // Set header untuk file Excel
    header('Content-Type: application/vnd.ms-excel');
    header('Content-Disposition: attachment; filename="data_kuesioner.xls"');

    // Output header tabel
    echo "Pertanyaan\tKategori\tSubkategori 1\tSubkategori 2\tSubkategori 3\tBobot\tWeb\n";

    // Cek dan output data
    if ($result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
            echo "{$row['pertanyaan']}\t{$row['kategori']}\t{$row['subkategori1']}\t{$row['subkategori2']}\t{$row['subkategori3']}\t{$row['bobot']}\t{$row['web']}\n";
        }
    } else {
        echo "Tidak ada data untuk kategori ini.";
    }
}

$conn->close();
exit();
?>

<?php
session_start();
require '../koneksi.php'; // Menghubungkan ke database

if (isset($_GET['id_organisasi'])) {
    $id_organisasi = $_GET['id_organisasi'];
    
    // Query untuk menghitung total nilai per kategori untuk organisasi tertentu
    $totalNilaiQuery = "SELECT k.id_kategori, SUM(k.nilai) AS total_nilai, cat.kategori
                        FROM kuesioner k
                        JOIN kategori cat ON k.id_kategori = cat.id_kategori
                        WHERE k.id_organisasi = ? AND k.verifikasi = 1
                        GROUP BY k.id_kategori";

    // Mempersiapkan statement
    $stmtTotalNilai = $conn->prepare($totalNilaiQuery);
    $stmtTotalNilai->bind_param('i', $id_organisasi);
    $stmtTotalNilai->execute();
    $resultTotalNilai = $stmtTotalNilai->get_result();

    echo "<h3>Nilai Per Kategori:</h3>";
    
    // Melakukan iterasi dan menampilkan hasil total nilai per kategori
    while ($rowTotal = $resultTotalNilai->fetch_assoc()) {
        $kategoriId = $rowTotal['id_kategori'];
        $totalNilai = $rowTotal['total_nilai'];
        $kategoriNama = $rowTotal['kategori'];
        
        // Menampilkan hasil total nilai per kategori
        echo "KATEGORI " . $kategoriNama . " = " . number_format($totalNilai, 2) . "<br>";
    
        // Query untuk mengupdate nilai kategori di tabel organisasi berdasarkan id_organisasi
        $updateNilaiQuery = "";

        // Menentukan kolom nilai berdasarkan id_kategori
        switch ($kategoriId) {
            case 1:
                $updateNilaiQuery = "UPDATE organisasi SET nilai_kategori1 = ? WHERE id_organisasi = ?";
                break;
            case 2:
                $updateNilaiQuery = "UPDATE organisasi SET nilai_kategori2 = ? WHERE id_organisasi = ?";
                break;
            case 3:
                $updateNilaiQuery = "UPDATE organisasi SET nilai_kategori3 = ? WHERE id_organisasi = ?";
                break;
            case 4:
                $updateNilaiQuery = "UPDATE organisasi SET nilai_kategori4 = ? WHERE id_organisasi = ?";
                break;
            case 5:
                $updateNilaiQuery = "UPDATE organisasi SET nilai_kategori5 = ? WHERE id_organisasi = ?";
                break;
            case 6:
                $updateNilaiQuery = "UPDATE organisasi SET nilai_kategori6 = ? WHERE id_organisasi = ?";
                break;
            default:
                // Jika tidak ada kategori yang sesuai
                echo "Kategori tidak ditemukan!";
                break;
        }

        // Pastikan bahwa query update tidak kosong
        if (!empty($updateNilaiQuery)) {
            // Mempersiapkan statement untuk update
            $stmtUpdateNilai = $conn->prepare($updateNilaiQuery);
            
            // Bind parameter, nilai dan id_organisasi
            $stmtUpdateNilai->bind_param('di', $totalNilai, $id_organisasi);
            
            // Menjalankan query update
            if ($stmtUpdateNilai->execute()) {
                echo "Nilai untuk kategori $kategoriNama berhasil diupdate.<br>";
            } else {
                echo "Gagal mengupdate nilai untuk kategori $kategoriNama.<br>";
            }
            
            // Menutup statement update
            $stmtUpdateNilai->close();
        }
    }

    // Menutup statement total nilai
    $stmtTotalNilai->close();
} else {
    echo "ID Organisasi tidak ditemukan!";
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Lihat Total Skor</title>
    <link rel="stylesheet" href="path/to/bootstrap.css"> <!-- Ganti dengan path yang sesuai -->
</head>
<body>
    <div class="container mt-5">
        <h2>Total Skor Organisasi</h2>
        <div class="alert alert-info" role="alert">
            Total Skor untuk organisasi ID <?php echo $id_organisasi; ?>
        </div>
        <a href="penilai_dashboard.php" class="btn btn-primary">Kembali ke Dashboard</a>
    </div>
    <script src="path/to/bootstrap.js"></script> <!-- Ganti dengan path yang sesuai -->
</body>
</html>

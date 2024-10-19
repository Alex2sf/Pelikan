<?php
// Koneksi ke database
include('../koneksi.php');

// Cek apakah id_organisasi dikirim melalui URL
if (isset($_GET['id_organisasi'])) {
    $id_organisasi = $_GET['id_organisasi'];

    // Query untuk mendapatkan nilai per kategori berdasarkan id_organisasi
    $query = "SELECT kategori.kategori, 
                     organisasi.nilai_kategori1, 
                     organisasi.nilai_kategori2, 
                     organisasi.nilai_kategori3, 
                     organisasi.nilai_kategori4, 
                     organisasi.nilai_kategori5, 
                     organisasi.nilai_kategori6
              FROM organisasi
              JOIN kategori ON kategori.id_kategori = organisasi.id_organisasi
              WHERE organisasi.id_organisasi = ?";

    // Mempersiapkan statement
    $stmt = $conn->prepare($query);
    $stmt->bind_param('i', $id_organisasi);
    $stmt->execute();
    $result = $stmt->get_result();
    
    $rows = [];
    if ($result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
            $rows[] = $row;
        }
    }
    // Tutup statement
    $stmt->close();
} else {
    echo "ID Organisasi tidak ditemukan!";
    exit;
}

// Tutup koneksi
$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Lihat Total Skor</title>
    <link rel="stylesheet" href="path/to/bootstrap.css"> <!-- Ganti dengan path yang sesuai -->
    <style>
        /* Gaya untuk tabel */
        .table-container {
            margin-top: 20px;
        }
        h2 {
            text-align: center;
        }
        .info {
            text-align: center;
        }
        .styled-table {
            border-collapse: collapse;
            margin: 25px 0;
            font-size: 18px;
            width: 100%;
            text-align: left;
            border-radius: 5px 5px 0 0;
            overflow: hidden;
            box-shadow: 0 0 20px rgba(0, 0, 0, 0.15);
        }
        .styled-table thead tr {
            background-color: #4535c1;
            color: #ffffff;
            text-align: left;
            font-weight: bold;
        }
        .styled-table th, .styled-table td {
            padding: 12px 15px;
        }
        .styled-table tbody tr {
            border-bottom: 1px solid #dddddd;
        }
        .styled-table tbody tr:nth-of-type(even) {
            background-color: #f3f3f3;
        }
        .styled-table tbody tr:last-of-type {
            border-bottom: 2px solid #009879;
        }
        .styled-table tbody tr.active-row {
            font-weight: bold;
            color: #009879;
        }
        .btn-custom {
            display: inline-block;
            background-color: #4CAF50; /* Warna latar belakang hijau */
            color: white;
            padding: 12px 24px;
            font-size: 16px;
            border-radius: 8px;
            text-decoration: none;
            margin-top: 20px;
            transition: background-color 0.3s ease, transform 0.3s ease;
            box-shadow: 0px 4px 15px rgba(0, 0, 0, 0.2);
        }
        .btn-custom:hover {
            background-color: #45a049; /* Warna saat hover */
            transform: translateY(-3px); /* Efek hover naik */
        }
    </style>
</head>
<body>
<div style="display: flex; justify-content: space-between; align-items: center; margin: 20px 70px; position: absolute; top: 20px; left: 0; right: 0;">
    <!-- Tombol Back di sebelah kiri -->
    <a href="list_organisasi.php" style="text-decoration: none;">
        <button style="padding: 10px 20px; background-color: #4535c1; color: white; border: none; border-radius: 5px; cursor: pointer; display: flex; align-items: center;">
            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="white" width="20px" height="20px" style="margin-right: 10px;">
                <path d="M0 0h24v24H0z" fill="none"/>
                <path d="M12 4V1L3 9l9 8v-3c4.55 0 8.45 1.72 11 5-1-5.48-4.48-10-11-10z"/>
            </svg>
            Back
        </button>
    </a>
</div>
<div class="container mt-5">
    <h2>Total Skor Organisasi</h2>
    <div class="info" role="alert">
        Total Skor untuk organisasi ID <?php echo htmlspecialchars($id_organisasi); ?>
    </div>
    <div class="table-container">
    <table class="styled-table">
        <thead>
            <tr>
                <th>Kategori</th>
                <th>Nilai</th>
            </tr>
        </thead>
        <tbody>
            <?php if (!empty($rows)): ?>
                <?php foreach ($rows as $row): ?>
                    <tr>
                        <td>Nilai Mengumumkan IP</td>
                        <td><?php echo number_format($row['nilai_kategori1'] ?? 0, 2); ?></td>
                    </tr>
                    <tr>
                        <td>Nilai Menyediakan Dokumen Informasi</td>
                        <td><?php echo number_format($row['nilai_kategori3'] ?? 0, 2); ?></td>
                    </tr>
                    <tr>
                        <td>Nilai Sarana Prasarana</td>
                        <td><?php echo number_format($row['nilai_kategori4'] ?? 0, 2); ?></td>
                    </tr>
                    <tr>
                        <td>Nilai Kelembagaan PPID</td>
                        <td><?php echo number_format($row['nilai_kategori5'] ?? 0, 2); ?></td>
                    </tr>
                    <tr>
                        <td>Nilai Digitalisasi</td>
                        <td><?php echo number_format($row['nilai_kategori6'] ?? 0, 2); ?></td>
                    </tr>
                <?php endforeach; ?>
            <?php else: ?>
                <tr>
                    <td colspan="2">Belum ada hasil nilai yang tersedia.</td>
                </tr>
            <?php endif; ?>
        </tbody>
    </table>
</div>
<?php
session_start();
// Set session timeout to 2 hours (7200 seconds)
$timeout_duration = 7200;

// Check if the session is set
if (isset($_SESSION['last_activity'])) {
    // Calculate the session lifetime
    $elapsed_time = time() - $_SESSION['last_activity'];

    // If the session has expired (more than 2 hours), destroy it
    if ($elapsed_time > $timeout_duration) {
        session_unset();     // Unset session variables
        session_destroy();   // Destroy the session
        header("Location: ../index.php?timeout=true"); // Redirect to login page
        exit();
    }
}

// Update the last activity time stamp
$_SESSION['last_activity'] = time();
require '../koneksi.php'; // Menghubungkan ke database

if (isset($_GET['id_organisasi'])) {
    $id_organisasi = $_GET['id_organisasi'];

    // Query untuk mendapatkan nama organisasi berdasarkan id_organisasi
    $organisasiQuery = "SELECT nama_organisasi FROM organisasi WHERE id_organisasi = ?";
    $stmtOrganisasi = $conn->prepare($organisasiQuery);
    $stmtOrganisasi->bind_param('i', $id_organisasi);
    $stmtOrganisasi->execute();
    $resultOrganisasi = $stmtOrganisasi->get_result();

    if ($resultOrganisasi->num_rows > 0) {
        $rowOrganisasi = $resultOrganisasi->fetch_assoc();
        $nama_organisasi = $rowOrganisasi['nama_organisasi'];
    } else {
        echo "Nama organisasi tidak ditemukan!";
        exit;
    }

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

    $rows = [];
    // Melakukan iterasi dan menyimpan hasil total nilai per kategori
    while ($rowTotal = $resultTotalNilai->fetch_assoc()) {
        $rows[] = $rowTotal;

        // Menentukan kolom nilai berdasarkan id_kategori
        switch ($rowTotal['id_kategori']) {
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
                $updateNilaiQuery = "";
                break;
        }

        if (!empty($updateNilaiQuery)) {
            $stmtUpdateNilai = $conn->prepare($updateNilaiQuery);
            $stmtUpdateNilai->bind_param('di', $rowTotal['total_nilai'], $id_organisasi);
            $stmtUpdateNilai->execute();
            $stmtUpdateNilai->close();
        }
    }

    // Menutup statement total nilai
    $stmtTotalNilai->close();
    $stmtOrganisasi->close();
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
    <style>
        /* Gaya untuk tabel */
        .table-container {
            margin-top: 20px;
        }
        h2{
            text-align: center;
        }
        .info{
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
    .btn-custom i {
        margin-right: 8px; /* Jarak antara ikon dan teks */
    }
    .btn-custom:hover {
        background-color: #45a049; /* Warna saat hover */
        transform: translateY(-3px); /* Efek hover naik */
    }
    .btn-custom:active {
        background-color: #3e8e41; /* Warna saat ditekan */
        box-shadow: 0px 4px 10px rgba(0, 0, 0, 0.3);
        transform: translateY(1px); /* Efek saat ditekan */
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
            Total Skor untuk organisasi ID <?php echo $id_organisasi, $nama_organisasi; ?>
        </div>
        <div class="table-container">
            <table class="styled-table">
                <thead>
                    <tr>
                        <th>Kategori</th>
                        <th>Total Nilai</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if (!empty($rows)): ?>
                        <?php foreach ($rows as $row): ?>
                            <tr>
                                <td><?php echo htmlspecialchars($row['kategori']); ?></td>
                                <td><?php echo number_format($row['total_nilai'], 2); ?></td>
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
    </div>
    <script src="path/to/bootstrap.js"></script> <!-- Ganti dengan path yang sesuai -->
</body>
</html>
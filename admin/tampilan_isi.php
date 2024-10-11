<?php

include '../koneksi.php';

// Query untuk mengambil data
$sql = "SELECT 
            id_kuesioner, 
            pertanyaan, 
            jawaban, 
            link, 
            dokumen, 
            unit_eselon1, 
            nama_organisasi, 
            nip_responden, 
            nilai,
            catatan,
            verifikasi
        FROM 
            kuesioner 
        WHERE 
            id_kuesioner = 1"; // Ganti dengan nilai yang sesuai

$result = $conn->query($sql);

// Cek apakah ada permintaan untuk mengunduh file CSV
if (isset($_GET['download'])) {
    header('Content-Type: text/csv');
    header('Content-Disposition: attachment; filename="kuesioner.csv"');
    header('Pragma: no-cache');
    header('Expires: 0');

    // Buka output untuk menulis
    $output = fopen('php://output', 'w');

    // Menulis header kolom
    fputcsv($output, ['No', 'Pertanyaan', 'Jawaban', 'Link', 'Dokumen', 'Unit Eselon 1', 'Nama Organisasi', 'NIP Responden', 'Nilai', 'Catatan', 'Verifikasi']);

    // Menulis data
    if ($result->num_rows > 0) {
        $no = 1;
        while ($row = $result->fetch_assoc()) {
            fputcsv($output, [$no++, $row['pertanyaan'], $row['jawaban'], $row['link'], $row['dokumen'], $row['unit_eselon1'], $row['nama_organisasi'], $row['nip_responden'], $row['nilai'], $row['catatan'], $row['verifikasi']]);
        }
    }

    fclose($output);
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tabel Kuesioner</title>
    <link href="../css/bootstrap.min.css" rel="stylesheet">
    <style>
        table {
            width: 100%;
            border-collapse: collapse;
            font-family: Arial, sans-serif;
            font-size: 14px;
        }
        th, td {
            border: 1px solid black;
            padding: 8px;
            text-align: left;
        }
        th {
            background-color: #003366;
            color: white;
        }
    </style>
</head>
<body>
    <div class="container" style="padding-top: 50px;">
        <h1 class="text-center">Tabel Kuesioner</h1>
        <a href="?download=true" class="btn btn-success mb-3">Download CSV</a>
        <table>
            <thead>
                <tr>
                    <th>No</th>
                    <th>Pertanyaan</th>
                    <th>Jawaban</th>
                    <th>Link</th>
                    <th>Dokumen</th>
                    <th>Unit Eselon 1</th>
                    <th>Nama Organisasi</th>
                    <th>NIP Responden</th>
                    <th>Nilai</th>
                    <th>Catatan</th>
                    <th>Verifikasi</th>
                </tr>
            </thead>
            <tbody>
                <?php if ($result->num_rows > 0): ?>
                    <?php $no = 1; ?>
                    <?php while ($row = $result->fetch_assoc()): ?>
                        <tr>
                            <td><?php echo $no++; ?></td>
                            <td><?php echo htmlspecialchars($row['pertanyaan']); ?></td>
                            <td><?php echo htmlspecialchars($row['jawaban']); ?></td>
                            <td><a href="<?php echo htmlspecialchars($row['link']); ?>" target="_blank"><?php echo htmlspecialchars($row['link']); ?></a></td>
                            <td><?php echo htmlspecialchars($row['dokumen']); ?></td>
                            <td><?php echo htmlspecialchars($row['unit_eselon1']); ?></td>
                            <td><?php echo htmlspecialchars($row['nama_organisasi']); ?></td>
                            <td><?php echo htmlspecialchars($row['nip_responden']); ?></td>
                            <td><?php echo htmlspecialchars($row['nilai']); ?></td>
                            <td><?php echo htmlspecialchars($row['catatan']); ?></td>
                            <td><?php echo htmlspecialchars($row['verifikasi']); ?></td>
                        </tr>
                    <?php endwhile; ?>
                <?php else: ?>
                    <tr>
                        <td colspan="11" class="text-center">Tidak ada data untuk ditampilkan.</td>
                    </tr>
                <?php endif; ?>
            </tbody>
        </table>
    </div>

    <script src="../js/bootstrap.min.js"></script>
</body>
</html>

<?php
$conn->close();
?>

<?php
session_start();
include '../koneksi.php';

if (!isset($_SESSION['id_akun'])) {
    header("Location: ../index.php");
    exit;
}

$id_akun = $_SESSION['id_akun'];

// Ambil id_organisasi dari akun yang login
$sql = "SELECT id_organisasi FROM organisasi WHERE id_akun = '$id_akun'";
$result = $conn->query($sql);

if ($result->num_rows > 0) {
    $row = $result->fetch_assoc();
    $id_organisasi = $row['id_organisasi'];

    // Query untuk mengambil hasil kuesioner berdasarkan id_organisasi
    $sql = "SELECT k.id_kuesioner, p.pertanyaan, p.bobot, k.jawaban, k.link, k.dokumen, k.nilai, k.catatan, k.verifikasi, o.nama_organisasi,
               cat.id_kategori, cat.kategori, sub1.subkategori1, sub2.subkategori2, sub3.subkategori3
            FROM kuesioner k
            JOIN pertanyaan p ON k.id_pertanyaan = p.id_pertanyaan
            JOIN organisasi o ON k.id_organisasi = o.id_organisasi
            LEFT JOIN kategori cat ON p.id_kategori = cat.id_kategori 
            LEFT JOIN subkategori1 sub1 ON p.id_subkategori1 = sub1.id_subkategori1
            LEFT JOIN subkategori2 sub2 ON p.id_subkategori2 = sub2.id_subkategori2
            LEFT JOIN subkategori3 sub3 ON p.id_subkategori3 = sub3.id_subkategori3
            WHERE k.id_organisasi = '$id_organisasi'";

    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        $last_kategori = '';
        $last_subkategori1 = '';
        $last_subkategori2 = '';
        $last_subkategori3 = '';

        while ($row = $result->fetch_assoc()) {
            // Check if the kategori has changed
            if ($last_kategori != $row['kategori']) {
                if ($last_kategori != '') {
                    echo "</tbody></table><br>"; // Close previous table if exists
                }
                echo "<h2>{$row['kategori']}</h2>"; // Display the new kategori
                $last_kategori = $row['kategori'];
            }

            // Check if SubKategori1 has changed
            if ($last_subkategori1 != $row['subkategori1']) {
                if ($last_subkategori1 != '') {
                    echo "</tbody></table><br>"; // Close previous table if exists
                }
                echo "<table border='1' style='border-collapse: collapse; width: 100%; margin-bottom: 10px;'>
                        <thead>
                            <tr style='background-color: #1E90FF; color: black;'>
                                <th style='padding: 10px; width: 60%;'>{$row['subkategori1']}</th>
                            </tr>
                        </thead>
                        <tbody>";
                $last_subkategori1 = $row['subkategori1'];
                $last_subkategori2 = ''; // Reset SubKategori2
                $last_subkategori3 = ''; // Reset SubKategori3
            }

            // Check if SubKategori2 has changed
            if ($last_subkategori2 != $row['subkategori2']) {
                if ($last_subkategori2 != '') {
                    echo "</tbody></table><br>"; // Close previous table if exists
                }
                echo "<table border='1' style='border-collapse: collapse; width: 100%; margin-bottom: 10px;'>
                        <thead>
                            <tr style='background-color: #00008B; color: white;'>
                                <th>{$row['subkategori2']}</th>
                            </tr>
                        </thead>
                        <tbody>";
                $last_subkategori2 = $row['subkategori2'];
                $last_subkategori3 = ''; // Reset SubKategori3
            }

            // Check if SubKategori3 has changed
            if ($last_subkategori3 != $row['subkategori3']) {
                if ($last_subkategori3 != '') {
                    echo "</tbody></table><br>"; // Close previous table if exists
                }
                echo "<table border='1' style='border-collapse: collapse; width: 100%; margin-bottom: 10px;'>
                        <thead>
                            <tr style='background-color: #FFA500; color: black;'>
                                <th style='padding: 10px; width: 60%;'>{$row['subkategori3']}</th>
                                <th style='padding: 10px; width: 10%;'>Bobot</th>
                                <th style='padding: 10px; width: 10%;'>Jawaban</th>
                                <th style='padding: 10px; width: 10%;'>Link</th>
                                <th style='padding: 10px; width: 10%;'>Dokumen</th>
                                <th style='padding: 10px; width: 10%;'>Nilai</th>
                                <th style='padding: 10px; width: 10%;'>Catatan</th>
                                <th style='padding: 10px; width: 10%;'>Verifikasi</th>
                            </tr>
                        </thead>
                        <tbody>";
                $last_subkategori3 = $row['subkategori3'];
            }

            // Output the data rows within the current subkategori
            echo "<tr>
                    <td>{$row['pertanyaan']}</td>
                    <td>{$row['bobot']}</td>
                    <td>{$row['jawaban']}</td>
                    <td>{$row['link']}</td>
                    <td>";
                    
if (!empty($row['dokumen'])) {
    echo "<a href='../upt/{$row['dokumen']}' target='_blank'>Review Dokumen</a>";
} else {
    echo "Tidak ada dokumen";
}

echo "</td><td>{$row['nilai']}</td>
                    <td>{$row['catatan']}</td>
                    <td>{$row['verifikasi']}</td>
                  </tr>";
        }

        echo "</tbody></table>"; // Close the last table
    } else {
        echo "Belum ada hasil kuesioner.";
    }
} else {
    echo "Organisasi tidak ditemukan.";
}
?>

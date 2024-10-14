<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Data Kuesioner</title>
    <style>
        
        body{
            user-select: ;
                outline: black; /* Menghilangkan outline fokus */
                margin: 20px;
                padding: 50px;
                overflow-x: hidden;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 20px;
        }
        table, th, td {
            border: 1px solid black;
        }
        th, td {
            padding: 10px;
            text-align: left;
        }
        th {
            background-color: #4535c1;
        }
        h2 {
            text-align: center;
            color: #333;
        }
        button {
            padding: 10px 20px;
            background-color: #4CAF50;
            color: white;
            border: none;
            border-radius: 5px;
            cursor: pointer;
        }
    </style>
</head>
<body>
<div style="display: flex; justify-content: space-between; align-items: center; margin: 20px 70px; position: absolute; top: 20px; left: 0; right: 0;">
    <!-- Tombol Back di sebelah kiri -->
    <a href="daftar_organisasi.php" style="text-decoration: none;">
        <button style="padding: 10px 20px; background-color: #4535c1; color: white; border: none; border-radius: 5px; cursor: pointer; display: flex; align-items: center;">
            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="white" width="20px" height="20px" style="margin-right: 10px;">
                <path d="M0 0h24v24H0z" fill="none"/>
                <path d="M12 4V1L3 9l9 8v-3c4.55 0 8.45 1.72 11 5-1-5.48-4.48-10-11-10z"/>
            </svg>
            Back
        </button>
    </a>

    <!-- Tombol Unduh CSV di sebelah kanan -->
    <a href="download_csv.php" style="text-decoration: none;">
        <button style="padding: 10px 20px; background-color: #4CAF50; color: white; border: none; border-radius: 5px; cursor: pointer; display: flex; align-items: center;">
            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="white" width="20px" height="20px" style="margin-right: 10px;">
                <path d="M0 0h24v24H0z" fill="none"/>
                <path d="M5 20h14v-2H5v2zm7-18l-5.5 6h4v6h3v-6h4L12 2z"/>
            </svg>
            Unduh CSV
        </button>
    </a>
</div>

<?php
// Koneksi ke database
$host = 'localhost';
$user = 'root';
$password = '';
$dbname = 'sigh';

$conn = new mysqli($host, $user, $password, $dbname);

// Cek koneksi
if ($conn->connect_error) {
    die("Koneksi gagal: " . $conn->connect_error);
}

// Cek apakah id_organisasi ada di URL
if (isset($_GET['id'])) {
    $id_organisasi = (int)$_GET['id']; // Mengonversi ke integer untuk keamanan
}

    // Query untuk mengambil data dengan join pada tabel kategori dan subkategori
    $sql = "
        SELECT p.id_pertanyaan, k.kategori, s1.subkategori1, s2.subkategori2, s3.subkategori3, 
               p.pertanyaan, p.web, p.bobot, q.jawaban, q.link, q.dokumen, q.nilai, q.catatan, q.verifikasi
        FROM pertanyaan p
        JOIN kategori k ON p.id_kategori = k.id_kategori
        JOIN SubKategori1 s1 ON p.id_subkategori1 = s1.id_subkategori1
        JOIN SubKategori2 s2 ON p.id_subkategori2 = s2.id_subkategori2
        JOIN SubKategori3 s3 ON p.id_subkategori3 = s3.id_subkategori3
        LEFT JOIN kuesioner q ON p.id_pertanyaan = q.id_pertanyaan
        WHERE q.id_organisasi = $id_organisasi"; // Menambahkan filter berdasarkan id_organisasi

    $result = $conn->query($sql);
    $uploads_base_url = "http://localhost/Pelikan/upt/uploads/"; // URL untuk file uploads

    // Inisialisasi variabel untuk menyimpan kategori dan subkategori terakhir yang ditampilkan
    $last_kategori = '';
    $last_subkategori1 = '';
    $last_subkategori2 = '';
    $last_subkategori3 = '';

    // Memulai output HTML
    if ($result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
            // Jika kategori berubah, tutup tabel sebelumnya
            if ($last_kategori != $row['kategori']) {
                if ($last_kategori != '') {
                    echo "</tbody></table><br>"; // Tutup tabel sebelumnya jika ada
                }
                echo "<h2>{$row['kategori']}</h2>"; // Tampilkan kategori baru
                $last_kategori = $row['kategori'];
            }

            // Jika SubKategori1 berubah, buat tabel baru
            if ($last_subkategori1 != $row['subkategori1']) {
                if ($last_subkategori1 != '') {
                    echo "</tbody></table><br>"; // Tutup tabel sebelumnya jika ada
                }
                echo "<table border='1' style='border-collapse: collapse; width: 100%; margin-bottom: 10px;'>
                        <thead>
                            <tr style='background-color: #1E90FF; color: white;'>
                                <th colspan='3' style='padding: 10px; width: 60%;'>{$row['subkategori1']}</th>
                            </tr>
                        </thead>
                        <tbody>";
                $last_subkategori1 = $row['subkategori1'];
                $last_subkategori2 = ''; // Reset SubKategori2
                $last_subkategori3 = ''; // Reset SubKategori3
            }

            // Jika SubKategori2 berubah, buat tabel baru
            if ($last_subkategori2 != $row['subkategori2']) {
                if ($last_subkategori2 != '') {
                    echo "</tbody></table><br>"; // Tutup tabel sebelumnya jika ada
                }
                echo "<table border='1' style='border-collapse: collapse; width: 100%; margin-bottom: 10px;'>
                        <thead>
                            <tr style='background-color: #00008B; color: white;'>
                                <th colspan='3'>{$row['subkategori2']}</th>
                            </tr>
                        </thead>
                        <tbody>";
                $last_subkategori2 = $row['subkategori2'];
                $last_subkategori3 = ''; // Reset SubKategori3
            }

            // Jika SubKategori3 berubah, buat tabel baru
            if ($last_subkategori3 != $row['subkategori3']) {
                if ($last_subkategori3 != '') {
                    echo "</tbody></table><br>"; // Tutup tabel sebelumnya jika ada
                }
                echo "<table border='1' style='border-collapse: collapse; width: 100%; margin-bottom: 10px;'>
                        <thead>
                            <tr style='background-color: #FFA500; color: white;'>
                                <th style='padding: 10px; width: 40%;'>{$row['subkategori3']}</th>
                                <th style='padding: 10px;'>Pertanyaan</th>
                                <th style='padding: 10px;'>Bobot</th>
                                <th style='padding: 10px;'>Jawaban</th>
                                <th style='padding: 10px;'>Link</th>
                                <th style='padding: 10px;'>Dokumen</th>
                                <th style='padding: 10px;'>Nilai</th>
                                <th style='padding: 10px;'>Catatan</th>
                                <th style='padding: 10px;'>Verifikasi</th>
                            </tr>
                        </thead>
                        <tbody>";
            }
?>

        <!-- Tampilkan data pertanyaan -->
<tr>
    <td><?php echo $row['subkategori3']; ?></td>
    <td><?php echo $row['pertanyaan']; ?></td>
    <td><?php echo $row['bobot']; ?></td>
    <td><?php echo $row['jawaban']; ?></td>
    <td><?php echo $row['link']; ?></td>
    <td><?php echo $row['dokumen']; ?></td>
    <td><?php echo $row['nilai']; ?></td>
    <td><?php echo $row['catatan']; ?></td>
    <td><?php echo $row['verifikasi']; ?></td>
</tr>

<?php
    } // Akhir dari while

    echo "</tbody></table>"; // Tutup tabel terakhir
} else {
    echo "<p>Tidak ada data yang tersedia.</p>";
}

// Menutup koneksi
$conn->close();
?>

<!-- Button for downloading CSV -->


</body>
</html>
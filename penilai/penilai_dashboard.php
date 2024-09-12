<?php
session_start();
if (!isset($_SESSION['id_akun']) || $_SESSION['role'] != 'penilai') {
    header("Location: login_penilai.php");
    exit();
}

$conn = new mysqli('localhost', 'root', '', 'emone'); // Ganti dengan kredensial database Anda

// Cek koneksi database
if ($conn->connect_error) {
    die("Koneksi gagal: " . $conn->connect_error);
}

$id_akun = $_SESSION['id_akun'];

// Ambil detail penilai
$sql = "SELECT id_penilai FROM Profile_Penilai WHERE id_akun='$id_akun'";
$result = $conn->query($sql);
$row = $result->fetch_assoc();
$id_penilai = $row['id_penilai'];

// Ambil kuesioner yang perlu diisi
$sql = "SELECT k.id_kuesioner, p.pertanyaan, k.jawaban, k.link, k.dokumen, k.nilai, k.catatan, k.verifikasi, o.nama_organisasi 
        FROM Kuesioner k
        JOIN Pertanyaan p ON k.id_pertanyaan = p.id_pertanyaan
        JOIN Organisasi o ON k.id_organisasi = o.id_organisasi
        WHERE k.id_penilai='$id_penilai'
        ORDER BY o.nama_organisasi, k.verifikasi, k.id_kuesioner DESC";
$result = $conn->query($sql);

// Inisialisasi array untuk menyimpan data kuesioner
$kuesionerByOrganisasi = [];

// Kelompokkan kuesioner berdasarkan organisasi
while ($row = $result->fetch_assoc()) {
    $kuesionerByOrganisasi[$row['nama_organisasi']][] = $row;
}

// Proses update data kuesioner
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    foreach ($_POST['update'] as $id_kuesioner => $update) {
        $nilai = $_POST['nilai'][$id_kuesioner];
        $catatan = $_POST['catatan'][$id_kuesioner];
        $verifikasi = isset($_POST['verifikasi'][$id_kuesioner]) ? 1 : 0;

        $sql = "UPDATE Kuesioner SET nilai='$nilai', catatan='$catatan', verifikasi='$verifikasi' WHERE id_kuesioner='$id_kuesioner' AND id_penilai='$id_penilai'";
        
        if ($conn->query($sql) !== TRUE) {
            echo "Error: " . $conn->error;
        }
    }
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard Penilai</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f4;
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        .navbar {
            background-color: #4CAF50;
            overflow: hidden;
            padding: 10px 0;
        }

        .navbar a {
            float: left;
            display: block;
            color: white;
            text-align: center;
            padding: 14px 20px;
            text-decoration: none;
        }

        .navbar a:hover {
            background-color: #45a049;
        }

        h2 {
            text-align: center;
            color: #333;
            margin-top: 20px;
        }

        h3 {
            text-align: center;
            color: #666;
        }

        .container {
            width: 80%;
            margin: 0 auto;
            background-color: #fff;
            padding: 20px;
            box-shadow: 0px 0px 10px rgba(0, 0, 0, 0.1);
            border-radius: 8px;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
        }

        th, td {
            padding: 10px;
            text-align: left;
            border-bottom: 1px solid #ddd;
        }

        th {
            background-color: #4CAF50;
            color: white;
        }

        tr:hover {
            background-color: #f1f1f1;
        }

        input[type="number"], input[type="text"] {
            width: 100%;
            padding: 5px;
            border: 1px solid #ccc;
            border-radius: 4px;
        }

        input[type="submit"] {
            background-color: #4CAF50;
            color: white;
            border: none;
            padding: 10px 20px;
            cursor: pointer;
            border-radius: 4px;
            transition: background-color 0.3s ease;
        }

        input[type="submit"]:hover {
            background-color: #45a049;
        }

        a {
            color: #4CAF50;
            text-decoration: none;
        }

        a:hover {
            text-decoration: underline;
        }

        @media screen and (max-width: 768px) {
            .container {
                width: 95%;
            }

            table, th, td {
                display: block;
                width: 100%;
            }

            tr {
                margin-bottom: 15px;
            }

            th, td {
                text-align: right;
                padding: 10px 5px;
            }

            th::before {
                content: attr(data-label);
                float: left;
                font-weight: bold;
            }
        }
    </style>
</head>
<body>
    <!-- Navbar -->
    <div class="navbar">
        <a href="penilaian_kuesioner.php">Penilaian Kuesioner</a>
        <a href="ranking.php">Ranking</a>
        <a href="penilaian_kategori.php">Penilaian Kategori</a>
    </div>

    <h2>Dashboard Penilai</h2>

    <div class="container">
        <?php foreach ($kuesionerByOrganisasi as $nama_organisasi => $kuesioners): ?>
            <h3>Kuesioner untuk Organisasi: <?php echo htmlspecialchars($nama_organisasi); ?></h3>
            <form method="post" action="penilai_dashboard.php">
                <table>
                    <tr>
                        <th>Pertanyaan</th>
                        <th>Jawaban</th>
                        <th>Link</th>
                        <th>Dokumen</th>
                        <th>Nilai</th>
                        <th>Catatan</th>
                        <th>Verifikasi</th>
                        <th>Action</th>
                    </tr>
                    <?php foreach ($kuesioners as $row): ?>
                    <tr>
                        <td><?php echo htmlspecialchars($row['pertanyaan']); ?></td>
                        <td><?php echo htmlspecialchars($row['jawaban']); ?></td>
                        <td>
                            <?php if (!empty($row['link'])): ?>
                                <a href="<?php echo htmlspecialchars($row['link']); ?>" target="_blank">Lihat Link</a>
                            <?php else: ?>
                                Tidak ada link
                            <?php endif; ?>
                        </td>
                        <td>
                            <?php if (!empty($row['dokumen'])): ?>
                                <a href="uploads/<?php echo htmlspecialchars($row['dokumen']); ?>" target="_blank">Lihat Dokumen</a>
                            <?php else: ?>
                                Tidak ada dokumen
                            <?php endif; ?>
                        </td>
                        <td><input type="number" name="nilai[<?php echo $row['id_kuesioner']; ?>]" value="<?php echo $row['nilai']; ?>" min="0" max="100"></td>
                        <td><input type="text" name="catatan[<?php echo $row['id_kuesioner']; ?>]" value="<?php echo htmlspecialchars($row['catatan']); ?>"></td>
                        <td><input type="checkbox" name="verifikasi[<?php echo $row['id_kuesioner']; ?>]" <?php echo $row['verifikasi'] ? 'checked' : ''; ?>></td>
                        <td><input type="submit" name="update[<?php echo $row['id_kuesioner']; ?>]" value="Update"></td>
                    </tr>
                    <?php endforeach; ?>
                </table>
            </form>
        <?php endforeach; ?>
    </div>
</body>
</html>

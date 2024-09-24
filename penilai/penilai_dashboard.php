<?php
session_start();
if (!isset($_SESSION['id_akun']) || $_SESSION['role'] != 'penilai') {
    header("Location: login_penilai.php");
    exit();
}

$conn = new mysqli('localhost', 'root', '', 'sigh'); // Ganti dengan kredensial database Anda

// Cek koneksi database
if ($conn->connect_error) {
    die("Koneksi gagal: " . $conn->connect_error);
}

$id_akun = $_SESSION['id_akun'];

// Ambil id_penilai
$stmt = $conn->prepare("SELECT id_penilai FROM profile_penilai WHERE id_akun = ?");
$stmt->bind_param('i', $id_akun);
$stmt->execute();
$result = $stmt->get_result();
$row = $result->fetch_assoc();
$id_penilai = $row['id_penilai'];

// Ambil id_organisasi dari parameter
$id_organisasi = isset($_GET['id_organisasi']) ? (int)$_GET['id_organisasi'] : 0;

// Validasi id_organisasi
if ($id_organisasi <= 0) {
    die("ID Organisasi tidak valid.");
}

// Ambil kuesioner yang perlu diisi dengan kategori dan subkategori
$sql = "SELECT k.id_kuesioner, p.pertanyaan, k.jawaban, k.link, k.dokumen, k.nilai, k.catatan, k.verifikasi, o.nama_organisasi,
               cat.kategori, sub1.subkategori1, sub2.subkategori2, sub3.subkategori3
        FROM kuesioner k
        JOIN pertanyaan p ON k.id_pertanyaan = p.id_pertanyaan
        JOIN organisasi o ON k.id_organisasi = o.id_organisasi
        LEFT JOIN kategori cat ON p.id_kategori = cat.id_kategori
        LEFT JOIN subkategori1 sub1 ON p.id_subkategori1 = sub1.id_subkategori1
        LEFT JOIN subkategori2 sub2 ON p.id_subkategori2 = sub2.id_subkategori2
        LEFT JOIN subkategori3 sub3 ON p.id_subkategori3 = sub3.id_subkategori3
        WHERE k.id_organisasi = ? AND k.id_penilai = ?
        ORDER BY cat.kategori, sub1.subkategori1, sub2.subkategori2, sub3.subkategori3, k.verifikasi, k.id_kuesioner DESC";

$stmt = $conn->prepare($sql);
$stmt->bind_param('ii', $id_organisasi, $id_penilai);
$stmt->execute();
$result = $stmt->get_result();

// Inisialisasi variabel untuk kategori dan subkategori
$last_kategori = '';
$last_subkategori1 = '';
$last_subkategori2 = '';
$last_subkategori3 = '';

// Proses update data kuesioner
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    foreach ($_POST['update'] as $id_kuesioner => $update) {
        $nilai = $_POST['nilai'][$id_kuesioner] ?? NULL;
        $catatan = $_POST['catatan'][$id_kuesioner] ?? NULL;
        $verifikasi = isset($_POST['verifikasi'][$id_kuesioner]) ? 1 : 0;

        $stmt = $conn->prepare("UPDATE kuesioner SET nilai = ?, catatan = ?, verifikasi = ? WHERE id_kuesioner = ? AND id_penilai = ?");
        $stmt->bind_param('dsiii', $nilai, $catatan, $verifikasi, $id_kuesioner, $id_penilai);
        if (!$stmt->execute()) {
            echo "Error: " . $stmt->error;
        }
    }
    // Refresh the page to avoid form resubmission
    header("Location: " . $_SERVER['PHP_SELF'] . "?id_organisasi=" . $id_organisasi);
    exit();
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
            margin: 0;
            padding: 0;
        }
        .navbar {
            background-color: #333;
            color: white;
            padding: 10px;
            text-align: center;
        }
        .navbar a {
            color: white;
            margin: 0 15px;
            text-decoration: none;
            font-weight: bold;
        }
        .navbar a:hover {
            text-decoration: underline;
        }
        .container {
            padding: 20px;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 20px;
        }
        th, td {
            border: 1px solid #ddd;
            padding: 8px;
        }
        th {
            background-color: #f4f4f4;
            text-align: left;
        }
        tr:nth-child(even) {
            background-color: #f9f9f9;
        }
        .button {
            background-color: #4CAF50;
            color: white;
            border: none;
            padding: 10px 20px;
            cursor: pointer;
            text-decoration: none;
            border-radius: 5px;
        }
        .button:hover {
            background-color: #45a049;
        }
        .form-group {
            margin-bottom: 15px;
        }
        .form-group label {
            display: block;
            margin-bottom: 5px;
        }
        .form-group input, .form-group textarea {
            width: 100%;
            padding: 8px;
            box-sizing: border-box;
        }
    </style>
</head>
<body>
    <!-- Navbar -->
    <div class="navbar">
        <a href="list_organisasi.php">Daftar Organisasi</a>
        <a href="logout.php">Logout</a>
    </div>

    <h2>Dashboard Penilai</h2>

    <div class="container">
        <form action="penilai_dashboard.php?id_organisasi=<?php echo $id_organisasi; ?>" method="POST">
            <?php
            // Loop melalui hasil query
            while ($row = $result->fetch_assoc()) {
                // Jika kategori berubah, tutup tabel sebelumnya
                if ($last_kategori != $row['kategori']) {
                    if ($last_kategori != '') {
                        echo "</tbody></table><br>"; // Tutup tabel sebelumnya jika ada
                    }
                    echo "<h2>{$row['kategori']}</h2>"; // Tampilkan kategori
                    $last_kategori = $row['kategori'];
                }

                // Jika SubKategori1 berubah, tutup tabel sebelumnya
                if ($last_subkategori1 != $row['subkategori1']) {
                    if ($last_subkategori1 != '') {
                        echo "</tbody></table><br>"; // Tutup tabel sebelumnya jika ada
                    }
                    echo "<table border='1' style='border-collapse: collapse; width: 100%; margin-bottom: 10px;'>
                            <thead>
                                <tr style='background-color: #343A40; color: black;'>
                                    <th style='padding: 10px; width: 60%;'>{$row['subkategori1']}</th>
                                </tr>
                            </thead>
                            <tbody>";
                    $last_subkategori1 = $row['subkategori1'];
                    $last_subkategori2 = ''; // Reset SubKategori2
                    $last_subkategori3 = ''; // Reset SubKategori3
                }

                // Jika SubKategori2 berubah, tutup tabel sebelumnya
                if ($last_subkategori2 != $row['subkategori2']) {
                    if ($last_subkategori2 != '') {
                        echo "</tbody></table><br>"; // Tutup tabel sebelumnya jika ada
                    }
                    echo "<table border='1' style='border-collapse: collapse; width: 100%; margin-bottom: 10px;'>
                            <thead>
                                <tr style='background-color: #343A40; color: black;'>
                                    <th style='padding: 10px; width: 60%;'>{$row['subkategori2']}</th>
                                </tr>
                            </thead>
                            <tbody>";
                    $last_subkategori2 = $row['subkategori2'];
                    $last_subkategori3 = ''; // Reset SubKategori3
                }

                // Jika SubKategori3 berubah, tutup tabel sebelumnya
                if ($last_subkategori3 != $row['subkategori3']) {
                    if ($last_subkategori3 != '') {
                        echo "</tbody></table><br>"; // Tutup tabel sebelumnya jika ada
                    }
                    echo "<table border='1' style='border-collapse: collapse; width: 100%; margin-bottom: 10px;'>
                            <thead>
                                <tr style='background-color: #343A40; color: black;'>
                                    <th style='padding: 10px; width: 60%;'>{$row['subkategori3']}</th>
                                </tr>
                            </thead>
                            <tbody>";
                    $last_subkategori3 = $row['subkategori3'];
                }

                // Tampilkan baris data pertanyaan
                echo "<tr>
                
                        <td>{$row['pertanyaan']}</td>
                        <td>{$row['jawaban']}</td>
                        <td>{$row['link']}</td>
                        <td>{$row['dokumen']}</td>
                      
                       <td>
                            <input type='text' name='nilai[{$row['id_kuesioner']}]' placeholder='Nilai'>
                          
                        </td>
                                               <td>
                          <textarea name='catatan[{$row['id_kuesioner']}]' placeholder='Catatan'></textarea>
                          
                        </td>
                                                              <td>
                            <label><input type='checkbox' name='verifikasi[{$row['id_kuesioner']}]' value='1'> Verifikasi</label>
                          
                        </td>
                          <td type = 'hidden'>
                            <input type='hidden' name='update[{$row['id_kuesioner']}]' value='1'>
                          
                        </td>
                      </tr>";
            }

            // Tutup tabel terakhir
            if ($last_subkategori3 != '') {
                echo "</tbody></table><br>";
            }
            ?>
            <button type="submit" class="button">Simpan Perubahan</button>
        </form>
    </div>
</body>
</html>

<?php
$conn->close();
?>
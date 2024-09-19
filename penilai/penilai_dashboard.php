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
        ORDER BY o.nama_organisasi, k.verifikasi, k.id_kuesioner DESC";
$stmt = $conn->prepare($sql);
$stmt->bind_param('ii', $id_organisasi, $id_penilai);
$stmt->execute();
$result = $stmt->get_result();

// Inisialisasi array untuk menyimpan data kuesioner
$kuesionerByOrganisasi = [];

// Kelompokkan kuesioner berdasarkan organisasi
while ($row = $result->fetch_assoc()) {
    $kuesionerByOrganisasi[$row['nama_organisasi']][] = $row;
}

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
    <!-- Google Fonts -->
   <!-- <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600&display=swap">-->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    
        
    
    <style>
        .bg-blue-dark {
            background-color: #4535C1; /* Warna biru gelap */
        }
        body {
            font-family: Arial, Helvetica, sans-serif;
            margin: 0;
            padding: 0;
            background-color: #f4f6f9;
            margin-top: 180px;
        }

        .navbar {
            background-color: #2c3e50;
            color: white;
            padding: 15px;
            text-align: center;
        }

        .navbar a {
            color: white;
            margin: 0 15px;
            text-decoration: none;
            font-weight: 500;
        }

        .navbar a:hover {
            text-decoration: underline;
        }

        h2 {
            text-align: center;
            color: #34495e;
            margin: 20px 0;
            font-weight: 600;
        }

        h3 {
            color: #2c3e50;
            margin-top: 30px;
            margin-bottom: 15px;
        }

        .container {
            padding: 20px;
            max-width: 1500px;
            margin: 0 auto;
            background-color: white;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            border-radius: 8px;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 20px;
        }

        th,
        td {
            border: 1px solid #e1e4e8;
            padding: 12px;
            text-align: left;
        }

        th {
            background-color: #4535C1;
            color: white;
            font-weight: 600;
            text-align: center;
        }

        td {
            background-color: #f9f9f9;
        }

        tr:nth-child(even) {
            background-color: #f3f3f3;
        }

        .button {
            background-color: #3498db;
            color: white;
            border: none;
            padding: 10px 20px;
            cursor: pointer;
            text-decoration: none;
            border-radius: 5px;
            font-weight: 500;
        }

        .button:hover {
            background-color: #2980b9;
        }

        .form-group {
            margin-bottom: 15px;
        }

        .form-group label {
            display: block;
            margin-bottom: 5px;
        }

        .form-group input,
        .form-group textarea {
            width: 100%;
            padding: 10px;
            box-sizing: border-box;
            border: 1px solid #ccc;
            border-radius: 5px;
        }

        input[type="number"],
        textarea {
            resize: none;
        }

        input[type="checkbox"] {
            width: auto;
            transform: scale(1.2);
        }

        button[type="submit"] {
            display: block;
            width: 100%;
            padding: 10px;
            background-color: blue;
            color: white;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            font-size: 16px;
        }

        button[type="submit"]:hover {
            background-color: #2ecc71;
        }

        @media (max-width: 768px) {
            .container {
                padding: 15px;
            }

            table th,
            table td {
                padding: 8px;
            }

            .navbar a {
                margin: 0 10px;
            }
        }
    </style>
    <nav class="navbar navbar-expand-lg bg-body-tertiary fixed-top" style="border-bottom: 2px solid #4535C1; height: 80px;">
            <div class="container-fluid fs-4">
                <a class="navbar-brand fs-5" href="#" style="padding-left:60px;">
                    <img src="img/1.png" alt="Logo" width="80" height="64" class="d-inline-block align-text-top">
                </a>
                <div>Sistem Penilaian</div>
                <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                    <span class="navbar-toggler-icon"></span>
                </button>
                <div class="collapse navbar-collapse" id="navbarNav" style="padding-right:60px;">
                    <ul class="navbar-nav ms-auto">
                        <li>
                            <a class="nav-link active" aria-current="page" href="penilai_dashboard.php">Dashboard Penilai</a>
                        </li>
                        <li>
                            <a class="nav-link active" aria-current="page" href="list_organisasi.php">Daftar Organisasi</a>
                        </li>
                       
                        
                    </ul>
                </div>
            </div>
</nav>

</head>

<body>
 <!-- Navbar -->
    <!-- <div class="navbar">
        <a href="list_organisasi.php">Daftar Organisasi</a>
        <a href="logout.php">Logout</a>
    </div>
    -->
    <h2>Dashboard Penilai</h2>

    <div class="container">
        <form action="penilai_dashboard.php?id_organisasi=<?php echo $id_organisasi; ?>" method="POST">
            <?php if (!empty($kuesionerByOrganisasi)): ?>
                <?php foreach ($kuesionerByOrganisasi as $nama_organisasi => $kuesioners): ?>
                    <h3>Organisasi: <?php echo htmlspecialchars($nama_organisasi); ?></h3>
                    <table>
                        <thead>
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
                        </thead>
                        <tbody>
                            <?php foreach ($kuesioners as $kuesioner): ?>
                                <tr>
                                    <td><?php echo htmlspecialchars($kuesioner['pertanyaan']); ?></td>
                                    <td><?php echo htmlspecialchars($kuesioner['jawaban']); ?></td>
                                    <td><?php echo htmlspecialchars($kuesioner['link']); ?></td>
                                    <td><?php echo htmlspecialchars($kuesioner['dokumen']); ?></td>
                                    <td>
                                        <input type="number" name="nilai[<?php echo $kuesioner['id_kuesioner']; ?>]" value="<?php echo htmlspecialchars($kuesioner['nilai']); ?>" step="0.01">
                                    </td>
                                    <td>
                                        <textarea name="catatan[<?php echo $kuesioner['id_kuesioner']; ?>]"><?php echo htmlspecialchars($kuesioner['catatan']); ?></textarea>
                                    </td>
                                    <td style="text-align: center;">
                                        <input type="checkbox" name="verifikasi[<?php echo $kuesioner['id_kuesioner']; ?>]" <?php echo $kuesioner['verifikasi'] ? 'checked' : ''; ?>>
                                    </td>
                                    <td>
                                        <input type="hidden" name="update[<?php echo $kuesioner['id_kuesioner']; ?>]" value="1">
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                <?php endforeach; ?>
                <button type="submit" class="button">Simpan Perubahan</button>
            <?php else: ?>
                <p>Tidak ada kuesioner yang tersedia untuk organisasi ini.</p>
            <?php endif; ?>
        </form>
    </div>
</body>

</html>


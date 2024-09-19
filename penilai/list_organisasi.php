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

// Ambil daftar organisasi yang dapat dinilai oleh penilai
$sql = "SELECT o.id_organisasi, o.nama_organisasi
        FROM organisasi o
        JOIN penilai_user_access pua ON o.id_organisasi = pua.id_organisasi
        WHERE pua.id_penilai = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param('i', $id_penilai);
$stmt->execute();
$result = $stmt->get_result();

?>
<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Daftar Organisasi</title>
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        .bg-blue-dark {
            background-color: #4535C1; /* Warna biru gelap */
        }
        .navbar a:hover {
            text-decoration: underline;
        }
        .navbar a {
                margin: 0 10px;
            }   
    </style>
     <nav class="navbar navbar-expand-lg bg-body-tertiary fixed-top" style="border-bottom: 2px solid #4535C1; height: 80px;">
            <div class="container-fluid fs-4">
                <a class="navbar-brand fs-5" href="#" style="padding-left:60px;">
                    <img src="1.png" alt="Logo" width="80" height="64" class="d-inline-block align-text-top">
                </a>
                <div>Sistem Penilaian</div>
                <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                    <span class="navbar-toggler-icon"></span>
                </button>
                <div class="collapse navbar-collapse" id="navbarNav" style="padding-right:60px;">
                    <ul class="navbar-nav ms-auto">
                        <li>
                            <a class="nav-link active" aria-current="page" href="penilai_beranda.php">Dashboard Penilai</a>
                        </li>
                        <li>
                            <a class="nav-link active" aria-current="page" href="list_organisasi.php">Daftar Organisasi</a>
                        </li>
                        <li>
                            <a class="nav-link active" aria-current="page" href="logout_penilai.php">Logout</a>
                        </li>
                       
                        
                    </ul>
                </div>
            </div>
</nav>

</head>

<body>

<br>
<br>
    <!-- Main Content -->
    <div class="container mt-5">
        <h2 class="text-center mb-4">Daftar Organisasi yang Bisa Dinilai</h2>

        <?php if ($result->num_rows > 0): ?>
            <div class="table-responsive">
                <table class="table table-bordered table-striped table-hover">
                    <thead class="table-dark">
                        <tr>
                            <th>Nama Organisasi</th>
                            <th class="text-center">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php while ($row = $result->fetch_assoc()): ?>
                            <tr>
                                <td><?php echo htmlspecialchars($row['nama_organisasi']); ?></td>
                                <td class="text-center">
                                    <a href="penilai_dashboard.php?id_organisasi=<?php echo $row['id_organisasi']; ?>"
                                       class="btn btn-primary">Lihat Kuesioner</a>
                                </td>
                            </tr>
                        <?php endwhile; ?>
                    </tbody>
                </table>
            </div>
        <?php else: ?>
            <div class="alert alert-warning text-center">
                Tidak ada organisasi yang dapat dinilai.
            </div>
        <?php endif; ?>
    </div>

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>


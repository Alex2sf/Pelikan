<?php
session_start();
if (!isset($_SESSION['id_akun']) || $_SESSION['role'] != 'penilai') {
    header("Location: login_penilai.php");
    exit();
}
ob_start();
session_start();
$username="";
$username1=$_SESSION["role"];

include '../koneksi.php';

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
  <script type="text/javascript" src="../js/bootstrap.js"></script>
  <script type="text/javascript" src="../js/bootstrap.min.js"></script>
  <link href="../css/bootstrap.min.css" type="text/css" rel="stylesheet">
  <link href="pelikan.css" type="text/css" rel="stylesheet">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
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
            footer {
                width: 100%;
                background-color: #4535C1;
                color: white;
                padding: 10px;
                position: fixed;
                bottom: 0;
                left: 0;
                text-align: center;
            }
    </style>
</head>
<body>
<nav class="navbar navbar-expand-lg bg-body-tertiary fixed-top" style="border-bottom: 2px solid #4535C1; height: 60px;">
            <div class="container-fluid fs-5">
                <a class="navbar-brand fs-5" href="#" style="padding-left:60px; padding-top:-10px">
                    <img src="../img/pelikanlogo.png" alt="Logo" width="60" class="d-inline-block align-text-top">
                </a>
                <div class="pelikan">PELIKAN (penilai)</div>
                <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                    <span class="navbar-toggler-icon"></span>
                </button>
                <div class="collapse navbar-collapse" id="navbarNav" style="padding-right:60px;">
                    <ul class="nav nav-tabs ms-auto">
                        <li class="nav-item px-2">
                            <a class="nav-link black" aria-current="page" href="penilai_beranda.php">Beranda</a>
                        </li>
                        <li class="nav-item px-2">
                            <a class="nav-link active" href="list_organisasi.php">Daftar Organisasi</a>
                        </li>
                       
                        <?php
                        if ($username==$username1){
                            echo '<li class="nav-item">
                            <a class="nav-link black" href="login.php">Login</a>
                            </li>';
                        }else{
                            echo '<li class="nav-item dropdown">
                            <a class="nav-link dropdown-toggle black" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                                Profile
                            </a>
                            <ul class="dropdown-menu">
                                <li><a class="dropdown-item" href="profile.php">My Profile</a></li>
                                <li><a class="dropdown-item" id="logout" href="logout_penilai.php" data-bs-toggle="modal" data-bs-target="#modalLogout">Logout</a></li>
                            </ul>
                            </li>';
                        }
                        ?>
                    </ul>
                </div>
            </div>
        </nav>
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
                        <th class="text-center">Lihat Kuesioner</th>
                        <th class="text-center">Verifikasi</th>
                        <th class="text-center">Batalkan</th>
                        <th class="text-center">Lihat Skor</th>

                    </tr>
                </thead>
                <tbody>
                    <?php while ($row = $result->fetch_assoc()): ?>
                        <tr>
                            <td><?php echo htmlspecialchars($row['nama_organisasi']); ?></td>
                            <!-- Tombol Lihat Kuesioner -->
                            <td class="text-center"><a href="penilai_dashboard.php?id_organisasi=<?php echo $row['id_organisasi']; ?>" class="btn btn-primary">
                                    Lihat Kuesioner
                                </a></td>
                      
                            <!-- Tombol Lakukan Verifikasi -->
                            <td class="text-center"><button class="btn btn-warning" 
                                        data-bs-toggle="modal" 
                                        data-bs-target="#verifikasiModal" 
                                        data-id="<?php echo $row['id_organisasi']; ?>" 
                                        data-action="verifikasi" 
                                        style="margin-left: 10px;">
                                    Lakukan Verifikasi
                                </button></td>
                            <!-- Tombol Batal Verifikasi -->
                            <td class="text-center"><button class="btn btn-danger" 
                                        data-bs-toggle="modal" 
                                        data-bs-target="#verifikasiModal" 
                                        data-id="<?php echo $row['id_organisasi']; ?>" 
                                        data-action="batal" 
                                        style="margin-left: 10px;">
                                    Batal Verifikasi
                            </button></td>
                            </td>

                            <!-- Tombol Lihat Total Skor -->
<td class="text-center">
    <a href="total_skor.php?id_organisasi=<?php echo $row['id_organisasi']; ?>" class="btn btn-info" style="margin-left: 10px;">
        Lihat Total Skor
    </a>
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
<!-- Modal Verifikasi -->
<div class="modal fade" id="verifikasiModal" tabindex="-1" aria-labelledby="verifikasiModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="verifikasiModalLabel">Konfirmasi Verifikasi</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <p id="verifikasiMessage">Apakah Anda yakin ingin melakukan verifikasi?</p>
                <form id="verifikasiForm">
                    <input type="hidden" id="id_organisasi" name="id_organisasi">
                    <input type="hidden" id="verifikasi_action" name="verifikasi_action">
                    <button type="submit" class="btn btn-primary">Ya, Lanjutkan</button>
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                </form>
            </div>
        </div>
    </div>
</div>
 <!--Footer-->
 <footer>
        <div class="container-fluid text-center" style="color:white;">
            <div class="row">
                <div class="col">
            </div>  
                <div class="col-8">
                    ©2024 <a style="text-decoration: none; color:aquamarine">Kementerian Kelautan dan Perikanan</a>. All Rights Reserved
                </div>
                <div class="col">
                </div>
            </div>
        </div>
</footer>
   <!-- Modal Konfirmasi Logout -->
   <div class="modal fade" id="modalLogout" tabindex="-1" aria-labelledby="modalLogoutLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="modalLogoutLabel">Konfirmasi Logout</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                Apakah Anda yakin ingin logout?
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                <button type="button" class="btn btn-danger" id="confirmLogoutBtn">Logout</button>
            </div>
        </div>
    </div>
    
    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script>
document.addEventListener('DOMContentLoaded', function () {
    var verifikasiModal = document.getElementById('verifikasiModal');
    verifikasiModal.addEventListener('show.bs.modal', function (event) {
        var button = event.relatedTarget;
        var idOrganisasi = button.getAttribute('data-id');
        var action = button.getAttribute('data-action');
        var modalTitle = verifikasiModal.querySelector('.modal-title');
        var modalMessage = document.getElementById('verifikasiMessage');
        var inputIdOrganisasi = document.getElementById('id_organisasi');
        var inputVerifikasiAction = document.getElementById('verifikasi_action');

        inputIdOrganisasi.value = idOrganisasi;

        if (action === 'verifikasi') {
            modalTitle.textContent = 'Konfirmasi Verifikasi';
            modalMessage.textContent = 'Apakah Anda yakin ingin melakukan verifikasi?';
            inputVerifikasiAction.value = 'verifikasi';
        } else {
            modalTitle.textContent = 'Konfirmasi Batal Verifikasi';
            modalMessage.textContent = 'Apakah Anda yakin ingin membatalkan verifikasi?';
            inputVerifikasiAction.value = 'batal';
        }
    });

    // Handle form submit
    document.getElementById('verifikasiForm').addEventListener('submit', function (e) {
        e.preventDefault();

        var formData = new FormData(this);

        fetch('verifikasi_handler.php', {
            method: 'POST',
            body: formData
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                alert('Aksi berhasil!');
                location.reload();
            } else {
                alert('Terjadi kesalahan saat menyimpan.');
            }
        })
        .catch(error => {
            console.error('Error:', error);
            alert('Gagal memproses permintaan.');
        });
    });
});

</script>
<script type="text/javascript">
    document.getElementById("confirmLogoutBtn").addEventListener("click", function() {
        window.location.href = "logout_penilai.php"; // Redirect ke halaman logout untuk menghancurkan sesi
    });
</script>
</body>

</html>


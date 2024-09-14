<?php
session_start();
if (!isset($_SESSION['id_akun'])) {
    header("Location: login.php");
    exit();
}
$username="";
$username1=$_SESSION["role"];

$id_akun = $_SESSION['id_akun'];
$conn = new mysqli('localhost', 'root', '', 'emone'); // Ganti dengan kredensial database Anda

if ($conn->connect_error) {
    die("Koneksi gagal: " . $conn->connect_error);
}

// Ambil data organisasi berdasarkan id_akun
$sql = "SELECT * FROM Organisasi WHERE id_akun = $id_akun";
$result = $conn->query($sql);
$organisasi = $result->fetch_assoc();
?>

<html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Document</title>
        <script type="text/javascript" src="../js/bootstrap.js"></script>
        <script type="text/javascript" src="../js/bootstrap.min.js"></script>
        <link href="../css/bootstrap.min.css" type="text/css" rel="stylesheet">
        <link href="pelikan.css" type="text/css" rel="stylesheet">
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
        <style>
            body{
                background-image: url(../img/KKP.jpg);
                background-size: cover; /* Atur gambar agar menutupi seluruh body */
                background-repeat: no-repeat; /* Hindari pengulangan gambar */
                background-position: center center; /* Posisikan gambar di tengah */
                background-attachment: fixed; /* Membuat gambar tetap saat menggulir halaman */
                align-items: center;
                justify-content: center;
                user-select: none; Mencegah seleksi teks di seluruh halaman
                outline: none; /* Menghilangkan outline fokus */
            }

            .fixed{
                background-attachment: fixed; /* Membuat gambar tetap saat menggulir halaman */
            }

            table {
                border-collapse: separate;
                border-spacing: 0 5px; /* Mengatur jarak vertikal antar baris */
                color: black;
            }
            th, td {
                padding: 5px 55px; /* Menambah padding di dalam sel */
            }
            th {
                text-align: left;
            }
            td {
                text-align: left;
            }
        </style>
    </head>
    <body>
        <!--Navigasi Bar-->
        <nav class="navbar navbar-expand-lg bg-body-tertiary fixed-top" style="border-bottom: 2px solid #4535C1; height: 60px;">
            <div class="container-fluid fs-5">
                <a class="navbar-brand fs-5" href="#" style="padding-left:60px;">
                    <img src="img/pngwing.com.png" alt="Logo" width="30" height="24" class="d-inline-block align-text-top">
                </a>
                <div>Pelikan</div>
                <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                    <span class="navbar-toggler-icon"></span>
                </button>
                <div class="collapse navbar-collapse" id="navbarNav" style="padding-right:60px;">
                    <ul class="nav nav-tabs ms-auto">
                        <li class="nav-item px-2">
                            <a class="nav-link black" aria-current="page" href="index.php">Beranda</a>
                        </li>
                        <li class="nav-item px-2">
                            <a class="nav-link black" href="peringkat.php">Peringkat</a>
                        </li>
                        <li class="nav-item px-2">
                            <a class="nav-link black" href="kuesioner.php">Kuesioner</a>
                        </li>
                        <li class="nav-item px-2">
                            <a class="nav-link black" href="alur.php">Alur</a>
                        </li>
                        <?php
                        if ($username==$username1){
                            echo '<li class="nav-item">
                            <a class="nav-link black" href="login.php">Login</a>
                            </li>';
                        }else{
                            echo '<li class="nav-item dropdown">
                            <a class="nav-link dropdown-toggle active" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                                Profile
                            </a>
                            <ul class="dropdown-menu">
                                <li><a class="dropdown-item" href="profile.php">My Profile</a></li>
                                <li><a class="dropdown-item" href="logout.php">Logout</a></li>
                            </ul>
                            </li>';
                        }
                        ?>
                    </ul>
                </div>
            </div>
        </nav>

        <!-- Profile Section -->
        <div class="container-fluid" style="margin-top:120px; margin-bottom: 20px;">
            <div class="row">
                <div class="col"></div>
                <div class="col-12 col-md-8 pt-2 position-relative" style="background-color: white; border-radius: 40px; padding-bottom:25px; opacity:0.8">
                    <h2 class="text-center"style="color:black; padding-top:10px;">Profile Organisasi</h2>
                    <button onclick="window.location.href='form_organisasi.php';" class="btn btn-primary position-absolute" style="top: 30px; right: 35px; border-radius: 20px; border: 0;">
                        <i class="fa-solid fa-pen-to-square"></i>
                    </button>
                    <div class="table-responsive">
                        <table class="table-borderless">
                            <tr>
                                <td>Unit Eselon 1</td>
                                <td>: <?php echo $organisasi['unit_eselon1']?></td>
                            </tr>
                            <tr>
                                <td>Nama Organisasi</td>
                                <td>: <?php echo $organisasi['nama_organisasi']?></td>
                            </tr>
                            <tr>
                                <td>Email Organisasi</td>
                                <td>: <?php echo $organisasi['email_badan']?></td>
                            </tr>
                            <tr>
                                <td>Alamat</td>
                                <td>: <?php echo $organisasi['alamat']?></td>
                            </tr>
                            <tr>
                                <td>No Telepon</td>
                                <td>: <?php echo $organisasi['no_telp_fax']?></td>
                            </tr>
                            <tr>
                                <td>NIP</td>
                                <td>: <?php echo $organisasi['nip_responden']?></td>
                            </tr>
                            <tr>
                                <td>Nama Responden</td>
                                <td>: <?php echo $organisasi['nama_responden']?></td>
                            </tr>
                            <tr>
                                <td>Jabatan</td>
                                <td>: <?php echo $organisasi['jabatan']?></td>
                            </tr>
                        </table>
                    </div>
                </div>                                  
                <div class="col">
                    <!-- Kolom ini kosong, bisa diisi dengan elemen lain atau dibiarkan kosong -->
                </div>
            </div>
        </div>



        <!--Footer-->
        <div class="container-fluid text-center fixed-bottom" style="background-color: #4535C1; color:white; padding:20px; margin-top:-20px;">
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
    </body>
</html>

<?php
session_start();

require 'session_timeout.php';

if (!isset($_SESSION['id_akun'])) {
    header("Location: ../index.php");
    exit();
}

$username="";
$username1=$_SESSION["role"];

$id_akun = $_SESSION['id_akun'];
include '../koneksi.php';


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
        <link href="../css/pelikan.css" type="text/css" rel="stylesheet">
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
            
            .form-control {
                border: none;
                border-bottom: 2px solid #ccc; /* Add bottom border */
                border-radius: 0;
                box-shadow: none;
                background: none;
                width: 300px; /* Mengatur panjang input menjadi 300px */
            }

            .form-control-full {
                width: 100%; /* Panjang input menyesuaikan dengan lebar kolom */
            }

            .form-control-wide {
                width: 100%; /* Membuat input mengisi lebar kontainer kolom */
                max-width: 500px; /* Menetapkan lebar maksimum agar tidak terlalu besar */
            }
        </style>
    </head>
    <body>
    <?php include 'navbar.php'; ?>

        <!-- Profile Section -->
        <div class="container-fluid" style="margin-top:90px; margin-bottom: 20px;">
            <div class="row">
                <div class="col"></div>
                <div class="col-12 col-md-8 pt-2 position-relative mx-auto" style="background-color: white; border-radius: 40px; padding-bottom:25px; opacity:0.8">
                    <h2 class="text-center" style="color:black; padding-top:10px;">Profile Organisasi</h2>
                    <button onclick="window.location.href='form_organisasi.php';" class="btn btn-primary position-absolute" style="top: 30px; right: 35px; border-radius: 20px; border: 0;">
                        <i class="fa-solid fa-pen-to-square"></i>
                    </button>
                    <form action="" method="post" style="max-width: 600px; margin: 0 auto;">
                        <div class="form-group row d-flex align-items-center justify-content-center pt-2">
                            <label for="inputName2" class="col-sm-4 col-form-label text-right">Unit Eselon 1</label>
                            <div class="col-sm-8">
                                : <?php echo $organisasi['unit_eselon1'] ?? ''; ?>
                            </div>
                        </div>
                    
                        <div class="form-group row d-flex align-items-center justify-content-center">
                            <label for="inputName2" class="col-sm-4 col-form-label text-right">Nama Organisasi</label>
                            <div class="col-sm-8">
                                : <?php echo $organisasi['nama_organisasi'] ?? ''; ?>
                            </div>
                        </div>
                    
                        <div class="form-group row d-flex align-items-center justify-content-center">
                            <label for="inputemail" class="col-sm-4 col-form-label text-right">Email Organisasi</label>
                            <div class="col-sm-8">
                                : <?php echo $organisasi['email_badan'] ?? ''; ?>
                            </div>
                        </div>
                    
                        <div class="form-group row d-flex align-items-center justify-content-center">
                            <label for="inputnotelp" class="col-sm-4 col-form-label text-right">No Telepon/Fax</label>
                            <div class="col-sm-8">
                                : <?php echo $organisasi['no_telp_fax'] ?? ''; ?>
                            </div>
                        </div>
                    
                        <div class="form-group row d-flex align-items-center justify-content-center">
                            <label for="inputAlamat" class="col-sm-4 col-form-label text-right">Alamat</label>
                            <div class="col-sm-8">
                                : <?php echo $organisasi['alamat'] ?? ''; ?>
                            </div>
                        </div>
                    
                        <div class="form-group row d-flex align-items-center justify-content-center">
                            <label for="inputNip" class="col-sm-4 col-form-label text-right">NIP</label>
                            <div class="col-sm-8">
                                : <?php echo $organisasi['nip_responden'] ?? ''; ?>
                            </div>
                        </div>
                    
                        <div class="form-group row d-flex align-items-center justify-content-center">
                            <label for="inputResponden" class="col-sm-4 col-form-label text-right">Nama Responden</label>
                            <div class="col-sm-8">
                                : <?php echo $organisasi['nama_responden'] ?? ''; ?>
                            </div>
                        </div>
                    
                        <div class="form-group row d-flex align-items-center justify-content-center pb-3">
                            <label for="inputJabatan" class="col-sm-4 col-form-label text-right">Jabatan</label>
                            <div class="col-sm-8">
                                : <?php echo $organisasi['jabatan'] ?? '';?>
                            </div>
                        </div>

                        <div class="form-group row d-flex align-items-center justify-content-center pb-3">
                            <label for="inputtimezone" class="col-sm-4 col-form-label text-right">timezone</label>
                            <div class="col-sm-8">
                                : <?php echo $organisasi['timezone'] ?? '';?>
                            </div>
                        </div>
                    </form>                    
                </div>                  
                <div class="col">
                </div>
            </div>
        </div>

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
        </div>

        <!--Footer-->
        <div class="container-fluid text-center fixed-bottom" style="background-color: #4535C1; color:white; padding:20px">
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

        <!-- Script untuk menangani modal dan submit form -->
        <script type="text/javascript">
            document.getElementById("confirmLogoutBtn").addEventListener("click", function() {
                window.location.href = "logout.php"; // Redirect to the logout page
            });
        </script>
    </body>
</html>

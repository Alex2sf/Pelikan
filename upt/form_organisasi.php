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
                                <li><a class="dropdown-item" id="logout" href="#" data-bs-toggle="modal" data-bs-target="#modalLogout">Logout</a></li>
                            </ul>
                            </li>';
                        }
                        ?>
                    </ul>
                </div>
            </div>
        </nav>

        <!-- Profile Section -->
        <div class="container-fluid" style="margin-top:90px; margin-bottom: 20px;">
            <div class="row">
                <div class="col"></div>
                <div class="col-12 col-md-8 pt-2 position-relative mx-auto" style="background-color: white; border-radius: 40px; padding-bottom:25px; opacity:0.8">
                    <h2 class="text-center" style="color:black; padding-top:10px;">Profile Organisasi</h2>
                    <form id="organisasiForm" action="update_organisasi.php" method="post" style="max-width: 600px; margin: 0 auto;">
                        <div class="form-group row d-flex align-items-center justify-content-center pt-2">
                            <label for="inputName2" class="col-sm-4 col-form-label text-right">Unit Eselon 1</label>
                            <div class="col-sm-8">
                                <input type="text" class="form-control form-control-wide" name="unit_eselon1" value="<?php echo $organisasi['unit_eselon1'] ?? ''; ?>" required>
                            </div>
                        </div>
                    
                        <div class="form-group row d-flex align-items-center justify-content-center">
                            <label for="inputName2" class="col-sm-4 col-form-label text-right">Nama Organisasi</label>
                            <div class="col-sm-8">
                                <input type="text" class="form-control form-control-wide" name="nama_organisasi" value="<?php echo $organisasi['nama_organisasi'] ?? ''; ?>" required>
                            </div>
                        </div>
                    
                        <div class="form-group row d-flex align-items-center justify-content-center">
                            <label for="inputemail" class="col-sm-4 col-form-label text-right">Email Organisasi</label>
                            <div class="col-sm-8">
                                <input type="email" class="form-control form-control-wide" name="email_badan" value="<?php echo $organisasi['email_badan'] ?? ''; ?>" required>
                            </div>
                        </div>
                    
                        <div class="form-group row d-flex align-items-center justify-content-center">
                            <label for="inputnotelp" class="col-sm-4 col-form-label text-right">No Telepon/Fax</label>
                            <div class="col-sm-8">
                                <input type="text" class="form-control form-control-wide" name="no_telp_fax" value="<?php echo $organisasi['no_telp_fax'] ?? ''; ?>" required>
                            </div>
                        </div>
                    
                        <div class="form-group row d-flex align-items-center justify-content-center">
                            <label for="inputAlamat" class="col-sm-4 col-form-label text-right">Alamat</label>
                            <div class="col-sm-8">
                                <input type="text" class="form-control form-control-wide" name="alamat" value="<?php echo $organisasi['alamat'] ?? ''; ?>" required>
                            </div>
                        </div>
                    
                        <div class="form-group row d-flex align-items-center justify-content-center">
                            <label for="inputNip" class="col-sm-4 col-form-label text-right">NIP</label>
                            <div class="col-sm-8">
                                <input type="text" class="form-control form-control-wide" name="nip_responden" value="<?php echo $organisasi['nip_responden'] ?? ''; ?>" required>
                            </div>
                        </div>
                    
                        <div class="form-group row d-flex align-items-center justify-content-center">
                            <label for="inputResponden" class="col-sm-4 col-form-label text-right">Nama Responden</label>
                            <div class="col-sm-8">
                                <input type="text" class="form-control form-control-wide" name="nama_responden" value="<?php echo $organisasi['nama_responden'] ?? ''; ?>" required>
                            </div>
                        </div>
                    
                        <div class="form-group row d-flex align-items-center justify-content-center">
                            <label for="inputJabatan" class="col-sm-4 col-form-label text-right">Jabatan</label>
                            <div class="col-sm-8">
                                <input type="text" class="form-control form-control-wide" id="inputJabatan" name="jabatan" value="<?php echo $organisasi['jabatan'] ?? ''; ?>" required>
                            </div>
                        </div>
                    
                        <div class="form-group row d-flex align-items-center justify-content-center pt-4">
                            <div class="col-sm-8 d-flex justify-content-between">
                                <!-- Kembali ke Beranda Button -->
                                <a href="profile.php" class="btn btn-secondary">Kembali</a>
                    
                                <!-- Submit Button -->
                                <button type="submit" id="formSubmit" class="btn btn-primary" name="submit">Submit</button>
                            </div>
                        </div>
                    </form>                    
                </div>                  
                <div class="col">
                </div>
            </div>
        </div>

        <!-- Modal Konfirmasi Form Profile -->
        <div class="modal fade" id="confirmSubmitModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Konfirmasi</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    Apakah Anda yakin ingin mengirim form ini?
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                    <button type="button" id="confirmSubmitBtn" class="btn btn-primary">Kirim</button>
                </div>
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
        <div class="container-fluid text-center" style="background-color: #4535C1; color:white; padding:20px">
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

        <!-- Include jQuery -->
        <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
        <!-- Include Bootstrap JS -->
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>

        <!-- Script untuk menangani modal dan submit form -->
        <script type="text/javascript">
            $(document).ready(function() {
                // Handle form submit
                $('#organisasiForm').on('submit', function(e) {
                    e.preventDefault(); // Prevent default submission
                    $('#confirmSubmitModal').modal('show'); // Show modal on submit
                });

                // Handle the confirm button in the modal
                $('#confirmSubmitBtn').on('click', function() {
                    $('#confirmSubmitModal').modal('hide'); // Hide the modal

                    // Submit the form after hiding the modal
                    setTimeout(function() {
                        $('#organisasiForm').off('submit').submit(); 
                        document.getElementById('formSubmit').click();// Remove the prevent and submit
                    }, 300); // You can adjust the delay if necessary
                });
            });

            document.getElementById("confirmLogoutBtn").addEventListener("click", function() {
                window.location.href = "logout.php"; // Redirect to the logout page
            });
        </script>   
    </body>
</html>

<?php
session_start();
if (!isset($_SESSION['id_akun'])) {
    header("Location: login.php");
    exit();
}
$username="";
$username1=$_SESSION["role"];
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
            html, body {
            overflow-x: hidden;
        }
        </style>
    </head>
    <body>
        <!--Navigasi Bar-->
        <nav class="navbar navbar-expand-lg bg-body-tertiary fixed-top" style="border-bottom: 2px solid #4535C1; height: 60px;">
            <div class="container-fluid fs-5">
            <a class="navbar-brand fs-5" href="#" style="padding-left:60px; padding-top:-10px">
                    <img src="../img/pelikanlogo.png" alt="Logo" width="60" class="d-inline-block align-text-top">
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
                            <a class="nav-link active" href="alur.php">Alur</a>
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
                                <li><a class="dropdown-item" id="logout" href="#" data-bs-toggle="modal" data-bs-target="#modalLogout">Logout</a></li>
                            </ul>
                            </li>';
                        }
                        ?>
                    </ul>
                </div>
            </div>
        </nav>

        <!--Container Putih Informasi Organisasi-->
        <div class="container-fluid text-center" style="background-color: white; color:black; padding:40px; margin-top:100px;">
            <div class="row">
                <div class="col">
                    
                </div>
                <div class="col-8">
                    <h1>Alur Monitoring dan Evaluasi</h1>
                    <h3>Keterbukaan Informasi Publik</h3>
                </div>
                <div class="col">
                    
                </div>
            </div>
        </div>

        <!--Container Putih Informasi Organisasi-->
        <div class="container-fluid text-center" style="background-color: white; color:black; padding:40px">
            <div class="row">
                <div class="col">
                    
                </div>
                <div class="co-8l">
                    <img src="..." class="img-fluid" alt="alur">
                </div>
                <div class="col">
                    
                </div>
            </div>
        </div>

        <div class="container-fluid text-center" style="background-color: #4535C1; color:white; padding:20px">
        <div class="row" style="background-color: purple;">
                <div class="col">
                </div>  
                <div class="col-8">
                    
                </div>
                <div class="col">
                </div>
            </div>
        </div>

        <!--Container Informasi Kontak-->
        <div class="container-fluid text-center text-black py-4">
            <div class="row">
                <!-- Kolom Informasi Kontak -->
                <div class="col-lg-4 col-md-6 col-12 text-start px-5 pt-3">
                    <div class="mb-2">
                        <b>Sekretariat PPID Utama</b>
                    </div>
                    <div>
                        Gedung Mina Bahari III Lantai GF <br>
                        Jalan Medan Merdeka Timur No. 16 <br>
                        Gambir - Jakarta Pusat
                    </div>               
                </div>
                <div class="col-lg-8 col-md-6 col-12"></div>
            </div>   
            
            <!--Ikon dan Link sosial media-->
            <div class="row pt-4">
                <div class="col-lg-2 col-md-6 col-12 text-start px-5">
                    <div class="mt-3">
                        <div class="d-flex align-items-center mb-3">
                            <div class="me-2">
                                <i class="fa-solid fa-phone"></i>
                            </div>
                            <div>
                                <a href="tel:141" style="text-decoration: none; color: black;">141</a>
                            </div>
                        </div>
                        <div class="d-flex align-items-center mb-3">
                            <div class="me-2">
                                <i class="fa-brands fa-whatsapp"></i>
                            </div>
                            <div>
                                <a href="https://wa.me/628118751141" target="_blank" style="text-decoration: none; color: black;">08118751141</a>
                            </div>
                        </div>                            
                        <div class="d-flex align-items-center mb-3">
                            <div class="me-2">
                                <i class="fa-solid fa-envelope"></i>
                            </div>
                            <div>
                                <a href="mailto:ppidkkp@kkp.go.id" target="_blank" style="text-decoration: none; color: black;">ppidkkp@kkp.go.id</a>
                            </div>
                        </div>
                        <div class="d-flex align-items-center mb-3">
                            <div class="me-2">
                                <i class="fa-solid fa-globe"></i>
                            </div>
                            <div>
                                <a href="https://kkp.go.id" target="_blank" style="text-decoration: none; color: black;">kkp.go.id</a>
                            </div>
                        </div>
                        <div class="d-flex align-items-center mb-3">
                            <div class="me-2">
                                <i class="fa-solid fa-globe"></i>
                            </div>
                            <div>
                                <a href="https://ppid.kkp.go.id" target="_blank" style="text-decoration: none; color: black;">ppid.kkp.go.id</a>
                            </div>
                        </div>
                    </div> 
                </div>
                <div class="col-lg-4 col-md-6 col-12 text-start pt-4 px-5">
                    <div class="d-flex align-items-center mb-3">
                        <div class="me-2">
                            <i class="fa-brands fa-facebook"></i>
                        </div>
                        <div>
                            <a href="https://web.facebook.com/KementerianKelautandanPerikananRI/?locale=id_ID&_rdc=1&_rdr" target="_blank" style="text-decoration: none; color: black;">PPID Kementerian Kelautan dan Perikanan</a>
                        </div>
                    </div>
                    <div class="d-flex align-items-center mb-3">
                        <div class="me-2">
                            <i class="fa-brands fa-instagram"></i>
                        </div>
                        <div>
                            <a href="https://www.instagram.com/ppidkkp/" target="_blank" style="text-decoration: none; color: black;">ppidkkp</a>
                        </div>
                    </div>
                    <div class="d-flex align-items-center mb-3">
                        <div class="me-2">
                            <i class="fa-brands fa-twitter"></i>
                        </div>
                        <div>
                            <a href="https://x.com/ppidkkp" target="_blank" style="text-decoration: none; color: black;">ppidkkp</a>
                        </div>
                    </div>
                </div>
                <div class="col-lg-4 col-12"></div>
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

        <!-- Script untuk menangani modal dan submit form -->
        <script type="text/javascript">
            document.getElementById("confirmLogoutBtn").addEventListener("click", function() {
                window.location.href = "logout.php"; // Redirect to the logout page
            });
        </script>
    </body>
</html>

<?php
ob_start();
session_start();
require 'session_timeout.php';

$username="";
$username1=$_SESSION["role"];

include '../koneksi.php';


// Ambil data organisasi
$sql = "SELECT COUNT(id_organisasi) AS total_count FROM organisasi";
$result = $conn->query($sql);
if ($result) {
    $row = $result->fetch_assoc();
    $total_count = $row['total_count'];
} else {
    $total_count = 0; // Atau bisa menampilkan pesan error
}

$sql = "SELECT COUNT(can_fill_out) AS total_cfo FROM organisasi WHERE can_fill_out = '0'";
$result = $conn->query($sql);
if ($result) {
    $row = $result->fetch_assoc();
    $total_cfo = $row['total_cfo'];
} else {
    $total_cfo = 0; // Atau bisa menampilkan pesan error
}

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
                user-select: none;
                outline: none; /* Menghilangkan outline fokus */
            }
        </style>
    </head>
    <body>
    <?php include 'navbar.php'; ?>


        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>

        <div class="image-container">
            <img src="../img/Kantor KKP.jpg" class="img-fluid" alt="...">
            <div class="overlay-text">
                <b>Pelikan</b>
                <div style="font-size:18px;">Pemantauan Evaluasi Layanan Informasi Kementerian <br> Kelautan dan Perikanan</div>
            </div>
        </div>                

        <!--Container Putih Informasi Organisasi-->
        <div class="container-fluid text-center" style="background-color: white; color:black; padding:40px">
            <div class="row">
                <div class="col" style="border-right: 5px solid #4535C1">
                    <div class="col">
                        <b style="font-size:50px;"><?php echo $total_count; ?></b>
                    </div>
                    <div class="col">
                        UK/UPT Teregistrasi
                    </div>
                </div>
                <div class="col" style="border-right: 5px solid #4535C1">
                    <div class="col">
                        <b style="font-size:50px;"><?php echo $total_cfo; ?></b>
                    </div>
                    <div class="col">
                        UK/UPT Menjawab Kuesioner
                    </div>
                </div>
                <div class="col">
                    <div class="col">
                        <b style="font-size:50px;">120</b>
                    </div>
                    <div class="col">
                        UK/UPT Terverifikasi
                    </div>
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
        <div class="container-fluid text-center" style="background-color: #4535C1; color:white; padding:10px">
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

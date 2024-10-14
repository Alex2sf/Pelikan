<?php
ob_start();
session_start();
if (!isset($_SESSION['role']) || $_SESSION['role'] !== 'admin') {
    header("Location: admin_login.php");
    exit();
}

$username = isset($_SESSION['username']) ? $_SESSION['username'] : '';
$username1 = 'admin';
?>

<!DOCTYPE html>
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
            footer {
                width: 100%;
                background-color: #4535C1;
                color: white;
                padding: 10px;
                bottom: 0;
                left: 0;
                text-align: center;
            }
        </style>
    </head>
    <body>
    <?php
    include('navbar.php');  // Include navbar.php
?>
<!-- Halaman konten lainnya di sini -->

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
                        <b style="font-size:50px;">120</b>
                    </div>
                    <div class="col">
                        UK/UNOR Teregistrasi
                    </div>
                </div>
                <div class="col" style="border-right: 5px solid #4535C1">
                    <div class="col">
                        <b style="font-size:50px;">120</b>
                    </div>
                    <div class="col">
                        UK/UNOR Menjawab Kuesioner
                    </div>
                </div>
                <div class="col">
                    <div class="col">
                        <b style="font-size:50px;">120</b>
                    </div>
                    <div class="col">
                        UK/UNOR Terverifikasi
                    </div>
                </div>
            </div>
        </div>


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

        <!-- Script untuk menangani modal dan submit form -->
        <script type="text/javascript">
            document.getElementById("confirmLogoutBtn").addEventListener("click", function() {
                window.location.href = "logout.php"; // Redirect to the logout page
            });
        </script>
    </body>
</html>
<?php
session_start();
$username="";
$username1=$_SESSION["role"];
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
    <body>
    <?php include 'navbar.php'; ?>


        <div class="container text-center"style="color:black; margin-top:90px;">
            <div class="row">
                <h1>KOMITMEN ORGANISASI</h1>
            </div>
            <div class="row px-5 mt-4" style="text-align: left; font-size:larger">
                <div>Pedoman Pengisian</div>
                <div>1. Parameter Kualitas Informasi hendak mengevaluasi informasi publik pada website Kementerian</div>
                <div>1. Parameter Kualitas Informasi hendak mengevaluasi informasi publik pada website Kementerian</div>
                <div>1. Parameter Kualitas Informasi hendak mengevaluasi informasi publik pada website Kementerian</div>
            </div>
            <div class="pt-5"></div>
                <a href="/home" class="btn btn-secondary btn-full-width btn-custom-corner" style="background-color:#4535C1; width:50%; font-size:x-large; border-radius:25px;">Selanjutnya</a>
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
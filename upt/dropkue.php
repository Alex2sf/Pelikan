<?php
session_start();
$username="";
$username1=$_SESSION["role"];

$conn = new mysqli('localhost', 'root', '', 'sigh'); // Ganti dengan kredensial database Anda

// Cek koneksi database
if ($conn->connect_error) {
    die("Koneksi gagal: " . $conn->connect_error);
}

// Fetch categories for dropdown
$categorySql = "SELECT * FROM Kategori";
$categoryResult = $conn->query($categorySql);
?>

<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Kuesioner</title>
        <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
        <script type="text/javascript" src="../js/bootstrap.js"></script>
        <script type="text/javascript" src="../js/bootstrap.min.js"></script>
        <link href="../css/bootstrap.min.css" type="text/css" rel="stylesheet">
        <link href="pelikan.css" type="text/css" rel="stylesheet">
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
        <style>
            body{
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
                            <a class="nav-link active" href="kuesioner.php">Kuesioner</a>
                        </li>
                        <li class="nav-item px-2">
                            <a class="nav-link black" href="alur.php">Alur</a>
                        </li>
                        <?php
                        // if ($username==$username1){
                        //     echo '<li class="nav-item">
                        //     <a class="nav-link black" href="login.php">Login</a>
                        //     </li>';
                        // }else{
                        //     echo '<li class="nav-item dropdown">
                        //     <a class="nav-link dropdown-toggle active" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                        //         Profile
                        //     </a>
                        //     <ul class="dropdown-menu">
                        //         <li><a class="dropdown-item" href="profile.php">My Profile</a></li>
                        //         <li><a class="dropdown-item" href="logout.php">Logout</a></li>
                        //     </ul>
                        //     </li>';
                        // }
                        ?>
                    </ul>
                </div>
            </div>
        </nav>
            
        <!-- Dropdown for selecting category -->
        <div class="container text-center">
            <div class="row">
                <label for="kategori" style="padding-top:80px; padding-bottom:20px;"><h1>Kuesioner</h1></label>
                <select id="kategori" name="kategori" style="width:30%; margin-bottom:20px;">
                    <option value="" disabled selected>-- Pilih Kategori -- </option>
                    <?php
                    if ($categoryResult->num_rows > 0) {
                        while ($categoryRow = $categoryResult->fetch_assoc()) {
                            echo "<option value='{$categoryRow['id_kategori']}'>{$categoryRow['kategori']}</option>";
                        }
                    }
                    ?>
                </select>

                <div id="questionnaireContainer">
                    <!-- AJAX will load content here -->
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

        <script>
            $(document).ready(function(){
                // When category is selected, fetch the related questions
                $('#kategori').on('change', function() {
                    var id_kategori = $(this).val();
                    
                    $.ajax({
                        url: 'kuesioner.php', // The file that will handle the request
                        type: 'POST',
                        data: {id_kategori: id_kategori},
                        success: function(data) {
                            $('#questionnaireContainer').html(data); // Load response into container
                        }
                    });
                });
            });
        </script>

    </body>
</html>

<?php
$conn->close();
?>

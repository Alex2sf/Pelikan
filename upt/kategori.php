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
                background-image: url(../img/kapalperang.png);
                background-size: cover; /* Atur gambar agar menutupi seluruh body */
                background-repeat: no-repeat; /* Hindari pengulangan gambar */
                background-position: center center; /* Posisikan gambar di tengah */
                background-attachment: fixed; /* Membuat gambar tetap saat menggulir halaman */
                overflow: hidden; /* Mengunci halaman agar tidak bisa di-scroll */
                height: 100vh; /* Memastikan body memenuhi tinggi layar penuh */
                display: flex;
                align-items: center;
                justify-content: center;
            }

            .btn-full-width {
                display: block;
                width: 80%;
                margin: 0 auto; /* Membuat tombol di-center secara horizontal */
            }

            .btn-custom-corner {
                border-radius: 15px;
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
                    <ul class="navbar-nav ms-auto">
                        <li class="nav-item px-2">
                            <a class="nav-link active" aria-current="page" href="#">Beranda</a>
                        </li>
                        <li class="nav-item px-2">
                            <a class="nav-link" href="#">Kuesioner</a>
                        </li>
                        <li class="nav-item px-2">
                            <a class="nav-link" href="#">Alur</a>
                        </li>
                        <li class="nav-item px-2">
                            <a class="nav-link" href="login.html">Login</a>
                        </li>
                    </ul>
                </div>
            </div>
        </nav>

        <div class="container-fluid text-center" style="color:black; padding-top:40px;">
            <div class="row">
              <div class="col"> 
                    <div class="pt-4"><a href="/home" class="btn btn-secondary btn-full-width btn-custom-corner" style="font-size:x-large">Kualitas Informasi</a></div>
                    <div class="pt-4"><a href="index.html" class="btn btn-secondary btn-full-width btn-custom-corner" style="font-size:x-large">Jenis Informasi</a></div>
                    <div class="pt-4 pb-4"><a href="/home" class="btn btn-secondary btn-full-width btn-custom-corner" style="font-size:x-large">Pelayanan Informasi</a></div>
              </div>
              <div class="col">
                    <div class="pt-4"><a href="/home" class="btn btn-secondary btn-full-width btn-custom-corner" style="font-size:x-large">Digitalisasi</a></div>
                    <div class="pt-4"><a href="/home" class="btn btn-secondary btn-full-width btn-custom-corner" style="font-size:x-large">Sarana Prasarana</a></div>
                    <div class="pt-4 pb-4"><a href="/home" class="btn btn-secondary btn-full-width btn-custom-corner" style="font-size:x-large">Komitmen Organisasi</a></div>
              </div>
            </div>
            <div class="pt-5">
                <a href="/home" class="btn btn-secondary btn-full-width btn-custom-corner" style="width:50%; font-size:x-large">Beranda</a>
            </div>
        </div>  
    </body>
</html>
<?php
session_start();
if (!isset($_SESSION['id_akun']) || $_SESSION['role'] != 'penilai') {
    header("Location: login_penilai.php");
    exit();
    
}
ob_start();

$username="";
$username1=$_SESSION["role"];


include '../koneksi.php';

$id_akun = $_SESSION['id_akun'];

?>
<!DOCTYPE html>
<html lang="id">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.6.0/css/all.min.css">
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">


<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard Penilai</title>
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Document</title>
        <script type="text/javascript" src="../js/bootstrap.js"></script>
        <script type="text/javascript" src="../js/bootstrap.min.js"></script>
        <link href="../css/bootstrap.min.css" type="text/css" rel="stylesheet">
        <link href="pelikan.css" type="text/css" rel="stylesheet">
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
        
    <!-- Tambahkan gaya CSS Anda di sini -->
    <style>
        /* Style yang sama dengan kode sebelumnya */
        /* Styling dasar untuk homepage */
body {
    font-family: Arial, sans-serif;
    margin: 0;
    padding: 0;
    background-color: #f4f4f4;
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
header {
    background-color: #f4f4f4;
    padding: 15px;
    text-align: right;
    color: black;
    border-bottom: 5px solid #4834c4;

}
body {
    background-image: url('bg.png'); /* Ganti dengan path ke gambar Anda */
    background-size: cover; /* Menyesuaikan gambar agar menutupi seluruh area */
    background-position: center; /* Menyelaraskan gambar ke tengah */
    background-repeat: no-repeat; /* Menghindari pengulangan gambar */
    background-attachment: fixed; /* Gambar latar belakang tetap saat scroll */
    color: black; /* Warna teks yang kontras dengan gambar latar belakang */
    font-family: Arial, sans-serif; /* Font halaman */
    margin: 0; /* Menghilangkan margin default */
    padding: 0; /* Menghilangkan padding default */
    height: 100vh; /* Memastikan body memiliki tinggi 100% viewport */
    display: flex;
    flex-direction: column;
    justify-content: space-between;
}

main {
    padding: 20px;
    text-align: center;
}

footer {
    background-color: #333;
    color: white;
    text-align: center;
    padding: 10px 0;
    position: absolute;
    bottom: 0;
    width: 100%;
}
.logout-button {
    display: inline-block;
    background-color: #007bff; /* Warna biru */
    color: white; /* Warna teks putih */
    padding: 10px 20px; /* Padding untuk ukuran tombol */
    border-radius: 5px; /* Membuat sudut tombol melengkung */
    text-decoration: none; /* Menghilangkan underline */
    font-size: 16px; /* Ukuran font */
    border: none; /* Menghilangkan border default */
    cursor: pointer; /* Mengubah kursor menjadi pointer saat di-hover */
}

.logout-button:hover {
    background-color: #0056b3; /* Warna biru lebih gelap saat di-hover */
}
.uppercase-bold {
            text-transform: uppercase; /* Mengubah teks menjadi huruf besar */
            font-weight: bold; /* Membuat teks tebal */
            font-size: 50px;
}
            
            .text-normal {
    font-weight: normal;      /* Membuat teks menjadi tidak bold */
    font-size: 18px;          /* Mengatur ukuran teks menjadi ukuran normal (misalnya 16px) */
    color: #000;              /* Warna teks hitam (atau Anda bisa ganti sesuai keinginan) */
    text-transform: none;     /* Tidak mengubah huruf menjadi besar atau kecil */
    font-style: normal;       /* Mengatur gaya font menjadi normal (tidak italic) */
}
.bigtext{
    text-transform: uppercase; /* Mengubah teks menjadi huruf besar */
            font-weight: bold; /* Membuat teks tebal */
            font-size: 30px;
}
        
        h1 {
            margin: 20px 0; /* Memberikan margin di atas dan bawah teks */
        }
        
        div{
            
  color: black;
  margin: 20px;
  padding: 10px;
  
        }
        .grid-container {
    display: grid;                      /* Mengaktifkan grid layout */
    grid-template-columns: repeat(4, 1fr);  /* Membuat 3 kolom dengan lebar yang sama */
    grid-gap: 1px;                     /* Memberikan jarak antara elemen grid */
    padding-right: 100px;                      /* Memberikan padding di dalam grid container */

}

/* Gaya untuk elemen grid-item */
@import url('https://fonts.googleapis.com/css2?family=Poppins:wght@400;600&display=swap');

.grid-item {
    font-family: 'Poppins', sans-serif;  /* Menggunakan font Poppins */
    font-size: 18px;                     /* Ukuran font */
    font-weight: 600;                    /* Mengatur ketebalan font */
    color: #333;                         /* Warna teks */
    background-color: transparent;           /* Warna latar belakang item */
    padding: 15px;                       /* Ruang di dalam setiap item */
    text-align: left;                    /* Teks rata kiri */
    border-radius: 8px;                  /* Membuat sudut membulat */
    box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1); /* Bayangan lembut */
    transition: background-color 0.3s ease, transform 0.3s ease; /* Animasi hover */
    letter-spacing: 0.5px;               /* Jarak antar huruf */
    line-height: 1.6;                    /* Tinggi baris */
}

.grid-item:hover {
    background-color: #e0e0e0;           /* Ubah warna latar belakang saat di-hover */
    transform: translateY(-5px);         /* Efek melayang ke atas saat di-hover */
}

.logo {
    margin-right: auto; /* Memastikan logo tetap di sisi kiri, sementara menu di sebelah kanan */
  }
  .logo img {
    margin-right: 10px; /* Memberi jarak antara gambar dan teks */
  }
  .pelikan {
            font-family: 'Arial', sans-serif;
            font-size: 35px ;
            color: #3498db;
            text-transform: uppercase;
            letter-spacing: 2px;
            position: relative;
            display: inline-block;
            transition: all 0.3s ease;
        }

        .pelikan:hover {
            color: #e74c3c;
            text-shadow: 2px 2px 5px rgba(0, 0, 0, 0.3);
            transform: scale(1.1);
        }

        .pelikan::after {
            
            font-size: 0.5em;
            position: absolute;
            top: 100%;
            left: 50%;
            transform: translateX(-50%);
            color: #2c3e50;
        }
    </style>
</head>
<body>
     <!--Navigasi Bar-->
     <li class="nav-item dropdown">
    <a class="nav-link dropdown-toggle black" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">
        Profile
    </a>
    <ul class="dropdown-menu">
        <li><a class="dropdown-item" href="profile.php">My Profile</a></li>
        <li><a class="dropdown-item" id="logout" href="#" data-bs-toggle="modal" data-bs-target="#modalLogout">Logout</a></li>
    </ul>
</li>

        <!--Navigasi Bar-->
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
                            <a class="nav-link active" aria-current="page" href="admin_dashboard.php">Beranda</a>
                        </li>
                        <li class="nav-item px-2">
                            <a class="nav-link black" href="list_organisasi.php">Daftar Organisasi</a>
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

   <div>
    <br>
    <br>
    <h1 class="uppercase-bold">Selamat datang</h1>
    <h1 class="uppercase-bold">PPID KKP</h1><br><br><br><br>
    
    </div>
    <div>
    <h1 class="bigtext">Sekretariat PPID Utama</h1>
    <h1 class="text-normal">Gedung Mina Bahari III lantai GF</h1>
    <h1 class="text-normal">Jalan Medan Merdeka Timur No.16</h1>
    <h1 class="text-normal">Gambir Jakarta Pusat</h1>
    </div>
    <div class="grid-container">
        <div class="grid-item"><i class="fa-solid fa-phone-volume"></i> ppid.kkp.go.id</a></div>
        <div class="grid-item"><i class="fa-solid fa-globe"></i> www.kkp.go.id</div>
        <div class="grid-item"></div>
        <div class="grid-item"></div>
        <div class="grid-item"><i class="fa-brands fa-whatsapp"></i> 0811 8751 141</div>
        <div class="grid-item"><i class="fa-solid fa-globe"></i> ppid.kkp.go.id</div>
        <div class="grid-item"></div>
        <div class="grid-item"></div>
        <div class="grid-item"><i class="fa-regular fa-envelope"></i> ppidkkp@kkp.go.id</div>
        <div class="grid-item"><i class="fa-brands fa-facebook"></i>PPID Kementrian Kelautan dan Perikanan</div>
        <div class="grid-item"></div>
        <div class="grid-item"></div>
        <div class="grid-item"><i class="fa-brands fa-instagram"></i>ppidkkp</div>
        <div class="grid-item"><i class="fa-brands fa-x-twitter"></i></i>ppidkkp</div>
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
<div class="container-fluid text-center" style="background-color: #4535C1; color:white; padding:50px">
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

<script type="text/javascript">
    document.getElementById("confirmLogoutBtn").addEventListener("click", function() {
        window.location.href = "logout_penilai.php"; // Redirect ke halaman logout untuk menghancurkan sesi
    });
</script>

</body>
</html>

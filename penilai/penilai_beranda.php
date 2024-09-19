<?php
session_start();
if (!isset($_SESSION['id_akun']) || $_SESSION['role'] != 'penilai') {
    header("Location: login_penilai.php");
    exit();
}

$conn = new mysqli('localhost', 'root', '', 'sigh'); // Ganti dengan kredensial database Anda

// Cek koneksi database
if ($conn->connect_error) {
    die("Koneksi gagal: " . $conn->connect_error);
}

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
    color: #333; /* Warna teks yang kontras dengan gambar latar belakang */
    font-family: Arial, sans-serif; /* Font halaman */
    margin: 0; /* Menghilangkan margin default */
    padding: 0; /* Menghilangkan padding default */
    height: 100vh; /* Memastikan body memiliki tinggi 100% viewport */
    display: flex;
    flex-direction: column;
    justify-content: space-between;
}
.navbar {
            background-color: #2c3e50;
            color: white;
            padding: 15px;
            text-align: center;
        }

        .navbar a {
            color: white;
            margin: 0 15px;
            text-decoration: none;
            font-weight: 500;
        }

        .navbar a:hover {
            text-decoration: underline;
        }
        .navbar a {
                margin: 0 10px;
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
.grid-item {
              /* Warna latar belakang item */
    color: black;                        /* Warna teks */
    padding: 1px;                       /* Ruang di dalam setiap item */
    text-align: left;                  /* Teks di tengah */
    font-size: 18px;                     /* Ukuran font */
    border-radius: 1px;                  /* Membuat sudut membulat */
}
.logo {
    margin-right: auto; /* Memastikan logo tetap di sisi kiri, sementara menu di sebelah kanan */
  }
  .logo img {
    margin-right: 10px; /* Memberi jarak antara gambar dan teks */
  }
    </style>
</head>
<body>
    <!-- Header Section -->
    <header>
        
    <nav class="navbar navbar-expand-lg bg-body-tertiary fixed-top" style="border-bottom: 2px solid #4535C1; height: 80px;">
            <div class="container-fluid fs-4">
                <a class="navbar-brand fs-5" href="#" style="padding-left:60px;">
                    <img src="img/1.png" alt="Logo" width="80" height="64" class="d-inline-block align-text-top">
                </a>
                <div>Selamat Datang Di Sistem Penilaian</div>
                <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                    <span class="navbar-toggler-icon"></span>
                </button>
                <div class="collapse navbar-collapse" id="navbarNav" style="padding-right:60px;">
                    <ul class="navbar-nav ms-auto">
                        <li>
                            <a class="nav-link active" aria-current="page" href="list_organisasi.php">Organisasi</a>
                        </li>
                        <li>
                            <a class="nav-link active" aria-current="page" href="logout_penilai.php">Logout</a>
                        </li>
                       
                        
                    </ul>
                </div>
            </div>
</nav>
    </header>
   <div>
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
    
    



    
</body>
</html>

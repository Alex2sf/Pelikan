<?php
session_start();
if (!isset($_SESSION['id_akun']) || $_SESSION['role'] != 'penilai') {
    header("Location: login_penilai.php");
    exit();
}
ob_start();
session_start();
$username="";
$username1=$_SESSION["role"];

include '../koneksi.php';

$id_akun = $_SESSION['id_akun'];

// Ambil id_organisasi dari URL
if (isset($_GET['id_organisasi'])) {
    $id_organisasi = $_GET['id_organisasi'];

    // Ambil data organisasi dari database berdasarkan id_organisasi
    $sql = "SELECT * FROM organisasi WHERE id_organisasi = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $id_organisasi);
    $stmt->execute();
    $result = $stmt->get_result();
    $organisasi = $result->fetch_assoc();

    if (!$organisasi) {
        echo "Organisasi tidak ditemukan.";
        exit();
    }
} else {
    echo "ID Organisasi tidak disediakan.";
    exit();
}

$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <script type="text/javascript" src="../js/bootstrap.js"></script>
        <script type="text/javascript" src="../js/bootstrap.min.js"></script>
        <link href="../css/bootstrap.min.css" type="text/css" rel="stylesheet">
        <link href="../css/pelikan.css" type="text/css" rel="stylesheet">
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <title>Form Penilaian</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f4;
            margin: 0;
            padding: 0;
            background-image: url('img/Kantor KKP.jpg'); /* Path ke gambar background */
            background-size: cover;
            background-position: center;
            background-attachment: fixed;
            background-repeat: no-repeat;
        }

        .pelikan {
            font-family: 'Arial', sans-serif;
            font-size: 35px;
            color: #3498db;
            text-transform: uppercase;
            letter-spacing: 2px;
            position: relative;
            display: inline-block;
            transition: all 0.3s ease;
        }

        .bg-blue-dark {
            background-color: #4535C1; /* Warna biru gelap */
        }

        .navbar a:hover {
            text-decoration: underline;
        }

        .navbar a {
            margin: 0 10px;
        }  

        /* Layout Flexbox untuk form */
        .container {
            max-width: 900px;
            margin: 50px auto;
            background-color: rgba(255, 255, 255, 0.9);
            padding: 30px;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
            border-radius: 8px;
            text-align: center;
        }

        h1 {
    text-align: center;
    font-size: 36px; /* Meningkatkan ukuran font untuk kesan lebih tegas */
    color: #ffffff; /* Menggunakan warna putih agar lebih kontras namun tetap lembut */
    margin-bottom: 20px;
    font-weight: bold; /* Menambah ketebalan huruf */
    text-transform: uppercase; /* Mengubah semua huruf menjadi kapital untuk menambah ketegasan */
    text-shadow: 2px 2px 5px rgba(0, 0, 0, 0.7); /* Menambah bayangan untuk membuat teks lebih terlihat di atas background */
}

h1:after {
    content: '';
    display: block;
    width: 60px; /* Sedikit memperbesar garis bawah */
    height: 3px; /* Membuat garis lebih tebal */
    background-color: #3498db; /* Warna biru lembut yang lebih sesuai untuk harmoni */
    margin: 10px auto 0;
    border-radius: 2px; /* Memberi sedikit rounded pada garis bawah */
}


        h2 {
            text-align: center;
            margin-bottom: 30px;
        }

        .form-group {
            display: flex;
            justify-content: space-between;
            margin-bottom: 15px;
            text-align: center;
        }

        .form-group label {
            flex: 1;
            font-weight: bold;
            font-size: 16px;
            color: #333;
            margin-right: 10px;
            text-align: right;
        }

        .form-group input {
            flex: 4;
            padding: 10px;
            border: 1px solid #ddd;
            border-radius: 6px;
            font-size: 14px;
        }

        .form-control:focus {
            border-color: #007BFF;
            outline: none;
        }

        .button {
            width: 100%;
            padding: 12px;
            background-color: #007BFF;
            color: white;
            font-size: 16px;
            font-weight: bold;
            border: none;
            border-radius: 6px;
            cursor: pointer;
            text-align: center;
            transition: background-color 0.3s ease;
        }

        .button:hover {
            background-color: #0056b3;
        }

        .form-footer {
            display: flex;
            justify-content: space-between;
            margin-top: 20px;
        }

        /* Gambar latar belakang untuk form */
        .form-background {
            background: url('img/Kantor KKP.jpg') no-repeat center center fixed; /* Path ke gambar background */
            background-size: cover;
        }
    </style>
</head>
<body class="form-background">

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
                            <a class="nav-link black" aria-current="page" href="penilai_beranda.php">Beranda</a>
                        </li>
                        <li class="nav-item px-2">
                            <a class="nav-link active" href="peringkat.php">Penilaian</a>
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
<br>

<h1>PENILAIAN</h1>
<div class="container">
    <h2>Penilaian untuk Organisasi: <?php echo htmlspecialchars($organisasi['nama_organisasi']); ?></h2>
    <form action="simpan_penilaian.php" method="POST">
        <input type="hidden" name="id_organisasi" value="<?php echo htmlspecialchars($id_organisasi); ?>"> 
        
        <!-- Flexbox layout untuk input fields -->
        <?php for ($i = 1; $i <= 5; $i++): ?>
            <div class="form-group">
                <label for="nilai_kategori<?php echo $i; ?>">Nilai Kategori <?php echo $i; ?>:</label>
                <input type="number" id="nilai_kategori<?php echo $i; ?>" name="nilai_kategori<?php echo $i; ?>" class="form-control" required>
            </div>
        <?php endfor; ?>

        <!-- Tombol -->
        <div class="form-footer">
            <button type="submit" class="button">Submit</button>
        </div>
    </form>
</div>

</body>
</html>

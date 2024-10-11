<?php
date_default_timezone_set('Asia/Jakarta');

ob_start();
session_start();

// Cek jika pengguna adalah admin, jika bukan, akses ditolak
if (!isset($_SESSION['role']) || $_SESSION['role'] != 'admin') {
    die('Access denied. Only admins can access this page.');
}

$username = "";
$username1 = $_SESSION["role"];
$modal_message = "";
$modal_type = "";

// Koneksi ke database
$conn = new mysqli('localhost', 'root', '', 'sigh');
if ($conn->connect_error) {
    die("Koneksi gagal: " . $conn->connect_error);
}
// Query untuk mendapatkan data organisasi
$sql = "SELECT id_organisasi, nama_organisasi FROM organisasi";
$result = $conn->query($sql);

// Query untuk mendapatkan data organisasi, termasuk batas_waktu
$sql = "SELECT id_organisasi, nama_organisasi, batas_waktu FROM organisasi";
$result = $conn->query($sql);

$conn->close();

function formatUnixToReadableDate($unixTimestamp) {
    // Membuat objek DateTime dari Unix timestamp
    $dateTime = new DateTime();
    $dateTime->setTimestamp($unixTimestamp);
    
    // Mengatur format tanggal yang bisa dibaca manusia
    return $dateTime->format('d-m-Y H:i:s'); // Anda bisa mengubah format ini sesuai kebutuhan
}
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
        /* Styling untuk halaman admin akses */
body {
    font-family: Arial, sans-serif;
    background-image: url(img/KKP.jpg);
    background-size: cover;
    background-repeat: no-repeat;
    background-position: center center;
    background-attachment: fixed;
    margin: 0;
    margin-top: 120px;
    padding: 0;
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
.container {
    display: flex;
            justify-content: space-between;
            align-items: center;
    background-color: white;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            width: 500px;
            margin-bottom: 30px;
    width: 100%;
    max-width: 1200px;
    margin: 50px auto;
    background-color: #fff;
    padding: 20px;
    border-radius: 8px;
    box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
}

h2,h1 {
    text-align: center;
    margin-bottom: 20px;
    font-size: 24px;
    color: #4535C1;
    font-weight: bold;
    text-transform: uppercase;
    text-shadow: 0 2px 4px rgba(0, 0, 0, 0.2); 
}

form {
    display: flex;
    flex-direction: column;
    gap: 15px;
}
.form-group {
            margin-bottom: 15px;
        }
        .form-group label {
            display: block;
            margin-bottom: 5px;
        }
        .form-group input, .form-group select {
            width: 100%;
            padding: 8px;
            border: 1px solid #ccc;
            border-radius: 4px;
        }
        .submit-btn {
            width: 100%;
            padding: 10px;
            background-color: #4CAF50;
            color: white;
            border: none;
            border-radius: 4px;
            cursor: pointer;
        }
        .submit-btn:hover {
            background-color: #45a049;
        }
        table {
            width: 100%;
            border-collapse: collapse;
        }
        table, th, td {
            border: 1px solid black;
        }
        th, td {
            padding: 10px;
            text-align: left;
        }
        th {
            background-color: #f2f2f2;
        }
        .message {
            text-align: center;
            padding: 10px;
            margin: 15px 0;
            border-radius: 5px;
            font-weight: bold;
        }
        .message.success {
            background-color: #4CAF50;
            color: white;
        }
        .message.error {
            background-color: #f44336;
            color: white;
        }
label {
    font-size: 16px;
    color: #333;
}

select {
    padding: 10px;
    border: 1px solid #ccc;
    border-radius: 4px;
    background-color: #fff;
    font-size: 16px;
    color: #333;
}

table {
    width: 90%; /* Atur lebar tabel menjadi 90% dari kontainer */
    border-collapse: collapse;
    margin-top: 10px;
    margin-bottom: 20px;
    font-size: 16px;
    text-align: left;
    transition: all 0.3s ease;
    margin-left: auto;
    margin-right: auto; /* Mengatur agar tabel berada di tengah dengan jarak seimbang */
}

.nama-organisasi {
            font-size: 24px;
            font-weight: bold;
        }
        .btn-akses-waktu {
            padding: 10px 20px;
            background-color: #4CAF50;
            color: white;
            border: none;
            border-radius: 5px;
            text-decoration: none;
            font-size: 16px;
        }
        .btn-akses-waktu:hover {
            background-color: #45a049;
        }
table, th, td {
    border: 1px solid #ddd;
}

th, td {
    padding: 12px 15px;
    border-bottom: 1px solid #ddd;
}

/* Header Styling */
th {
    background-color: #4535C1;
    color: white;
}

thead {
    background-color: #4535C1;
    color: white;
    font-weight: bold;
}

/* Alternating Row Colors */
tr:nth-child(even) {
    background-color: #f9f9f9;
}

/* Hover Effect: Glowing & More Light */


/* Hover Effect on Table Data */


td:first-child {
    color: #000000;
}

td a {
    color: #4535C1;
    text-decoration: none;
    font-weight: bold;
}

td a:hover {
    color: #2e24a3;
}

input[type="text"],
input[type="email"],
select {
    width: 100%;
    padding: 12px;
    margin-bottom: 20px;
    border: 1px solid rgba(255, 255, 255, 0.4); /* Light border */
    background: #ddd; /* Slightly transparent background */
    color: black;
    border-radius: 8px;
    font-size: 16px;
    outline: none;
    transition: border-color 0.3s ease, background-color 0.3s ease; /* Smooth interaction */
}

input[type="text"]:focus,
input[type="email"]:focus,
select:focus {
    border-color: #4535C1;
    background-color: rgba(255, 255, 255, 0.3); /* More solid on focus */
}

/* Submit Button with Futuristic Hover Effect */
input[type="submit"] {
    width: 100%;
    padding: 15px;
    background-color: #4535C1;
    border: none;
    border-radius: 5px;
    color: #ffffff;
    font-size: 18px;
    cursor: pointer;
    transition: background-color 0.3s ease, box-shadow 0.3s ease;
}

input[type="submit"]:hover {
    background-color: #5a47e4; /* Warna ungu yang lebih terang */
    box-shadow: 0 4px 12px rgba(0, 0, 0, 0.2); /* Menambahkan shadow */
}
/* Tombol Balik */
.btn-balik {
    margin-top: 20px;
    display: block;
    width: 100%;
    padding: 10px;
    text-align: center;
    background-color: #ccc;
    color: #333;
    border: none;
    border-radius: 4px;
    font-size: 16px;
    cursor: pointer;
    transition: background-color 0.3s ease;
}

.btn-balik:hover {
    background-color: #999;
}

    </style>
</head>

<body>
<nav class="navbar navbar-expand-lg bg-body-tertiary fixed-top" style="border-bottom: 2px solid #4535C1; height: 60px;">
            <div class="container-fluid fs-5">
                <a class="navbar-brand fs-5" href="#" style="padding-left:60px; padding-top:-10px">
                    <img src="../img/pelikanlogo.png" alt="Logo" width="60" class="d-inline-block align-text-top">
                </a>
                <div>Admin</div>
                <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                    <span class="navbar-toggler-icon"></span>
                </button>
                <div class="collapse navbar-collapse" id="navbarNav" style="padding-right:60px;">
                    <ul class="nav nav-tabs ms-auto">
                        <li class="nav-item px-2">
                            <a class="nav-link black" aria-current="page" href="admin_dashboard.php">Beranda</a>
                        </li>
                        <li class="nav-item px-2">
                            <a class="nav-link black" href="register.php">Daftar Akun</a>
                        </li>
                       <!-- dropdown kuesioner -->
                       <li class="nav-item dropdown">
                            <a class="nav-link dropdown-toggle black" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                                Kuesioner
                            </a>
                            <ul class="dropdown-menu">
                                <li><a class="dropdown-item" href="add_data.php">Tambah Kategori Kuesioner</a></li>
                                <li><a class="dropdown-item" href="add_pertanyaan.php">Tambah Pertanyaan Kuesioner</a></li>
                                <li><a class="dropdown-item" href="daftar_organisasi.php">Hasil Kuesioner</a></li>
                                <li><a class="dropdown-item" href="adminrud_kuesioner.php">Edit Kuesioner</a></li>
                            </ul>
                        </li>
                        <!-- Dropdown Akses -->
                        <li class="nav-item dropdown">
                            <a class="nav-link dropdown-toggle active" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                                Akses
                            </a>
                            <ul class="dropdown-menu">
                                <li><a class="dropdown-item" href="admin_akses.php">Akses UNOR</a></li>
                                <li><a class="dropdown-item" href="akses_penilai.php">Akses Penilai</a></li>
    
                            </ul>
                        </li>
                        <li class="nav-item px-2">
                            <a class="nav-link black" href="Daftar.php">List UNOR</a>
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
    <h1>Masukkan Waktu</h1> 
    <h2>Setel Batas Waktu Pengerjaan Organisasi </h2>
    <div class="container">
    <a href='akses_waktu.php?timezone=semua' class='btn-akses-waktu'>Atur Waktu Penilaian</a>
    <table>
        <thead>
            <tr>
                <th>No</th>
                <th>Nama Organisasi</th>
                <th>Durasi Pengerjaan</th>
                <th>Aksi</th>
            </tr>
        </thead>
        <tbody>
            <?php
            // Cek apakah ada data yang ditemukan
            if ($result->num_rows > 0) {
                $no = 1; // Inisialisasi nomor urut
                while ($row = $result->fetch_assoc()) {
                    echo "<tr>";
                    echo "<td>" . $no . "</td>";
                    echo "<td>" . $row['nama_organisasi'] . "</td>";

                    // Cek apakah batas_waktu kosong
                    if (empty($row['batas_waktu'])) {
                        echo "<td>Waktu belum diatur</td>"; // Tampilkan pesan jika waktu belum diatur
                    } else {
                        // Ubah batas_waktu dari Unix timestamp ke format yang dapat dibaca
                        $batasWaktuReadable = formatUnixToReadableDate($row['batas_waktu']);
                        echo "<td>" . $batasWaktuReadable . "</td>"; // Tampilkan batas_waktu jika ada
                    }

                    echo "<td><a href='akses_waktu.php?id_organisasi=" . $row['id_organisasi'] . "' class='btn-akses-waktu'>Atur Waktu</a></td>";
                    echo "</tr>";
                    $no++; // Tambah nomor urut
                }
            } else {
                echo "<tr><td colspan='4'>Data organisasi tidak ditemukan.</td></tr>";
            }
            ?>
        </tbody>
    </table>
</div>
<!--  -->


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

<?php if (!empty($modal_message)) { ?>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@10"></script>
    <script>
        Swal.fire({
            title: '<?php echo $modal_type == "success" ? "Success" : "Error"; ?>',
            text: '<?php echo $modal_message; ?>',
            icon: '<?php echo $modal_type == "success" ? "success" : "error"; ?>',
            confirmButtonText: 'OK'
        }).then((result) => {
            if (result.isConfirmed) {
                // Arahkan ke halaman beranda setelah OK diklik
                window.location.href = 'admin_dashboard.php';
            }
        });
    </script>
<?php } ?>

</body>
</html>

<?php

?>

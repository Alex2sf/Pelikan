<?php
ob_start();
session_start();
// Koneksi ke database
$username = isset($_SESSION['username']) ? $_SESSION['username'] : '';
$username1 = 'admin';
include '../koneksi.php';


// Query untuk mendapatkan daftar organisasi
$sql = "SELECT DISTINCT o.* 
        FROM organisasi o
        JOIN kuesioner k ON o.id_organisasi = k.id_organisasi
        WHERE k.jawaban IS NOT NULL 
          AND k.nilai IS NOT NULL 
          AND k.catatan IS NOT NULL 
          AND k.verifikasi IS NOT NULL";
$result = $conn->query($sql);
?>

<!DOCTYPE html>
<html lang="id">
<head>
<meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Document</title>
        <script type="text/javascript" src="../js/bootstrap.js"></script>
        <script type="text/javascript" src="../js/bootstrap.min.js"></script>
        <link href="../css/bootstrap.min.css" type="text/css" rel="stylesheet">
        <link href="../css/pelikan.css" type="text/css" rel="stylesheet">
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <title>Daftar Organisasi</title>
    <style>
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
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f9;
            margin: 20px;
            user-select: none; 
                outline: none; /* Menghilangkan outline fokus */
        }
        h1 {
            text-align: center;
            color: #333;
        }
        h3 {
        text-align: center; /* Menempatkan teks di tengah */
        color: #4535c1; /* Mengubah warna teks menjadi biru sesuai permintaan */
        }
        table {
            width: 100%;
            margin: 20px auto;
            border-collapse: collapse;
            background-color: #fff;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        }
        table, th, td {
            border: 1px solid #ddd;
        }
        th, td {
            padding: 15px;
            text-align: center;
        }
        th {
            background-color: #4535c1;
            color: white;
            text-transform: uppercase;
        }
        tr:nth-child(even) {
            background-color: #f9f9f9;
        }
        tr:hover {
            background-color: #f1f1f1;
        }
        .btn-download {
            background-color: #28a745;
            color: white;
            padding: 10px 20px;
            text-decoration: none;
            border-radius: 5px;
            border: none;
            font-size: 14px;
            cursor: pointer;
            transition: background-color 0.3s;
        }
        .btn-download:hover {
            background-color: #218838;
        }
          /* CSS untuk mengubah warna tulisan saat link aktif */
    .nav-link.active {
        color: white !important; /* Mengubah warna tulisan menjadi putih */
        background-color: #4535C1; /* Mengatur latar belakang jika aktif (ganti dengan warna yang diinginkan) */
    }
    
    /* CSS untuk mengatur warna default untuk link */
    .nav-link {
        color: black; /* Warna default untuk semua link */
    }
    
    /* CSS untuk logout */
    #logout {
        color: red; /* Warna merah untuk link logout */
    }
    </style>
</head>
<body>
<?php
    include('navbar.php');  // Include navbar.php
?>

<br><br>
<h3>Hasil Kuesioner</h3>  
    <table>
      
        <thead>  
            
            <tr>
                <th>ID</th>
                <th>Nama Organisasi</th>
                <th>Aksi</th>
            </tr>
        </thead>
        <tbody>
            <?php
            if ($result->num_rows > 0) {
                // Menampilkan data organisasi
                while ($row = $result->fetch_assoc()) {
                    echo "<tr>
                            <td>{$row['id_organisasi']}</td>
                            <td>{$row['nama_organisasi']}</td>
                            <<td><a class='btn-download' href='unduh.php?id={$row['id_organisasi']}'>Lihat Hasil</a></td>
                          </tr>";
                }
            } else {
                echo "<tr><td colspan='3'>Tidak ada Organisasi yang dapat dilihat.</td></tr>";
            }
            ?>
        </tbody>
    </table>
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
<?php
// Tutup koneksi
$conn->close();
?>

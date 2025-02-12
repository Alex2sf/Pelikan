<?php
date_default_timezone_set('Asia/Jakarta');
ob_start();
session_start();
// Set session timeout to 2 hours (7200 seconds)
$timeout_duration = 7200;

// Check if the session is set
if (isset($_SESSION['last_activity'])) {
    // Calculate the session lifetime
    $elapsed_time = time() - $_SESSION['last_activity'];

    // If the session has expired (more than 2 hours), destroy it
    if ($elapsed_time > $timeout_duration) {
        session_unset();     // Unset session variables
        session_destroy();   // Destroy the session
        header("Location: ../index.php?timeout=true"); // Redirect to login page
        exit();
    }
}

// Update the last activity time stamp
$_SESSION['last_activity'] = time();
if (!isset($_SESSION['id_akun'])) {
    header("Location: ../index.php");
    exit();
}
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
function formatUnixToReadableDate($unixTimestamp) {
    // Membuat objek DateTime dari Unix timestamp
    $dateTime = new DateTime();
    $dateTime->setTimestamp($unixTimestamp);
    
    // Mengatur format tanggal yang bisa dibaca manusia
    return $dateTime->format('d-m-Y H:i:s'); // Anda bisa mengubah format ini sesuai kebutuhan
}
$id_organisasi = $_SESSION['id_organisasi'];
$sql = "SELECT can_fill_out FROM organisasi WHERE id_organisasi = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $id_organisasi);
$stmt->execute();
$stmt->bind_result($can_fill_out);
$stmt->fetch();
$stmt->close();

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
                font-family: Arial, sans-serif;
                    background-color: #f4f4f4;
                    display: flex;
                    justify-content: center;
                    align-items: center;
                    height: 100vh;
                    margin: 0;
                user-select: ;
                outline: black; /* Menghilangkan outline fokus */
                margin: 20px;
                padding: 50px;
                overflow-x: hidden;
            }
            .box {
                    background-color: white;
                    padding: 20px;
                    border-radius: 8px;
                    box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
                    width: 300px;
                }
                .box h2 {
                    text-align: center;
                    margin-bottom: 20px;
                }
                .form-group {
    display: flex;
    align-items: center;
    margin-bottom: 15px;
}

.form-group label {
    width: 200px;
    font-weight: bold;
    margin-right: 10px;
    text-align: right;
}

.form-group .form-control-plaintext {
    flex-grow: 1;
    padding-left: 10px;
    border-bottom: 1px solid #ddd;
    padding-bottom: 3px;
}
                .form-group input {
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
            footer {
                width: 100%;
                background-color: #4535C1;
                color: white;
                padding: 5px;
                position: fixed;
                bottom: 0;
                left: 0;
                text-align: center;
            }
                /* Gaya untuk input link */
            input[type="text"] {
                padding: 5px;
                width: 150px;
                border: 2px solid #007BFF;
                border-radius: 50px;
                transition: 0.3s ease;
                text-align: center;
            }

            input[type="text"]:focus, input[type="text"]:valid {
                box-shadow: 0 0 1px rgba(0, 91, 234, 0.2);
            }
            table th, table td {
                padding: 10px;
                text-align: center; /* Menyelaraskan konten secara horizontal ke tengah */
                vertical-align: middle; /* Menyelaraskan konten secara vertikal ke tengah */
                border-bottom: 1px solid #ddd;
            }
            .form-group {
            display: flex;
            justify-content: space-between;
            margin-bottom: 15px;
        }
        .form-group label {
            width: 200px;
            font-weight: bold;
        }
        .form-group .form-control-plaintext {
            flex-grow: 1;
        }
            table td input[type="radio"],
            table td input[type="text"],
            table td input[type="file"] {
                margin: 0 auto; /* Membuat elemen berada di tengah */
                display: block; /* Memastikan elemen berbentuk blok untuk posisi */
            }
            .upload-box {
                font-size: 5 px;
                background: white;
                border-radius: 50px;
                box-shadow: 0px 0px 5px black;
                width: 350px;
                outline:none;
            }
            ::-webkit-file-upload-button{
                color: white;
                background: #206a5d;
                padding:5px;
                border:none;
                border-radius:20px;
                box-shadow: 1px 0 1px 1px #6b4559;
                outline: none;
            }
            ::-webkit-file-upload-button:hover{
                background: #438a5e;
                cursor: pointer;
            }
            .form-submit {
    display: flex;
    justify-content: center;
    margin-top: 20px;
}
        </style>
    </head>
    <body>
    <?php include 'navbar.php'; ?>

  
        <div class="container mt-5">
        <div class="card">
            <div class="card-header">
                <h5>Informasi Penilai dan Organisasi</h5>
            </div>
            <div class="card-body">
                <?php
                // Ambil id_organisasi dari POST atau GET

                // Pastikan id_organisasi ada
                if ($id_organisasi) {
                    $query = $conn->prepare("
                    SELECT o.unit_eselon1, o.nama_organisasi, o.batas_waktu, o.id_penilai, p.nama_penilai, 
                           o.nilai_kategori1, o.nilai_kategori2, o.nilai_kategori3, o.nilai_kategori4, 
                           o.nilai_kategori5, o.nilai_kategori6
                    FROM organisasi o
                    LEFT JOIN profile_penilai p ON o.id_penilai = p.id_penilai
                    WHERE o.id_organisasi = ? 
                    AND o.unit_eselon1 IS NOT NULL AND o.unit_eselon1 <> ''
                    AND o.nama_organisasi IS NOT NULL AND o.nama_organisasi <> ''
                    AND o.batas_waktu IS NOT NULL AND o.batas_waktu <> ''
                    AND o.id_penilai IS NOT NULL AND o.batas_waktu <> ''
                    AND p.nama_penilai IS NOT NULL AND p.nama_penilai <> ''
                    ");
                    
                    $query->bind_param('i', $id_organisasi);  // Bind the parameter
                    $query->execute();
                    $result = $query->get_result();
                
                    // If data is found
                    if ($result->num_rows > 0) {
                        $row = $result->fetch_assoc();
                        $unit_eselon1 = htmlspecialchars($row['unit_eselon1']);
                        $nama_organisasi = htmlspecialchars($row['nama_organisasi']);
                        $batas_waktu = $row['batas_waktu'] ? formatUnixToReadableDate(htmlspecialchars($row['batas_waktu'])) : '';
                        $nama_penilai = htmlspecialchars($row['nama_penilai']);
                        $nilai_kategori1 = htmlspecialchars($row['nilai_kategori1']);
                        $nilai_kategori3 = htmlspecialchars($row['nilai_kategori3']);
                        $nilai_kategori4 = htmlspecialchars($row['nilai_kategori4']);
                        $nilai_kategori5 = htmlspecialchars($row['nilai_kategori5']);
                        $nilai_kategori6 = htmlspecialchars($row['nilai_kategori6']);

                       // Dapatkan waktu sekarang dalam format UNIX timestamp
$waktu_sekarang = time(); // Waktu sekarang dalam UNIX timestamp

// Bandingkan waktu sekarang dengan batas waktu untuk satu zona waktu (misalnya WIB)
    // Pastikan batas_waktu diubah ke UNIX timestamp jika bukan angka
    if (!is_numeric($batas_waktu)) {
        $batas_waktu = strtotime($batas_waktu);
    }
    

    $is_batas_waktu_terlampaui = ($waktu_sekarang > $batas_waktu) ? true : false;

                ?>
                        <?php if(isset($message)) : ?>
                            <div class="alert alert-warning">
                            <?= $message ? $message : '' ?>
                            </div>
                        <?php endif ?>
                         <!-- Tampilkan data secara horizontal -->
                    <div class="form-group">
                        <label for="unit_eselon1">Unit Eselon 1:</label>
                        <span class="form-control-plaintext" id="unit_eselon1"><?php echo $unit_eselon1; ?></span>
                    </div>

                    <div class="form-group">
                        <label for="nama_organisasi">Nama Organisasi:</label>
                        <span class="form-control-plaintext" id="nama_organisasi"><?php echo $nama_organisasi; ?></span>
                    </div>

                    <div class="form-group">
                        <label for="nama_penilai">Nama Penilai:</label>
                        <span class="form-control-plaintext" id="nama_penilai"><?php echo $nama_penilai; ?></span>
                    </div>
<!-- Display category scores -->
<div class="form-group">
    <label for="nilai_kategori1" >Nilai Mengumumkan IP:</label>
    <span class="form-control-plaintext" id="nilai_kategori1">
        <?php echo (!empty($nilai_kategori1)) ? $nilai_kategori1 : 'Belum ada nilai'; ?>
    </span>
</div>

<div class="form-group">
    <label for="nilai_kategori3">Nilai Menyediakan Dokumen Informasi:</label>
    <span class="form-control-plaintext" id="nilai_kategori3">
        <?php echo (!empty($nilai_kategori3)) ? $nilai_kategori3 : 'Belum ada nilai'; ?>
    </span>
</div>

<div class="form-group">
    <label for="nilai_kategori4">Nilai Sarana Prasarana:</label>
    <span class="form-control-plaintext" id="nilai_kategori4">
        <?php echo (!empty($nilai_kategori4)) ? $nilai_kategori4 : 'Belum ada nilai'; ?>
    </span>
</div>

<div class="form-group">
    <label for="nilai_kategori5">Nilai Kelembagaan PPID:</label>
    <span class="form-control-plaintext" id="nilai_kategori5">
        <?php echo (!empty($nilai_kategori5)) ? $nilai_kategori5 : 'Belum ada nilai'; ?>
    </span>
</div>

<div class="form-group">
    <label for="nilai_kategori6">Nilai Digitalisasi:</label>
    <span class="form-control-plaintext" id="nilai_kategori6">
        <?php echo (!empty($nilai_kategori6)) ? $nilai_kategori6 : 'Belum ada nilai'; ?>
    </span>
</div>

                    <div class="form-group">
                        <label for="batas_waktu">Batas Waktu Pengerjaan:</label>
                        <?php 
            if (!empty($batas_waktu)) {
                // Tampilkan batas waktu dalam format yang dapat dibaca manusia
                echo date('d-m-Y H:i:s', $batas_waktu); // Format: Tanggal-Bulan-Tahun Jam:Menit:Detik
            } else {
                echo "Belum diatur";
            }
        ?>                    </div>
                       <!-- Form untuk submit ke kuesioner_valid.php -->
                       <form action="kuesioner.php" method="POST">
    <input type="hidden" name="id_organisasi" value="<?php echo $id_organisasi; ?>">
    
  <?php if($is_batas_waktu_terlampaui): ?>
    <?= "Batas waktu sudah habis" ?>
    <div class="form-submit">
        <a href="hasil_kuesioner.php?id_organisasi=<?php echo $id_organisasi; ?>" class="btn btn-primary" style="margin-top: 10px;">
            Lihat Hasil Kuesioner
        </a>
    </div>
<?php else: ?>
    <div class="form-submit">
    <button type="button" class="btn btn-primary" style="margin-right: 10px;" 
    onclick="<?php if ($can_fill_out == 0): ?>
        alert('Anda tidak dapat mengisi kuesioner saat ini.');
        window.location.href = 'index.php';
    <?php else: ?>
        this.form.submit();  // Submits the form if allowed
    <?php endif; ?>">
    Mulai Mengerjakan
</button>
        <a href="hasil_kuesioner.php?id_organisasi=<?php echo $id_organisasi; ?>" class="btn btn-primary" style="margin-left: 10px;">
            Lihat Hasil Kuesioner
        </a>
    </div>
<?php endif; ?>
</form>
                <?php
                    } else {
                        echo "<div class='alert alert-danger'>Data organisasi tidak lengkap atau belum ada penilai yang ditugaskan.</div>";
                    }
                } else {

                    
                    echo "<p>ID organisasi tidak ditemukan.</p>";
                }
                ?>
            </div>
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
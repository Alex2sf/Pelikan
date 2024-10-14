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

$id_organisasi = isset($_GET['id_organisasi']) ? $_GET['id_organisasi'] : '';
$timezone = isset($_GET['timezone']) ? $_GET['timezone'] : ''; 

// Koneksi ke database
$conn = new mysqli('localhost', 'root', '', 'sigh');
if ($conn->connect_error) {
    die("Koneksi gagal: " . $conn->connect_error);
}

function convertToTimezoneUnix($inputDate, $inputTime) {
    // // Array untuk timezone Indonesia
    // $timezones = [
    //     "WIB" => "Asia/Jakarta",   // Waktu Indonesia Barat
    //     "WIT" => "Asia/Jayapura",  // Waktu Indonesia Timur
    //     "WITA" => "Asia/Bali",     // Waktu Indonesia Tengah
    // ];

    // // Cek apakah timezone valid
    // if (!array_key_exists($timezone, $timezones)) {
    //     return "Timezone tidak valid.";
    // }

    // // Set timezone sesuai input
    // date_default_timezone_set($timezones[$timezone]);

    // Gabungkan input tanggal dan waktu menjadi satu string
    $fullDateTime = $inputDate . ' ' . $inputTime;

    // Mengonversi input waktu menjadi objek DateTime
    $dateTime = DateTime::createFromFormat('Y-m-d H:i', $fullDateTime);
    
    // Cek apakah input waktu valid
    if (!$dateTime) {
        return "Format waktu tidak valid. Gunakan format 'Y-m-d' untuk tanggal dan 'H:i' untuk waktu.";
    }

    // Mengonversi waktu ke timestamp Unix
    return $dateTime->getTimestamp();
}

// Jika form disubmit untuk mengubah batas waktu
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $tanggal = $_POST['tanggal'];
    $waktu = $_POST['waktu'];

    // Gabungkan tanggal dan waktu yang dipilih admin
    $datetime = $tanggal . ' ' . $waktu;

    // Peta zona waktu berdasarkan pilihan
    $timezone_map = [
        'WIB' => 'Asia/Jakarta',
        'WITA' => 'Asia/Makassar',
        'WIT' => 'Asia/Jayapura'
    ];

    // Konversi tanggal dan waktu ke objek DateTime berdasarkan zona waktu yang dipilih
    try { 
            
        
        
        // Konversi ke UNIX timestamp
        $unix_timestamp = convertToTimezoneUnix($tanggal, $waktu);

       
        
        if ($id_organisasi){
             // Simpan batas waktu ke database
        $sql = "UPDATE organisasi SET batas_waktu = ? WHERE id_organisasi = ?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("si", $unix_timestamp, $id_organisasi);
        }
        if ($timezone==="semua"){
            // Simpan batas waktu ke database
       $sql = "UPDATE organisasi SET batas_waktu = ?";
       $stmt = $conn->prepare($sql);
       $stmt->bind_param("s", $unix_timestamp);
       }

       // Ambil ID organisasi dari parameter GET
        

        // Eksekusi query
        if ($stmt->execute()) {
            $modal_message = "Batas waktu berhasil diperbarui!";
            $modal_type = "success";
        } else {
            $modal_message = "Gagal memperbarui batas waktu: " . $stmt->error; // Menggunakan $stmt->error
            $modal_type = "error";
        }

        // Tutup statement
        $stmt->close();
    } catch (Exception $e) {
        // Jika terjadi kesalahan pada DateTime atau zona waktu
        $modal_message = "Terjadi kesalahan: " . $e->getMessage();
        $modal_type = "error";
    }
}

$conn->close();
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
<div style="display: flex; justify-content: space-between; align-items: center; margin: 20px 70px; position: absolute; top: 20px; left: 0; right: 0;">
    <!-- Tombol Back di sebelah kiri -->
    <a href="akses_waktuorganisasi.php" style="text-decoration: none;">
        <button style="padding: 10px 20px; background-color: #4535c1; color: white; border: none; border-radius: 5px; cursor: pointer; display: flex; align-items: center;">
            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="white" width="20px" height="20px" style="margin-right: 10px;">
                <path d="M0 0h24v24H0z" fill="none"/>
                <path d="M12 4V1L3 9l9 8v-3c4.55 0 8.45 1.72 11 5-1-5.48-4.48-10-11-10z"/>
            </svg>
            Back
        </button>
    </a>
</div>


<!-- Form untuk setel batas waktu -->
<div class="container">
    <h2>Setel Batas Waktu Pengerjaan</h2>
    <form action="" method="post">
        <div class="form-group">
            <label for="tanggal">Pilih Tanggal</label>
            <input type="date" id="tanggal" name="tanggal" required>
        </div>
        <div class="form-group">
            <label for="waktu">Pilih Waktu (Jam)</label>
            <input type="time" id="waktu" name="waktu" required>
        </div>
        
        <button type="submit" class="submit-btn">Simpan Batas Waktu</button>
    </form>
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



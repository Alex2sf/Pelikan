<?php
session_start();
if (!isset($_SESSION['id_akun']) || $_SESSION['role'] != 'admin') {
    header("Location: admin_login.php");
    exit();
}

$username="";
$username1=$_SESSION["role"];

// Koneksi ke database
$conn = new mysqli('localhost', 'root', '', 'emone'); // Ganti dengan kredensial database Anda

if ($conn->connect_error) {
    die("Koneksi gagal: " . $conn->connect_error);
}

// Tambahkan akses penilai ke organisasi
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['add_access'])) {
    $id_penilai = $_POST['id_penilai'];
    $id_organisasi = $_POST['id_organisasi'];

    // Cek apakah kombinasi id_penilai dan id_organisasi sudah ada di tabel Penilai_User_Access
    $check_sql = "SELECT * FROM Penilai_User_Access WHERE id_penilai='$id_penilai' AND id_organisasi='$id_organisasi'";
    $check_result = $conn->query($check_sql);

    if ($check_result->num_rows == 0) {
        // Tambahkan akses jika belum ada
        $sql = "INSERT INTO Penilai_User_Access (id_penilai, id_organisasi) VALUES ('$id_penilai', '$id_organisasi')";
        if ($conn->query($sql) === TRUE) {
            // Update kolom id_penilai di tabel Organisasi jika belum ada penilai lain
            $sql_update_organisasi = "UPDATE Organisasi SET id_penilai = '$id_penilai' WHERE id_organisasi = '$id_organisasi' AND id_penilai IS NULL";
            if ($conn->query($sql_update_organisasi) === TRUE) {
                echo "<script>
                    document.addEventListener('DOMContentLoaded', function() {
                        var successModal = new bootstrap.Modal(document.getElementById('successModal'));
                        document.querySelector('#successModal .modal-body').innerText = 'Akses berhasil ditambahkan dan tabel Organisasi berhasil diperbarui!';
                        successModal.show();
                    });
                </script>";
            } else {
                echo "<script>
                    document.addEventListener('DOMContentLoaded', function() {
                        var errorModal = new bootstrap.Modal(document.getElementById('errorModal'));
                        document.querySelector('#errorModal .modal-body').innerText = 'Error mengupdate tabel Organisasi: " . $conn->error . "';
                        errorModal.show();
                    });
                </script>";
            }
        } else {
            echo "<script>
                document.addEventListener('DOMContentLoaded', function() {
                    var errorModal = new bootstrap.Modal(document.getElementById('errorModal'));
                    document.querySelector('#errorModal .modal-body').innerText = 'Error: " . $conn->error . "';
                    errorModal.show();
                });
            </script>";
        }
    } else {
        echo "<script>
            document.addEventListener('DOMContentLoaded', function() {
                var errorModal = new bootstrap.Modal(document.getElementById('errorModal'));
                document.querySelector('#errorModal .modal-body').innerText = 'Akses sudah ada.';
                errorModal.show();
            });
        </script>";
    }
}

// Menghapus Akses Penilai ke Organisasi
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['delete_access'])) {
    $id_penilai = $_POST['id_penilai'];
    $id_organisasi = $_POST['id_organisasi'];

    // Hapus dari tabel Penilai_User_Access
    $sql_delete = "DELETE FROM Penilai_User_Access WHERE id_penilai='$id_penilai' AND id_organisasi='$id_organisasi'";
    if ($conn->query($sql_delete) === TRUE) {
        // Periksa apakah ada akses lain untuk organisasi tersebut
        $check_other_access_sql = "SELECT * FROM Penilai_User_Access WHERE id_organisasi='$id_organisasi'";
        $check_other_access_result = $conn->query($check_other_access_sql);

        if ($check_other_access_result->num_rows == 0) {
            // Set kolom id_penilai menjadi NULL di tabel Organisasi jika tidak ada akses lain
            $sql_update_null = "UPDATE Organisasi SET id_penilai = NULL WHERE id_organisasi = '$id_organisasi'";
            if ($conn->query($sql_update_null) === TRUE) {
                echo "<script>
                    document.addEventListener('DOMContentLoaded', function() {
                        var successModal = new bootstrap.Modal(document.getElementById('successModal'));
                        document.querySelector('#successModal .modal-body').innerText = 'Akses berhasil dihapus dan id_penilai di tabel Organisasi berhasil diatur menjadi NULL.';
                        successModal.show();
                    });
                </script>";
            } else {
                echo "<script>
                    document.addEventListener('DOMContentLoaded', function() {
                        var errorModal = new bootstrap.Modal(document.getElementById('errorModal'));
                        document.querySelector('#errorModal .modal-body').innerText = 'Error mengupdate tabel Organisasi: " . $conn->error . "';
                        errorModal.show();
                    });
                </script>";
            }
        } else {
            echo "<script>
                document.addEventListener('DOMContentLoaded', function() {
                    var successModal = new bootstrap.Modal(document.getElementById('successModal'));
                    document.querySelector('#successModal .modal-body').innerText = 'Akses berhasil dihapus.';
                    successModal.show();
                });
            </script>";
        }
    } else {
        echo "<script>
            document.addEventListener('DOMContentLoaded', function() {
                var errorModal = new bootstrap.Modal(document.getElementById('errorModal'));
                document.querySelector('#errorModal .modal-body').innerText = 'Error: " . $conn->error . "';
                errorModal.show();
            });
        </script>";
    }
}

// Ambil daftar penilai dan organisasi
$penilai_sql = "SELECT * FROM Profile_Penilai";
$penilai_result = $conn->query($penilai_sql);

$organisasi_sql = "SELECT * FROM Organisasi";
$organisasi_result = $conn->query($organisasi_sql);
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
    <title>Atur Akses Penilai</title>
    <style>
         /* Global Reset */
* {
    box-sizing: border-box;
    margin: 0;
    padding: 0;
}

/* Body Styling */
body {
    margin-top: 80px;
    background-image: url(img/KKP.jpg);
    background-size: cover;
    background-repeat: no-repeat;
    background-position: center center;
    background-attachment: fixed;
    font-family: 'Arial', sans-serif;
    display: flex;
    flex-direction: column;
    align-items: center;
    justify-content: center;
    min-height: 100vh;
    padding: 20px;
}

/* Form Container with Transparent and Futuristic Look */
.form-container {
    background: #ffffff; /* Transparent effect */
    backdrop-filter: blur(10px); /* Blurring background for a glass effect */
    padding: 30px;
    border-radius: 16px;
    box-shadow: 0 8px 32px rgba(0, 0, 0, 0.37); /* Stronger and softer shadow */
    max-width: 1200px;
    width: 100%;
    margin-bottom: 20px;
    border: 1px solid rgba(255, 255, 255, 0.18); /* Adding a subtle border */
    transition: all 0.3s ease; /* Smooth transitions */
}

h2 {
    text-align: center;
    margin-bottom: 20px;
    font-size: 24px;
    color: #4535C1;
    font-weight: bold;
    text-transform: uppercase;
    text-shadow: 0 2px 4px rgba(0, 0, 0, 0.2); /* Futuristic shadow */
}

label {
    display: block;
    margin-bottom: 8px;
    font-weight: bold;
    font-size: 14px;
    color: #black;
    text-transform: uppercase;
    letter-spacing: 1px;
}

/* Inputs and Select Styling with Futuristic Effects */
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


/* Responsive Design for Smaller Screens */
@media (max-width: 768px) {
    .form-container {
        padding: 20px;
        max-width: 90%;
    }

    h2 {
        font-size: 20px;
    }
}

@media (max-width: 480px) {
    h2 {
        font-size: 18px;
    }

    input[type="submit"] {
        font-size: 14px;
    }
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
                        <li class="nav-item px-2">
                            <a class="nav-link active" href="akses_penilai.php">Akses Penilai</a>
                        </li>
                        <li class="nav-item px-2">
                            <a class="nav-link black" href="add_data.php">Kuesioner</a>
                        </li>
                        <li class="nav-item px-2">
                            <a class="nav-link black" href="admin_akses.php">Akses UPT</a>
                        </li>
                        <li class="nav-item px-2">
                            <a class="nav-link black" href="Daftar.php">Daftar Upt</a>
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

    <div class="form-container">
        <h2>Atur Akses Penilai</h2>
        <form method="post" action="akses_penilai.php">
            <label for="id_penilai">Pilih Penilai:</label>
            <select name="id_penilai" id="id_penilai" required>
                <?php
                $penilai_result->data_seek(0); // Reset hasil query penilai
                while ($penilai = $penilai_result->fetch_assoc()) {
                    echo "<option value='{$penilai['id_penilai']}'>{$penilai['nama_penilai']} (NIP: {$penilai['nip']})</option>";
                }
                ?>
            </select>

            <label for="id_organisasi">Pilih Organisasi:</label>
            <select name="id_organisasi" id="id_organisasi" required>
                <?php
                $organisasi_result->data_seek(0); // Reset hasil query organisasi
                while ($organisasi = $organisasi_result->fetch_assoc()) {
                    echo "<option value='{$organisasi['id_organisasi']}'>{$organisasi['nama_organisasi']} (Unit: {$organisasi['unit_eselon1']})</option>";
                }
                ?>
            </select>

            <input type="submit" name="add_access" value="Tambahkan Akses">
        </form>
    </div>

    <div class="form-container">
        <h2>Hapus Akses Penilai</h2>
        <form method="post" action="akses_penilai.php">
            <label for="id_penilai">Pilih Penilai:</label>
            <select name="id_penilai" id="id_penilai" required>
                <?php
                $penilai_result->data_seek(0); // Reset hasil query penilai
                while ($penilai = $penilai_result->fetch_assoc()) {
                    echo "<option value='{$penilai['id_penilai']}'>{$penilai['nama_penilai']} (NIP: {$penilai['nip']})</option>";
                }
                ?>
            </select>

            <label for="id_organisasi">Pilih Organisasi:</label>
            <select name="id_organisasi" id="id_organisasi" required>
                <?php
                $organisasi_result->data_seek(0); // Reset hasil query organisasi
                while ($organisasi = $organisasi_result->fetch_assoc()) {
                    echo "<option value='{$organisasi['id_organisasi']}'>{$organisasi['nama_organisasi']} (Unit: {$organisasi['unit_eselon1']})</option>";
                }
                ?>
            </select>

            <input type="submit" name="delete_access" value="Hapus Akses">
        </form>
    </div>

    <!-- Success Modal -->
 <!-- Modal untuk Pesan Kesalahan dan Sukses -->
 <div class="modal fade" id="successModal" tabindex="-1" aria-labelledby="successModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="successModalLabel">Berhasil</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <!-- Pesan Sukses diisi melalui JavaScript -->
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Tutup</button>
                </div>
            </div>
        </div>
    </div>

    <div class="modal fade" id="errorModal" tabindex="-1" aria-labelledby="errorModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="errorModalLabel">Error</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <!-- Pesan Error diisi melalui JavaScript -->
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Tutup</button>
                </div>
            </div>
        </div>
    </div>

    <!-- JavaScript di bagian bawah halaman untuk memastikan Bootstrap sudah di-load -->
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.8/dist/umd/popper.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.min.js"></script>


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




        <!-- Script untuk menangani modal dan submit form -->
        <script type="text/javascript">
            document.getElementById("confirmLogoutBtn").addEventListener("click", function() {
                window.location.href = "logout.php"; // Redirect to the logout page
            });
        </script>
</body>
</html>

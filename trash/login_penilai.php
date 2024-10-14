<?php
session_start();
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = $_POST['username'];
    $password = md5($_POST['password']); // Enkripsi MD5

    // Koneksi ke database
    include '../koneksi.php';

    // Periksa kredensial
    $sql = "SELECT id_akun, role FROM akun_login WHERE username='$username' AND password='$password' AND role='penilai'";
    
    // Debug query
    //echo "Query: $sql<br>";

    $result = $conn->query($sql);

    if (!$result) {
        die("Query gagal: " . $conn->error); // Tampilkan pesan jika query gagal
    }

    if ($result->num_rows > 0) {
        echo "Data ditemukan di database.<br>"; // Debug: Data ditemukan
        $row = $result->fetch_assoc();
        $_SESSION['id_akun'] = $row['id_akun'];
        $_SESSION['role'] = $row['role'];
        header("Location: penilai_beranda.php"); // Arahkan ke halaman dashboard penilai
        exit();
    } else {
        $error_message = "Username atau password salah.";
        $showModal = true; // Set variabel untuk menampilkan modal
        // echo "<p style='color: red;'>Username atau password salah.</p>";
        // echo "Tidak ada data yang cocok ditemukan di database.<br>"; // Debug: Tidak ada data
    }

    // Tutup koneksi
    $conn->close();
}
?>


<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login Penilai</title>
    <style>
            body {
                background-image: url(../img/KKP.jpg);
                background-size: cover;
                background-repeat: no-repeat;
                background-position: center center;
                background-attachment: fixed;
                overflow: hidden;
                height: 100vh;
                display: flex;
                align-items: center;
                justify-content: center;
                user-select: none;
                outline: none; /* Menghilangkan outline fokus */
            }
            .login {
                background-color: #4535C1;
                border-radius: 40px;
                color: white;
            }
        </style>
     <script type="text/javascript" src="../js/bootstrap.js"></script>
        <script type="text/javascript" src="../js/bootstrap.js"></script>
        <script type="text/javascript" src="../js/bootstrap.min.js"></script>
        <link href="../css/bootstrap.min.css" type="text/css" rel="stylesheet">
        <link href="../css/pelikan.css" type="text/css" rel="stylesheet">
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
</head>
<body>

<div class="container text-center" style="margin-top:30px;">
            <div class="row">
                <div class="col"></div>
                <div class="col login">
                    <div class="pt-4">
                        <img src="../img/Logo KKP Sekunder B Putih.png" style="width: 450px; height: auto;" alt="Logo KKP">
                    </div>
                    
                    <form class="px-5 py-3" action="" method="post">
                        <h4>Login Penilai</h4>
                        <div class="form-group">
                            <input class="form-control" type="text" name="username" id="username" placeholder="Username" required>
                        </div>
                        <div class="form-group pt-3">
                            <input class="form-control" type="password" name="password" id="password" placeholder="Password" required>
                        </div>
                        <div class="form-check pt-2 d-flex align-items-left">
                        </div>
                        <button type="submit" class="btn btn-primary" value="Login" style="background-color: #36C2CE; color: black; width: 100%;">Log in</button>
                        <div class="form-check pt-2 d-flex align-items-left">
                        </div>
                    </form>
                    
                    <div class="dropdown-divider"></div>
                    
                </div>
                <div class="col"></div>
            </div>
        </div>

     <!-- Modal untuk pesan kesalahan -->
     <div class="modal fade" id="errorModal" tabindex="-1" aria-labelledby="errorModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="errorModalLabel">Login Gagal</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <?php
                    if (isset($error_message)) {
                        echo $error_message;
                    }
                    ?>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-primary" data-bs-dismiss="modal">OK</button>
                </div>
            </div>
        </div>
    </div>

    <!-- Script untuk menampilkan modal jika login gagal -->
    <?php if (isset($showModal) && $showModal === true): ?>
    <script type="text/javascript">
        var errorModal = new bootstrap.Modal(document.getElementById('errorModal'));
        errorModal.show();
    </script>
    <?php endif; ?>
</body>
</html>

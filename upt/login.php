<?php
session_start();
$conn = new mysqli('localhost', 'root', '', 'emone'); // Ganti dengan kredensial database Anda

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = $_POST['username'];
    $password = md5($_POST['password']); // Enkripsi MD5

    // Cek kredensial pengguna
    $sql = "SELECT * FROM Akun_Login WHERE username='$username' AND password='$password'";
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
        $_SESSION['id_akun'] = $row['id_akun'];
        $_SESSION['role'] = $row['role'];

        // Arahkan pengguna ke halaman pengisian kuesioner
        header("Location: index.php");
    } else {
        echo "<p style='color: red;'>Username atau password salah!</p>";
    }
}
?>

<!DOCTYPE html>
<html>
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
                background-image: url(../img/KKP.jpg);
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

            .login{
                background-color: #4535C1;
                border-radius: 40px;
                color: white;
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
                            <a class="nav-link" href="#">Login</a>
                        </li>
                    </ul>
                </div>
            </div>
        </nav>
        <div class="container text-center" style="margin-top:60px;">
            <div class="row">
                <div class="col">
                </div>
                <div class="col login">
                    <div class="pt-4">
                        <img src="../img/Logo KKP Sekunder B Putih.png" style="width: 450px; height: auto;" alt="Logo KKP">
                    </div>
                    
                    <form class="px-5 py-3" action="" method="post">
                        <div class="form-group">
                          <input class="form-control" type="text" name="username" id="username" placeholder="Username" required>
                        </div>
                        <div class="form-group pt-3">
                          <input class="form-control" type="password" name="password" id="password" placeholder="Password" required>
                        </div>
                        <div class="form-check pt-2 d-flex align-items-left">
                          <input type="checkbox" class="form-check-input me-2" id="dropdownCheck">
                          <label class="form-check-label pb-3" for="dropdownCheck">
                            Remember me
                          </label>  
                        </div>
                        <button type="submit" class="btn btn-primary" value="Login" style="background-color: #36C2CE; color:black">Log in</button>
                    </form>
                    <div class="dropdown-divider"></div>
                    <a class="dropdown-item pb-4" href="#" id="bor">New around here? Sign up</a>
                </div>
                <div class="col">
                </div>
                </div>
          </div>
    </body>
</html>>
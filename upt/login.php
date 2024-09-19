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
        exit();
    } else {
        // Simpan pesan error ke session
        $_SESSION['error_message'] = "Username atau password salah";
        header("Location: login.php"); // Redirect untuk mencegah form resubmission
        exit();
    }
}
?>

<!DOCTYPE html>
<html>
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Login</title>
        <script type="text/javascript" src="../js/bootstrap.js"></script>
        <script type="text/javascript" src="../js/bootstrap.min.js"></script>
        <link href="../css/bootstrap.min.css" type="text/css" rel="stylesheet">
        <link href="../css/pelikan.css" type="text/css" rel="stylesheet">
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
        <style>
            body{
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

            .login{
                background-color: #4535C1;
                border-radius: 40px;
                color: white;
            }
        </style>
    </head>
    <body>

        <div class="container text-center" style="margin-top:60px;">
            <div class="row">
                <div class="col"></div>
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
                    <a class="dropdown-item pb-4" href="index.php" id="bor">Kembali ke Beranda</a>
                </div>
                <div class="col"></div>
            </div>
        </div>

        <!-- Modal Bootstrap -->
        <div class="modal fade" id="loginErrorModal" tabindex="-1" aria-labelledby="loginErrorLabel" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content" style="border-radius:15px; border: 0px solid white;">
                    <div class="modal-header" style="background-color: #36C2CE; border-radius:14px;">
                        <h5 class="modal-title" id="loginErrorLabel">Gagal Login</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <?php echo isset($_SESSION['error_message']) ? $_SESSION['error_message'] : ''; ?>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal" style="background-color: #36C2CE; border:0px">Tutup</button>
                    </div>
                </div>
            </div>
        </div>

        <!-- Script to trigger modal if there is an error -->
        <script>
            var error_message = "<?php echo isset($_SESSION['error_message']) ? $_SESSION['error_message'] : ''; ?>";
            if (error_message) {
                var myModal = new bootstrap.Modal(document.getElementById('loginErrorModal'), {
                    keyboard: false
                });
                myModal.show();
            }
        </script>

        <?php
        // Hapus pesan error setelah ditampilkan agar tidak muncul saat halaman direfresh
        if (isset($_SESSION['error_message'])) {
            unset($_SESSION['error_message']);
        }
        ?>
    </body>
</html>

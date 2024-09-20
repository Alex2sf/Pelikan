<?php
session_start();

$username="";
$username1=$_SESSION["role"];

if (!isset($_SESSION['id_akun']) || $_SESSION['role'] != 'admin') {
    header("Location: admin_login.php");
    exit();
}

// Koneksi ke database
$conn = new mysqli('localhost', 'root', '', 'emone'); // Sesuaikan dengan kredensial database Anda

if ($conn->connect_error) {
    die("Koneksi gagal: " . $conn->connect_error);
}

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['id_organisasi'])) {
    $id_organisasi = $_POST['id_organisasi'];

    // Beri akses ulang kepada user dengan mengubah status_kuesioner menjadi 1
    $sql = "UPDATE Organisasi SET status_kuesioner = 1 WHERE id_organisasi = '$id_organisasi'";

    if ($conn->query($sql) === TRUE) {
        echo "Akses ulang diberikan untuk organisasi ID: $id_organisasi";
    } else {
        echo "Error: " . $sql . "<br>" . $conn->error;
    }
}

// Ambil daftar organisasi
$sql = "SELECT id_organisasi, nama_organisasi FROM Organisasi";
$result = $conn->query($sql);
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

.container {
    width: 100%;
    max-width: 1200px;
    margin: 50px auto;
    background-color: #fff;
    padding: 20px;
    border-radius: 8px;
    box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
}

h2 {
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
                <div>Pelikan</div>
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
                            <a class="nav-link black" href="akses_penilai.php">Akses Penilai</a>
                        </li>
                        <li class="nav-item px-2">
                            <a class="nav-link black" href="add_data.php">Kuesioner</a>
                        </li>
                        <li class="nav-item px-2">
                            <a class="nav-link active" href="admin_akses.php">Akses UPT</a>
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

    <div class="container">
        <h2>Berikan Akses Ulang untuk Kuesioner</h2>
        <form method="post" action="admin_akses.php">
            <label for="id_organisasi">Pilih Organisasi:</label>
            <select name="id_organisasi" id="id_organisasi">
                <?php while ($row = $result->fetch_assoc()): ?>
                    <option value="<?php echo $row['id_organisasi']; ?>">
                        <?php echo htmlspecialchars($row['nama_organisasi']); ?>
                    </option>
                <?php endwhile; ?>
            </select>
            <input type="submit" value="Beri Akses Ulang">
        </form>

        <!-- Tombol Balik -->
        <button class="btn-balik" onclick="window.location.href='admin_dashboard.php'">Kembali ke Beranda</button>
    </div>
        <!-- Modal -->
   <!-- SweetAlert2 -->
   <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script>
        <?php if (!empty($modal_message)) { ?>
            Swal.fire({
                title: '<?php echo $modal_type == "success" ? "Success" : "Error"; ?>',
                text: '<?php echo $modal_message; ?>',
                icon: '<?php echo $modal_type == "success" ? "Success" : "Error"; ?>',
                confirmButtonText: 'OK'
            });

            <?php } ?>

// Show/hide form sections based on role selection
document.querySelector('select[name="role"]').addEventListener('change', function() {
    var role = this.value;
    document.getElementById('penilai-details').style.display = role === 'penilai' ? 'block' : 'none';
    document.getElementById('organisasi-details').style.display = role === 'user' ? 'block' : 'none';
});
    </script>


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

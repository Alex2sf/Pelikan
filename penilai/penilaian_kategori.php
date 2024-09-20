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


$conn = new mysqli('localhost', 'root', '', 'emone'); // Ganti dengan kredensial database Anda

// Cek koneksi database
if ($conn->connect_error) {
    die("Koneksi gagal: " . $conn->connect_error);
}

$id_akun = $_SESSION['id_akun'];

// Ambil detail penilai
$sql = "SELECT id_penilai FROM Profile_Penilai WHERE id_akun='$id_akun'";
$result = $conn->query($sql);
$row = $result->fetch_assoc();
$id_penilai = $row['id_penilai'];

// Ambil organisasi yang terkait dengan penilai
$sql = "SELECT o.id_organisasi, o.nama_organisasi, o.nilai_kategori1, o.nilai_kategori2, o.nilai_kategori3, 
        o.nilai_kategori4, o.nilai_kategori5, o.nilai_kategori6 
        FROM Organisasi o
        JOIN Penilai_User_Access pua ON o.id_organisasi = pua.id_organisasi
        WHERE pua.id_penilai = '$id_penilai'";
$result = $conn->query($sql);

// Inisialisasi array untuk menyimpan data organisasi
$organisasiList = [];
while ($row = $result->fetch_assoc()) {
    $organisasiList[] = $row;
}

// Proses update nilai kategori
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    foreach ($_POST['update'] as $id_organisasi => $update) {
        $nilai_kategori1 = $_POST['nilai_kategori1'][$id_organisasi];
        $nilai_kategori2 = $_POST['nilai_kategori2'][$id_organisasi];
        $nilai_kategori3 = $_POST['nilai_kategori3'][$id_organisasi];
        $nilai_kategori4 = $_POST['nilai_kategori4'][$id_organisasi];
        $nilai_kategori5 = $_POST['nilai_kategori5'][$id_organisasi];
        $nilai_kategori6 = $_POST['nilai_kategori6'][$id_organisasi];

        $sql = "UPDATE Organisasi 
                SET nilai_kategori1 = '$nilai_kategori1', 
                    nilai_kategori2 = '$nilai_kategori2', 
                    nilai_kategori3 = '$nilai_kategori3',
                    nilai_kategori4 = '$nilai_kategori4',
                    nilai_kategori5 = '$nilai_kategori5',
                    nilai_kategori6 = '$nilai_kategori6'
                WHERE id_organisasi = '$id_organisasi'";

        if ($conn->query($sql) !== TRUE) {
            echo "Error: " . $conn->error;
        }
    }
}
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
        <link href="pelikan.css" type="text/css" rel="stylesheet">
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f4;
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        .navbar {
            background-color: #4CAF50;
            overflow: hidden;
            padding: 10px 0;
        }

        .navbar a {
            float: left;
            display: block;
            color: black;
            text-align: center;
            padding: 14px 20px;
            text-decoration: none;
        }

        .navbar a:hover {
            background-color: #45a049;
        }

        h2 {
            text-align: center;
            color: #333;
            margin-top: 20px;
        }

        .container {
            width: 80%;
            margin: 0 auto;
            background-color: #fff;
            padding: 20px;
            box-shadow: 0px 0px 10px rgba(0, 0, 0, 0.1);
            border-radius: 8px;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
        }

        th, td {
            padding: 10px;
            text-align: left;
            border-bottom: 1px solid #ddd;
        }

        th {
            background-color: #4CAF50;
            color: white;
        }

        tr:hover {
            background-color: #f1f1f1;
        }

        input[type="number"] {
            width: 100%;
            padding: 5px;
            border: 1px solid #ccc;
            border-radius: 4px;
        }

        input[type="submit"] {
            background-color: #4CAF50;
            color: white;
            border: none;
            padding: 10px 20px;
            cursor: pointer;
            border-radius: 4px;
            transition: background-color 0.3s ease;
        }

        input[type="submit"]:hover {
            background-color: #45a049;
        }
    </style>
</head>
<body>
<nav class="navbar navbar-expand-lg bg-body-tertiary fixed-top" style="border-bottom: 2px solid #4535C1; height: 60px;">
            <div class="container-fluid fs-5">
                <a class="navbar-brand fs-5" href="#" style="padding-left:60px; padding-top:-10px">
                    <img src="../img/pelikanlogo.png" alt="Logo" width="60" class="d-inline-block align-text-top">
                </a>
                <div class="pelikan">PELIKAN (penilai)</div>
                <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                    <span class="navbar-toggler-icon"></span>
                </button>
                <div class="collapse navbar-collapse" id="navbarNav" style="padding-right:60px;">
                    <ul class="nav nav-tabs ms-auto">
                        <li class="nav-item px-2">
                            <a class="nav-link black" aria-current="page" href="penilai_beranda.php">Beranda</a>
                        </li>
                        <li class="nav-item px-2">
                            <a class="nav-link black" aria-current="page" href="ranking.php">Ranking</a>
                        </li>
                        <li class="nav-item px-2">
                            <a class="nav-link active" aria-current="page" href="penilaian_kategori.php">Penilaian Kategori</a>
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


    <h2>Penilaian Kategori</h2>

    <div class="container">
        <form method="post" action="penilaian_kategori.php">
            <table>
                <tr>
                    <th>Nama Organisasi</th>
                    <th>Kategori 1</th>
                    <th>Kategori 2</th>
                    <th>Kategori 3</th>
                    <th>Kategori 4</th>
                    <th>Kategori 5</th>
                    <th>Kategori 6</th>
                    <th>Action</th>
                </tr>
                <?php foreach ($organisasiList as $row): ?>
                <tr>
                    <td><?php echo htmlspecialchars($row['nama_organisasi']); ?></td>
                    <td><input type="number" name="nilai_kategori1[<?php echo $row['id_organisasi']; ?>]" value="<?php echo $row['nilai_kategori1']; ?>" min="0" max="100"></td>
                    <td><input type="number" name="nilai_kategori2[<?php echo $row['id_organisasi']; ?>]" value="<?php echo $row['nilai_kategori2']; ?>" min="0" max="100"></td>
                    <td><input type="number" name="nilai_kategori3[<?php echo $row['id_organisasi']; ?>]" value="<?php echo $row['nilai_kategori3']; ?>" min="0" max="100"></td>
                    <td><input type="number" name="nilai_kategori4[<?php echo $row['id_organisasi']; ?>]" value="<?php echo $row['nilai_kategori4']; ?>" min="0" max="100"></td>
                    <td><input type="number" name="nilai_kategori5[<?php echo $row['id_organisasi']; ?>]" value="<?php echo $row['nilai_kategori5']; ?>" min="0" max="100"></td>
                    <td><input type="number" name="nilai_kategori6[<?php echo $row['id_organisasi']; ?>]" value="<?php echo $row['nilai_kategori6']; ?>" min="0" max="100"></td>
                    <td><input type="submit" name="update[<?php echo $row['id_organisasi']; ?>]" value="Update"></td>
                </tr>
                <?php endforeach; ?>
            </table>
        </form>
    </div>
</body>
</html>

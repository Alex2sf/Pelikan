<?php
session_start();
if (!isset($_SESSION['id_akun'])) {
    header("Location: login.php");
    exit();
}

$username = "";
$username1 = $_SESSION["role"];
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Export Table to Excel</title>
    <script type="text/javascript" src="../js/bootstrap.js"></script>
    <script type="text/javascript" src="../js/bootstrap.min.js"></script>
    <link href="../css/bootstrap.min.css" type="text/css" rel="stylesheet">
    <link href="pelikan.css" type="text/css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <style>
        table {
            width: 100%;
            border-collapse: collapse;
            font-family: Arial, sans-serif;
            font-size: 12px;
        }
        th, td {
            border: 1px solid black;
            padding: 8px;
            text-align: left;
        }
        th {
            background-color: #003366;
            color: white;
        }
        .section-header {
            background-color: #FF9900;
            font-weight: bold;
        }
        .sub-section-header {
            background-color: #FF9900;
            font-weight: bold;
        }
        .center {
            text-align: center;
        }
        .highlight {
            background-color: #FF9900;
        }
        .sub-header {
            background-color: yellow;
            color: black;
            text-align: center;
        }
    </style>
    <script>
        function downloadTableAsExcel() {
            var table = document.getElementById("kuesionerTable"); // Get the table element
            var html = table.outerHTML;
            var blob = new Blob([html], {type: "application/vnd.ms-excel"}); // Create a Blob for Excel
            var link = document.createElement("a");
            link.href = URL.createObjectURL(blob);
            link.download = "kuesioner_data.xls"; // Set file name
            document.body.appendChild(link);
            link.click();
            document.body.removeChild(link);
        }
    </script>
</head>
<body>
    <!--Navigasi Bar-->
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
                        <a class="nav-link black" aria-current="page" href="index.php">Beranda</a>
                    </li>
                    <li class="nav-item px-2">
                        <a class="nav-link black" href="peringkat.php">Peringkat</a>
                    </li>
                    <li class="nav-item px-2">
                        <a class="nav-link active" href="kuesioner.php">Kuesioner</a>
                    </li>
                    <li class="nav-item px-2">
                        <a class="nav-link black" href="alur.php">Alur</a>
                    </li>
                    <?php
                    if ($username == $username1) {
                        echo '<li class="nav-item">
                        <a class="nav-link black" href="login.php">Login</a>
                        </li>';
                    } else {
                        echo '<li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle black" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                            Profile
                        </a>
                        <ul class="dropdown-menu">
                            <li><a class="dropdown-item" href="profile.php">My Profile</a></li>
                            <li><a class="dropdown-item" href="logout.php">Logout</a></li>
                        </ul>
                        </li>';
                    }
                    ?>
                </ul>
            </div>
        </div>
    </nav> 

    <!--Table Kuesioner-->
    <div class="container text-center" style="padding-top:90px;">
        <div class="row">
            <button class="btn btn-success mb-4" onclick="downloadTableAsExcel()">Download as Excel</button>
            <table id="kuesionerTable">
                <thead>
                    <tr>
                        <th class="center" colspan="6">INFORMASI WAJIB BERKALA</th>
                    </tr>
                    <tr>
                        <th rowspan="2" class="sub-header">Informasi Terkait Tugas dan Fungsi Satuan Unit Organisasi Eselon I dan UPT</th>
                        <th colspan="2" class="sub-header">Tersedia</th>
                        <th rowspan="2" class="sub-header">Bukti Pelaksanaan</th>
                        <th rowspan="2" class="sub-header">Link Dokumen</th>
                        <th rowspan="2" class="sub-header">Nilai</th>
                    </tr>
                    <tr>
                        <th class="sub-header">Ya</th>
                        <th class="sub-header">Tidak</th>
                    </tr>
                </thead>
                <tbody>
                    <tr class="section-header">
                        <td colspan="6">A. Informasi Terkait Tugas dan Fungsi Satuan Unit Organisasi Eselon I dan UPT</td>
                    </tr>
                    <tr>
                        <td>1. Informasi tentang profil unit organisasi</td>
                        <td class="center">✓</td>
                        <td></td>
                        <td>Alamat website atau Laporan kinerja organisasi Eselon I/UPT</td>
                        <td>Link ke Profil UPT</td>
                        <td class="center">1.5</td>
                    </tr>
                    <tr>
                        <td>2. Rincian tugas dan fungsi Kementerian / Lembaga serta Laporan Kinerja Kementerian dan Lembaga</td>
                        <td class="center">✓</td>
                        <td></td>
                        <td>Laporan Kinerja Kementerian/ Lembaga dan UPT di bawahnya</td>
                        <td>Link ke dokumen terkait LKj Eselon I</td>
                        <td class="center">1.5</td>
                    </tr>
                    <tr>
                            <td>3. Struktur organisasi Eselon I dan UPT</td>
                            <td class="center">✓</td>
                            <td></td>
                            <td>Struktur organisasi di website Eselon I/UPT</td>
                            <td>Link struktur terkait</td>
                            <td class="center">1.5</td>
                        </tr>
                        <tr class="section-header">
                            <td colspan="6">B. Informasi Terkait Program dan Kegiatan yang sedang dijalankan</td>
                        </tr>
                        <tr>
                            <td>1. Program-program yang sedang dijalankan dalam Tahun 2023 serta rincian anggaran</td>
                            <td></td>
                            <td class="center">✓</td>
                            <td>Bukti tidak tersedia</td>
                            <td>Tidak ada link yang tersedia</td>
                            <td class="center">1</td>
                        </tr>
                        <tr class="highlight">
                            <td>2. Laporan pelaksanaan Program-program Tahun 2023 serta rincian anggaran</td>
                            <td></td>
                            <td class="center">✓</td>
                            <td>Alokasi tidak tersedia</td>
                            <td>Tidak tersedia</td>
                            <td class="center">1.5</td>
                        </tr>
                    <!-- Add more rows as needed -->
                </tbody>
            </table>
        </div>
    </div>
</body>
</html>

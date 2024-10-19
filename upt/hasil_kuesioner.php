<?php
session_start();
include '../koneksi.php';

if (!isset($_SESSION['id_akun'])) {
    header("Location: ../index.php");
    exit;
}
date_default_timezone_set('Asia/Jakarta');
ob_start();

$username="";
$username1=$_SESSION["role"];
$id_akun = $_SESSION['id_akun'];
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
                outline: black; /* Menghilangkan outline fokus */
                margin: 20px;
                padding: 50px;
                overflow-x: hidden;
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
        </style>
    </head>
    <body>
    <?php include 'navbar.php'; ?>

<?php
// Bagian kode PHP untuk menampilkan hasil kuesioner dimulai dari sini

// Ambil id_organisasi dari akun yang login
$sql = "SELECT id_organisasi FROM organisasi WHERE id_akun = '$id_akun'";
$result = $conn->query($sql);

if ($result->num_rows > 0) {
    $row = $result->fetch_assoc();
    $id_organisasi = $row['id_organisasi'];

    // Query untuk mengambil hasil kuesioner berdasarkan id_organisasi
    $sql = "SELECT k.id_kuesioner, p.pertanyaan, p.bobot, k.jawaban, k.link, k.dokumen, k.nilai, k.catatan, k.verifikasi, o.nama_organisasi,
               cat.id_kategori, cat.kategori, sub1.subkategori1, sub2.subkategori2, sub3.subkategori3
            FROM kuesioner k
            JOIN pertanyaan p ON k.id_pertanyaan = p.id_pertanyaan
            JOIN organisasi o ON k.id_organisasi = o.id_organisasi
            LEFT JOIN kategori cat ON p.id_kategori = cat.id_kategori 
            LEFT JOIN subkategori1 sub1 ON p.id_subkategori1 = sub1.id_subkategori1
            LEFT JOIN subkategori2 sub2 ON p.id_subkategori2 = sub2.id_subkategori2
            LEFT JOIN subkategori3 sub3 ON p.id_subkategori3 = sub3.id_subkategori3
            WHERE k.id_organisasi = '$id_organisasi'";

    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        $last_kategori = '';
        $last_subkategori1 = '';
        $last_subkategori2 = '';
        $last_subkategori3 = '';

        while ($row = $result->fetch_assoc()) {
            // Check if the kategori has changed
            if ($last_kategori != $row['kategori']) {
                if ($last_kategori != '') {
                    echo "</tbody></table><br>"; // Close previous table if exists
                }
                echo "<h2>{$row['kategori']}</h2>"; // Display the new kategori
                $last_kategori = $row['kategori'];
            }

            // Check if SubKategori1 has changed
            if ($last_subkategori1 != $row['subkategori1']) {
                if ($last_subkategori1 != '') {
                    echo "</tbody></table><br>"; // Close previous table if exists
                }
                echo "<table border='1' style='border-collapse: collapse; width: 100%; margin-bottom: 10px;'>
                        <thead>
                            <tr style='background-color: #1E90FF; color: black;'>
                                <th style='padding: 10px; width: 60%;'>{$row['subkategori1']}</th>
                            </tr>
                        </thead>
                        <tbody>";
                $last_subkategori1 = $row['subkategori1'];
                $last_subkategori2 = ''; // Reset SubKategori2
                $last_subkategori3 = ''; // Reset SubKategori3
            }

            // Check if SubKategori2 has changed
            if ($last_subkategori2 != $row['subkategori2']) {
                if ($last_subkategori2 != '') {
                    echo "</tbody></table><br>"; // Close previous table if exists
                }
                echo "<table border='1' style='border-collapse: collapse; width: 100%; margin-bottom: 10px;'>
                        <thead>
                            <tr style='background-color: #00008B; color: white;'>
                                <th>{$row['subkategori2']}</th>
                            </tr>
                        </thead>
                        <tbody>";
                $last_subkategori2 = $row['subkategori2'];
                $last_subkategori3 = ''; // Reset SubKategori3
            }

            // Check if SubKategori3 has changed
            if ($last_subkategori3 != $row['subkategori3']) {
                if ($last_subkategori3 != '') {
                    echo "</tbody></table><br>"; // Close previous table if exists
                }
                echo "<table border='1' style='border-collapse: collapse; width: 100%; margin-bottom: 10px;'>
                        <thead>
                            <tr style='background-color: #FFA500; color: black;'>
                                <th style='padding: 10px; width: 60%;'>{$row['subkategori3']}</th>
                                <th style='padding: 10px; width: 10%;'>Bobot</th>
                                <th style='padding: 10px; width: 10%;'>Jawaban</th>
                                <th style='padding: 10px; width: 10%;'>Link</th>
                                <th style='padding: 10px; width: 10%;'>Dokumen</th>
                                <th style='padding: 10px; width: 10%;'>Nilai</th>
                                <th style='padding: 10px; width: 10%;'>Catatan</th>
                                <th style='padding: 10px; width: 10%;'>Verifikasi</th>
                            </tr>
                        </thead>
                        <tbody>";
                $last_subkategori3 = $row['subkategori3'];
            }

            // Output the data rows within the current subkategori
            echo "<tr>
                    <td>{$row['pertanyaan']}</td>
                    <td>{$row['bobot']}</td>
                    <td>{$row['jawaban']}</td>
                    <td>{$row['link']}</td>
                    <td>";
                    
                    if (!empty($row['dokumen'])) {
                        // Tampilkan link untuk review
                        echo "<a href='../upt/{$row['dokumen']}' target='_blank'>Review</a> | ";
                        
                        // Tampilkan link untuk download
                        echo "<a href='../upt/{$row['dokumen']}' download>Download</a>";
                    } else {
                        echo "Tidak ada dokumen";
                    }

            echo "</td><td>{$row['nilai']}</td>
                    <td>{$row['catatan']}</td>
                    <td>{$row['verifikasi']}</td>
                  </tr>";
        }

        echo "</tbody></table>"; // Close the last table
    } else {
        echo "<script>
        alert('Belum ada hasil kuesioner.');
        window.location.href='index.php';
    </script>";    }
} else {
    echo "<script>
    alert('Organisasi tidak ditemukan.');
    window.location.href='index.php';
</script>"; 
}
?>
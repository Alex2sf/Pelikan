<?php
error_reporting(0); // Menonaktifkan semua jenis error dan warning

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
$id_organisasi = $_SESSION['id_organisasi'];
// Cek apakah pengguna sudah mengisi kuesioner
$sql_check = "SELECT * FROM kuesioner WHERE id_organisasi = ?";
$stmt_check = $conn->prepare($sql_check);
$stmt_check->bind_param("i", $id_organisasi);
$stmt_check->execute();
$result_check = $stmt_check->get_result();

$alreadyFilled = $result_check->num_rows > 0; // TRUE jika sudah pernah mengisi, FALSE sebaliknya


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
                user-select: ;
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

  
        
        <!-- Kuesioner -->
        <?php

        // Fetch data for display
        $sql = "SELECT P.id_pertanyaan, P.pertanyaan, K.kategori, SK1.subkategori1, SK2.subkategori2, SK3.subkategori3, P.bobot, P.web 
                FROM pertanyaan P 
                JOIN kategori K ON P.id_kategori = K.id_kategori
                JOIN subkategori1 SK1 ON P.id_subkategori1 = SK1.id_subkategori1
                JOIN subkategori2 SK2 ON P.id_subkategori2 = SK2.id_subkategori2
                JOIN subkategori3 SK3 ON P.id_subkategori3 = SK3.id_subkategori3
                ORDER BY SK1.id_subkategori1, SK2.id_subkategori2, SK3.id_subkategori3";

        $result = $conn->query($sql);
        
          $sqlJawaban = "SELECT * FROM kuesioner WHERE id_organisasi = $id_organisasi";
                $resultJawaban = $conn->query($sqlJawaban);

        if ($result->num_rows > 0) {
            echo "<form action='submit_kuesioner.php' method='post' enctype='multipart/form-data'>"; // Start the form
            $last_kategori = '';

            $last_subkategori1 = '';
            $last_subkategori2 = '';
            $last_subkategori3 = '';
            echo "<h3 style='color: red; text-align: center;'> Note : Link dan Dokumen wajib diisi jika memilih jawaban Ya.</h3>";
            $jawabanArray = array();
            while ($jawabanRow = $resultJawaban->fetch_assoc()) {
                $jawabanArray[$jawabanRow['id_pertanyaan']] = $jawabanRow;
            }
            
            // Output data every row
            while ($row = $result->fetch_assoc()) {
                // If subkategori1 changes, create a new header
                if ($last_kategori != $row['kategori']) {
                    if ($last_kategori != '') {
                        echo "</tbody></table><br>"; // Close previous table if any
                    }
                    echo "<table border='1' style='border-collapse: collapse; width: 100%; margin-bottom: 10px;' >
                            <thead>
                                <tr style= 'background-color: #1e90ff; color: white;'>
                                    <th style='padding: 10px; text-align: center; width: 60%;'>{$row['kategori']}</th>
                                </tr>
                            </thead>
                            <tbody>";
                            $last_kategori = $row['kategori'];

                    $last_subkategori1 = '';
                    $last_subkategori2 = ''; // Reset SubKategori2
                    $last_subkategori3 = ''; // Reset SubKategori3
                }
                if ($last_subkategori1 != $row['subkategori1']) {
                    if ($last_subkategori1 != '') {
                        echo "</tbody></table><br>"; // Close previous table if any
                    }
                    echo "<table border='1' style='border-collapse: collapse; width: 100%; margin-bottom: 10px;' >
                            <thead>
                                <tr style='background-color: #01008a; color: white;'>
                                    <th style='padding: 10px; text-align: center; width: 60%;'>{$row['subkategori1']}</th>
                                </tr>
                            </thead>
                            <tbody>";
                    $last_subkategori1 = $row['subkategori1'];
                    $last_subkategori2 = ''; // Reset SubKategori2
                    $last_subkategori3 = ''; // Reset SubKategori3
                }

                // If SubKategori2 changes, create a new header
                if ($last_subkategori2 != $row['subkategori2']) {
                    if ($last_subkategori2 != '') {
                        echo "</tbody></table><br>"; // Close previous table if any
                    }
                    echo "<table border='1' style='border-collapse: collapse; width: 100%; margin-bottom: 10px;' >
                            <thead>
                                <tr style='background-color: #066d1d; color: white;'>
                                    <th style='padding: 10px; text-align: center; width: 60%;'>{$row['subkategori2']}</th>
                                </tr>
                            </thead>
                            <tbody>";
                    $last_subkategori2 = $row['subkategori2'];
                    $last_subkategori3 = ''; // Reset SubKategori3
                }


                // If SubKategori3 changes, create a new header
                if ($last_subkategori3 != $row['subkategori3']) {
                    if ($last_subkategori3 != '') {
                        echo "</tbody></table><br>"; // Close previous table if any
                    }
                    echo "<table border='1' style='border-collapse: collapse; width: 100%; margin-bottom: 10px;' >
                            <thead>
                                <tr style='background-color: #f9780a; color: white;'>
                                    <th style='padding: 10px; text-align: center; width: 40%;'>{$row['subkategori3']}</th>
                                    <th style='padding: 10px; text-align: center; width: 10%;'>Bobot</th>
                                    <th style='padding: 10px; text-align: center; width: 30%;'>Bukti Pelaksanaan</th>
                                    <th style='padding: 10px; text-align: center; width: 10%;'>Jawaban</th>
                                    <th style='padding: 10px; text-align: center; width: 10%;'>Link</th>
                                    <th style='padding: 10px; text-align: center; width: 10%;'>Dokumen</th>
                                </tr>
                            </thead>
                            <tbody>";
                    $last_subkategori3 = $row['subkategori3'];
                }

                $jawaban = isset($jawabanArray[$row['id_pertanyaan']]) ? $jawabanArray[$row['id_pertanyaan']] : null;

                echo "<tr>
            <td style='padding: 8px; text-align: justify; border-bottom: 1px solid #ddd;'>{$row['pertanyaan']}</td>
            <td style='padding: 8px; text-align: center; border-bottom: 1px solid #ddd;'>{$row['bobot']}</td>
            <td style='padding: 8px; text-align: justify; border-bottom: 1px solid #ddd;'>{$row['web']}</td>";

    if (!is_null($row['bobot'])) {
        echo "<td style='padding: 8px; border-bottom: 1px solid #ddd;'>
                <label style='margin-right: 15px;'>
                    <input type='radio' name='jawaban[{$row['id_pertanyaan']}]' value='Ya' " . ($jawaban && $jawaban['jawaban'] === 'Ya' ? 'checked="true"' : '') . "> Ya
                </label>
                <label>
                    <input type='radio' name='jawaban[{$row['id_pertanyaan']}]' value='Tidak' " . ($jawaban && $jawaban['jawaban'] === 'Tidak' ? 'checked="true"' : '') . "> Tidak
                </label>
              </td>";

        echo "<td style='padding: 8px; border-bottom: 1px solid #ddd;'>
                <input type='text' name='link[{$row['id_pertanyaan']}]' placeholder='Masukkan link' value='" . ($jawaban ? $jawaban['link'] : '') . "'>
              </td>";

        echo "<td style='padding: 8px; border-bottom: 1px solid #ddd;'>
                <input type='file' class='upload-box file-input' name='dokumen[{$row['id_pertanyaan']}]' accept='application/pdf'>";
        
        if ($jawaban && !empty($jawaban['dokumen'])) {
            echo "<br><a href='../upt/{$jawaban['dokumen']}' target='_blank'>Lihat Dokumen</a>";
        }


        } else {
            echo "<td colspan='3' style='padding: 8px; text-align: center; border-bottom: 1px solid #ddd;'>Tidak ada isian diperlukan</td>";
        }
    }
    
    

    echo "</tbody></table><br>";
    echo "<input type='submit' name='submit_type' value='Kirim' style='padding: 10px 20px; background-color: #007BFF; color: white; border: none; border-radius: 5px; width: 100%;' onclick='return validateForm();'>";
                echo "<input type='submit' name='submit_type' value='Simpan' style='padding: 10px 20px; background-color: #28A745; color: white; border: none; border-radius: 5px; width: 100%; margin-top: 10px;' onclick='return validateForm();'>";        
                
                echo "</form>";
        } else {
            echo "0 hasil ditemukan";
        }
        echo "<script>
        // Fungsi untuk memvalidasi ukuran file
        function validateFileSize(input) {
            const maxFileSize = 10 * 1024 * 1024; // 10MB dalam byte
            const file = input.files[0];
    
            if (file && file.size > maxFileSize) {
                alert('File yang Anda unggah melebihi batas ukuran 10MB. Silakan unggah file yang lebih kecil.');
                input.value = ''; // Reset input file jika ukuran melebihi batas
            }
        }
    
        // Fungsi untuk mengecek apakah jawaban telah dipilih
        function checkAnswerSelected(input) {
            const row = input.closest('tr'); // Ambil baris terkait
            const radios = row.querySelectorAll('input[type=\"radio\"]'); // Dapatkan semua radio button di baris
            let isAnswered = false;
    
            // Cek apakah ada jawaban yang dipilih
            radios.forEach(function(radio) {
                if (radio.checked) {
                    isAnswered = true;
                }
            });
    
            return isAnswered;
        }
    
        // Tambahkan event listener ke setiap input file dan input link
        document.addEventListener('DOMContentLoaded', function () {
            const fileInputs = document.querySelectorAll('.upload-box');
            const linkInputs = document.querySelectorAll('.link-input');
    
            // Untuk setiap input file, cek apakah jawaban sudah dipilih sebelum unggah file
            fileInputs.forEach(function(input) {
                input.addEventListener('click', function(e) {
                    if (!checkAnswerSelected(input)) {
                        alert('Silakan pilih jawaban Ya atau Tidak terlebih dahulu.');
                        e.preventDefault(); // Mencegah interaksi lebih lanjut
                        input.blur(); // Keluarkan fokus dari input
                    }
                });
    
                // Validasi ukuran file
                input.addEventListener('change', function() {
                    validateFileSize(this);
                });
            });
    
            // Untuk setiap input link, cek apakah jawaban sudah dipilih sebelum mengisi link
            linkInputs.forEach(function(input) {
                input.addEventListener('click', function(e) {
                    if (!checkAnswerSelected(input)) {
                        alert('Silakan pilih jawaban Ya atau Tidak terlebih dahulu.');
                        e.preventDefault(); // Mencegah interaksi lebih lanjut
                        input.blur(); // Keluarkan fokus dari input
                    }
                });
            });
        });
    
        // Validasi form sebelum submit
        document.getElementById('kuesionerForm').addEventListener('submit', function (event) {
            const fileInputs = document.querySelectorAll('.upload-box');
            const maxFileSize = 10 * 1024 * 1024; // 10MB dalam byte
    
            for (const input of fileInputs) {
                if (input.files.length > 0 && input.files[0].size > maxFileSize) {
                    alert('File yang Anda unggah melebihi batas ukuran 10MB. Silakan unggah file yang lebih kecil.');
                    event.preventDefault(); // Mencegah pengiriman form
                    return false;
                }
            }
        });
    
        function toggleInputs(radio) {
            // Dapatkan elemen input file dan link terkait
            const row = radio.closest('tr');
            const linkInput = row.querySelector('.link-input');
            const fileInput = row.querySelector('.file-input');
    
            // Jika 'Tidak' dipilih, nonaktifkan input link dan file
            if (radio.value === 'Tidak') {
                linkInput.disabled = true; // Nonaktifkan input link
                linkInput.value = ''; // Reset nilai input link
                fileInput.disabled = true; // Nonaktifkan input file
                fileInput.value = ''; // Reset nilai input file
            } else {
                linkInput.disabled = false; // Aktifkan input link
                fileInput.disabled = false; // Aktifkan input file
            }
        }
    </script>";
    
    
    
        $conn->close();
        ?>
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
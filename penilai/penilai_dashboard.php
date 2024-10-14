<?php
session_start();
require 'session_timeout.php';

if (!isset($_SESSION['id_akun']) || $_SESSION['role'] != 'penilai') {
    header("Location: ../index.php");
    exit();
}

include '../koneksi.php';


$id_akun = $_SESSION['id_akun'];

// Ambil id_penilai
$stmt = $conn->prepare("SELECT id_penilai FROM profile_penilai WHERE id_akun = ?");
$stmt->bind_param('i', $id_akun);
$stmt->execute();
$result = $stmt->get_result();
$row = $result->fetch_assoc();
$id_penilai = $row['id_penilai'];

// Ambil id_organisasi dari parameter
$id_organisasi = isset($_GET['id_organisasi']) ? (int)$_GET['id_organisasi'] : 0;

// Validasi id_organisasi
if ($id_organisasi <= 0) {
    die("ID Organisasi tidak valid.");
}

$sql = "SELECT k.id_kuesioner, p.pertanyaan, p.bobot, k.jawaban, k.link, k.dokumen, k.nilai, p.A, p.B, p.C, p.D, p.E, k.catatan, k.verifikasi, o.nama_organisasi,
               cat.id_kategori, cat.kategori, sub1.subkategori1, sub2.subkategori2, sub3.subkategori3
        FROM kuesioner k
        JOIN pertanyaan p ON k.id_pertanyaan = p.id_pertanyaan
        JOIN organisasi o ON k.id_organisasi = o.id_organisasi
        LEFT JOIN kategori cat ON p.id_kategori = cat.id_kategori 
        LEFT JOIN subkategori1 sub1 ON p.id_subkategori1 = sub1.id_subkategori1
        LEFT JOIN subkategori2 sub2 ON p.id_subkategori2 = sub2.id_subkategori2
        LEFT JOIN subkategori3 sub3 ON p.id_subkategori3 = sub3.id_subkategori3
        WHERE k.id_organisasi = ? AND k.id_penilai = ?
        ORDER BY 
               cat.id_kategori ASC,    -- Urutkan berdasarkan ID kategori dari kecil ke besar
               sub1.subkategori1 ASC,  
               sub2.subkategori2 ASC,  
               sub3.subkategori3 ASC,  
               k.verifikasi DESC,      
               k.id_kuesioner ASC";    
 

$stmt = $conn->prepare($sql);
$stmt->bind_param('ii', $id_organisasi, $id_penilai);
$stmt->execute();
$result = $stmt->get_result();
$uploads_base_url = "http://localhost/Pelikan/upt/uploads/"; // URL untuk file uploads

// Inisialisasi variabel untuk kategori dan subkategori
$last_kategori = '';
$last_subkategori1 = '';
$last_subkategori2 = '';
$last_subkategori3 = '';

// Proses update data kuesioner
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    foreach ($_POST['update'] as $id_kuesioner => $update) {
        $nilai = $_POST['nilai'][$id_kuesioner] ?? NULL;
        $catatan = $_POST['catatan'][$id_kuesioner] ?? NULL;
        $verifikasi = isset($_POST['verifikasi'][$id_kuesioner]) ? 1 : 0;

        $stmt = $conn->prepare("UPDATE kuesioner SET nilai = ?, catatan = ?, verifikasi = ? WHERE id_kuesioner = ? AND id_penilai = ?");
        $stmt->bind_param('ssiii', $nilai, $catatan, $verifikasi, $id_kuesioner, $id_penilai);
        if (!$stmt->execute()) {
            echo "Error: " . $stmt->error;
        }
    }
    // Refresh the page to avoid form resubmission
    header("Location: " . $_SERVER['PHP_SELF'] . "?id_organisasi=" . $id_organisasi);
    exit();
}
// Query untuk menghitung total nilai per kategori
$totalNilaiQuery = "SELECT k.id_kategori, SUM(k.nilai) AS total_nilai, cat.kategori
                     FROM kuesioner k
                     JOIN kategori cat ON k.id_kategori = cat.id_kategori
                     WHERE k.id_penilai = ? AND k.verifikasi = 1
                     GROUP BY k.id_kategori";

// Mempersiapkan statement
$stmtTotalNilai = $conn->prepare($totalNilaiQuery);
$stmtTotalNilai->bind_param('i', $id_penilai);
$stmtTotalNilai->execute();
$resultTotalNilai = $stmtTotalNilai->get_result();
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <script type="text/javascript" src="../js/bootstrap.js"></script>
        <script type="text/javascript" src="../js/bootstrap.min.js"></script>
        <link href="../css/bootstrap.min.css" type="text/css" rel="stylesheet">
        <link href="pelikan.css" type="text/css" rel="stylesheet">
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <title>Dashboard Penilai</title>
    <style>
      body {
    font-family: Arial, sans-serif;
    margin: 0;
    padding: 0;
}
header {
    background-color: #f4f4f4;
    padding: 15px;
    text-align: right;
    color: black;
    border-bottom: 5px solid #4834c4;

}
.logo {
    margin-right: auto; /* Memastikan logo tetap di sisi kiri, sementara menu di sebelah kanan */
  }
  .logo img {
    margin-right: 10px; /* Memberi jarak antara gambar dan teks */
  }
  .pelikan {
            font-family: 'Arial', sans-serif;
            font-size: 35px ;
            color: #3498db;
            text-transform: uppercase;
            letter-spacing: 2px;
            position: relative;
            display: inline-block;
            transition: all 0.3s ease;
        }
        .bg-blue-dark {
            background-color: #4535C1; /* Warna biru gelap */
        }
        .navbar a:hover {
            text-decoration: underline;
        }
        .navbar a {
                margin: 0 10px;
            }   

.container {
    padding: 20px;
}

/* Style tabel yang lebih rapi */
table {
    width: 100%;
    border-collapse: collapse;
    margin-bottom: 20px;
    font-size: 14px;
}

th, td {
    border: 1px solid #ddd;
    padding: 12px 15px;
    text-align: left;
}

h2 {
    padding-top: 60px;
    text-align: center;
    font-size: 28px; /* Membuat ukuran font lebih besar */
    font-weight: bold; /* Membuat teks lebih tegas */
    letter-spacing: 2px; /* Menambahkan spasi antar huruf */
    color: #333; /* Menggunakan warna teks yang lebih tegas */
    text-transform: uppercase; /* Membuat teks dalam huruf kapital */
    border-bottom: 2px solid #ddd; /* Menambahkan garis bawah untuk kesan visual */
    padding-bottom: 10px; /* Memberikan jarak di bawah teks */
}


tr:nth-child(even) {
    background-color: #f9f9f9;
}

tr:hover {
    background-color: #f1f1f1;
    cursor: pointer;
}

/* Style untuk tombol */
.button {
    width: 100%; /* Membuat tombol penuh sesuai container-nya */
    padding: 12px 20px; /* Menambahkan padding untuk kenyamanan klik */
    background-color: #007BFF; /* Warna biru */
    color: white; /* Warna teks putih */
    border: none; /* Menghilangkan border */
    border-radius: 5px; /* Membuat ujung tombol sedikit melengkung */
    font-size: 16px; /* Ukuran teks di dalam tombol */
    font-weight: bold; /* Membuat teks tombol tegas */
    cursor: pointer; /* Menambahkan efek pointer pada tombol */
    text-align: center; /* Memastikan teks di dalam tombol berada di tengah */
}

.button:hover {
    background-color: #0056b3; /* Warna biru lebih gelap ketika di-hover */
}
input[type='text']:focus {
    border-color: #007BFF; /* Mengubah warna border saat fokus */
    outline: none; /* Menghilangkan outline bawaan */
}

input[type='text']::placeholder {
    color: #888; /* Warna placeholder abu-abu */
    font-style: italic; /* Mengubah gaya teks menjadi miring */
}

/* Desain untuk textarea */
textarea {
    width: 150px;
    padding: 10px;
    border: 2px solid #ddd;
    border-radius: 5px;
    font-size: 14px;
    resize: vertical; /* Membatasi perubahan ukuran hanya vertikal */
    transition: border-color 0.3s ease;
}

/* Form styling */
.form-group {
    margin-bottom: 15px;
}

.form-group label {
    display: block;
    margin-bottom: 5px;
}

.form-group input, .form-group textarea {
    width: 100%;
    padding: 10px;
    border: 1px solid #ccc;
    border-radius: 4px;
    box-sizing: border-box;
}

textarea {
    resize: vertical;
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
                            <a class="nav-link black" href="list_organisasi.php">Daftar Organisasi</a>
                        </li>
                       
                       
                    </ul>
                </div>
            </div>
        </nav>

<br>

    <h2>Dashboard Penilai</h2>

    <div class="container">
    <form action="penilai_dashboard.php?id_organisasi=<?php echo $id_organisasi; ?>" method="POST">
        <?php
        // Loop melalui hasil query
        while ($row = $result->fetch_assoc()) {
            $dokumen = $row['dokumen']; // Nama file dokumen dari database

            // Jika kategori berubah, tutup tabel sebelumnya
            if ($last_kategori != $row['kategori']) {
                if ($last_kategori != '') {
                    echo "</tbody></table><br>"; // Tutup tabel sebelumnya jika ada
                }
                echo "<h2>{$row['kategori']}</h2>"; // Tampilkan kategori
                $last_kategori = $row['kategori'];
            }

            // Jika SubKategori1 berubah, tutup tabel sebelumnya
            if ($last_subkategori1 != $row['subkategori1']) {
                if ($last_subkategori1 != '') {
                    echo "</tbody></table><br>"; // Tutup tabel sebelumnya jika ada
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

            // Jika SubKategori2 berubah, tutup tabel sebelumnya
            if ($last_subkategori2 != $row['subkategori2']) {
                if ($last_subkategori2 != '') {
                    echo "</tbody></table><br>"; // Tutup tabel sebelumnya jika ada
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

            // Jika SubKategori3 berubah, tutup tabel sebelumnya
            if ($last_subkategori3 != $row['subkategori3']) {
                if ($last_subkategori3 != '') {
                    echo "</tbody></table><br>"; // Tutup tabel sebelumnya jika ada
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

// Tampilkan baris data pertanyaan
echo "<tr>
        <td>{$row['pertanyaan']}</td>
        <td>{$row['bobot']}</td>
        <td>{$row['jawaban']}</td>
        <td><a href='{$row['link']}' target='_blank'>{$row['link']}</a></td>
        <td>";
if (!empty($row['dokumen'])) {
    echo "<a href='../upt/{$row['dokumen']}' target='_blank'>Review Dokumen</a>";
} else {
    echo "Tidak ada dokumen";
}
echo "</td>";

// Cek jika jawaban bukan "Tidak", tampilkan dropdown nilai
if (strtolower($row['jawaban']) != 'tidak') {
    echo "<td>
            <select name='nilai[{$row['id_kuesioner']}]'>
                <option value=''>Pilih Nilai</option>"; // Opsi kosong/default

    // Menampilkan hanya kolom yang tidak NULL dan memiliki nilai
    if (!is_null($row['A'])) {
        echo "<option value='{$row['A']}'>A: {$row['A']}</option>";
    }
    if (!is_null($row['B'])) {
        echo "<option value='{$row['B']}'>B: {$row['B']}</option>";
    }
    if (!is_null($row['C'])) {
        echo "<option value='{$row['C']}'>C: {$row['C']}</option>";
    }
    if (!is_null($row['D'])) {
        echo "<option value='{$row['D']}'>D: {$row['D']}</option>";
    }
    if (!is_null($row['E'])) {
        echo "<option value='{$row['E']}'>E: {$row['E']}</option>";
    }
    echo "</select>
        </td>";
} else {
    // Jika jawaban "Tidak", beri pesan bahwa nilai tidak bisa dipilih
    echo "<td>Tidak dapat mengisi Nilai</td>";
}

// Kolom catatan dan verifikasi
echo "<td><textarea name='catatan[{$row['id_kuesioner']}]' placeholder='Catatan'></textarea></td>";
echo "<td><label><input type='checkbox' name='verifikasi[{$row['id_kuesioner']}]' value='1'> Verifikasi</label></td>";
echo "<td><input type='hidden' name='update[{$row['id_kuesioner']}]' value='1'></td>";
echo "</tr>";

        }

        // Tutup tabel terakhir
        if ($last_subkategori3 != '') {
            echo "</tbody></table><br>";
        }
        while ($rowTotal = $resultTotalNilai->fetch_assoc()) {
            $kategoriId = $rowTotal['id_kategori'];
            $totalNilai = $rowTotal['total_nilai'];
            $kategoriNama = $rowTotal['kategori'];
            
            // Menampilkan hasil total nilai per kategori
        
            // Query untuk mengupdate nilai kategori di tabel organisasi
            $updateNilaiQuery = "";
        
            // Menentukan kolom nilai berdasarkan id_kategori
            switch ($kategoriId) {
                case 1:
                    $updateNilaiQuery = "UPDATE organisasi SET nilai_kategori1 = ? WHERE id_penilai = ?";
                    break;
                case 2:
                    $updateNilaiQuery = "UPDATE organisasi SET nilai_kategori2 = ? WHERE id_penilai = ?";
                    break;
                case 3:
                    $updateNilaiQuery = "UPDATE organisasi SET nilai_kategori3 = ? WHERE id_penilai = ?";
                    break;
                case 4:
                    $updateNilaiQuery = "UPDATE organisasi SET nilai_kategori4 = ? WHERE id_penilai = ?";
                    break;
                case 5:
                    $updateNilaiQuery = "UPDATE organisasi SET nilai_kategori5 = ? WHERE id_penilai = ?";
                    break;
                    case 6:
                        $updateNilaiQuery = "UPDATE organisasi SET nilai_kategori6 = ? WHERE id_penilai = ?";
                        break;
                default:
                    // Jika tidak ada kategori yang sesuai
                    echo "Kategori tidak ditemukan!";
                    break;
            }
        
            // Pastikan bahwa query update tidak kosong
            if (!empty($updateNilaiQuery)) {
                // Mempersiapkan statement untuk update
                $stmtUpdateNilai = $conn->prepare($updateNilaiQuery);
                
                // Bind parameter, nilai dan id_penilai
                $stmtUpdateNilai->bind_param('di', $totalNilai, $id_penilai);
                
                // Menjalankan query update
                if ($stmtUpdateNilai->execute()) {
                } else {
                }
                
                // Menutup statement
                $stmtUpdateNilai->close();
            }
        }
        
        // Menutup statement total nilai
        $stmtTotalNilai->close();

        
        ?>


        
<button type="submit" class="button" id="submitBtn">Simpan Perubahan</button>
</form>

<script>
    document.getElementById('submitBtn').addEventListener('click', function(event) {
        let isValid = true;
        let errorMessage = '';

        // Ambil semua input nilai, catatan, dan verifikasi
        const nilaiInputs = document.querySelectorAll("input[name^='nilai']");
        const catatanInputs = document.querySelectorAll("textarea[name^='catatan']");
        const verifikasiInputs = document.querySelectorAll("input[type='checkbox'][name^='verifikasi']");

        // Validasi setiap field
        nilaiInputs.forEach((input, index) => {
            if (!input.value.trim()) {
                isValid = false;
                errorMessage = 'Semua field Nilai harus diisi!';
            }
        });

        catatanInputs.forEach((textarea) => {
            if (!textarea.value.trim()) {
                isValid = false;
                errorMessage = 'Semua field Catatan harus diisi!';
            }
        });

        verifikasiInputs.forEach((checkbox) => {
            if (!checkbox.checked) {
                isValid = false;
                errorMessage = 'Semua Verifikasi harus dicentang!';
            }
        });

        // Jika tidak valid, cegah form submit
        if (!isValid) {
            event.preventDefault();
            alert(errorMessage);
        }
    });
</script>

        </div>
    </body>
    </html>

<?php
$conn->close();
?>
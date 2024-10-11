<?php
session_start();
if (!isset($_SESSION['id_akun']) || $_SESSION['role'] != 'penilai') {
    header("Location: login_penilai.php");
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

// Ambil kuesioner yang perlu diisi dengan kategori dan subkategori
$sql = "SELECT k.id_kuesioner, p.pertanyaan, p.bobot, k.jawaban, k.link, k.dokumen, k.nilai, k.catatan, k.verifikasi, o.nama_organisasi,
               cat.kategori, sub1.subkategori1, sub2.subkategori2, sub3.subkategori3
        FROM kuesioner k
        JOIN pertanyaan p ON k.id_pertanyaan = p.id_pertanyaan
        JOIN organisasi o ON k.id_organisasi = o.id_organisasi
        LEFT JOIN kategori cat ON p.id_kategori = cat.id_kategori
        LEFT JOIN subkategori1 sub1 ON p.id_subkategori1 = sub1.id_subkategori1
        LEFT JOIN subkategori2 sub2 ON p.id_subkategori2 = sub2.id_subkategori2
        LEFT JOIN subkategori3 sub3 ON p.id_subkategori3 = sub3.id_subkategori3
        WHERE k.id_organisasi = ? AND k.id_penilai = ?
        ORDER BY cat.kategori, sub1.subkategori1, sub2.subkategori2, sub3.subkategori3, k.verifikasi, k.id_kuesioner DESC";


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
                            <thead >
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
                                <th style='padding: 10px; width: 60%;'>bobot</th>

                                 <th style='padding: 10px; width: 60%;'>jawaban</th>
                                 <th style='padding: 10px; width: 60%;'>link</th>
                                 <th style='padding: 10px; width: 60%;'>dokumen</th>
                                 <th style='padding: 10px; width: 60%;'>nilai</th>
                                 <th style='padding: 10px; width: 60%;'>catatan</th>
                                 <th style='padding: 10px; width: 60%;'>verifikasi</th>
                                 <th style='padding: 10px; width: 60%;'></th>
                                </tr>
                            </thead>
                            <tbody>";
                    $last_subkategori3 = $row['subkategori3'];
                }

                // Tampilkan baris data pertanyaan
                echo "<tr>
                <td>{$row['pertanyaan']}</td>
                        <td>{$row['bobot']}</td> <!-- Menampilkan bobot di sini -->

                <td>{$row['jawaban']}</td>
                <td><a href='{$row['link']}' target='_blank'>{$row['link']}</a></td>
                <td>";
if (!empty($row['dokumen'])) {
    echo "<a href='../upt/{$row['dokumen']}' target='_blank'>Review Dokumen</a>";
} else {
    echo "Tidak ada dokumen";
}
echo "</td>
                
              
                       <td>
 <select name='nilai[{$row['id_kuesioner']}]'>
            <option value=''>Pilih Nilai</option> <!-- Opsi kosong/default -->
            <option value='A'>A</option>
            <option value='B'>B</option>
            <option value='C'>C</option>
            <option value='D'>D</option>
        </select>                          
                        </td>
                                               <td>
                          <textarea name='catatan[{$row['id_kuesioner']}]' placeholder='Catatan'></textarea>
                          
                        </td>
                                                              <td>
                            <label><input type='checkbox' name='verifikasi[{$row['id_kuesioner']}]' value='1'> Verifikasi</label>
                          
                        </td>
                         <td>
                            <input type='hidden' name='update[{$row['id_kuesioner']}]' value='1'>
                          
                        </td>
                        </tr>";
                }

                // Tutup tabel terakhir
                if ($last_subkategori3 != '') {
                    echo "</tbody></table><br>";
                }
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
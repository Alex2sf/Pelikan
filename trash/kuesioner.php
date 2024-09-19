<?php
session_start();
if (!isset($_SESSION['id_akun'])) {
    header("Location: login.php");
    exit();
}

// Koneksi ke database
$conn = new mysqli('localhost', 'root', '', 'emone'); // Sesuaikan dengan kredensial database Anda

$id_akun = $_SESSION['id_akun'];

// Mendapatkan detail organisasi berdasarkan id_akun
$sql = "SELECT * FROM Organisasi WHERE id_akun='$id_akun'";
$result = $conn->query($sql);

if ($result->num_rows > 0) {
    $organisasi = $result->fetch_assoc();
    $id_organisasi = $organisasi['id_organisasi'];
    $id_penilai = $organisasi['id_penilai'];
    $status_kuesioner = $organisasi['status_kuesioner'];
} else {
    echo "Tidak ada organisasi terkait.";
    exit();
}

// Mengecek status pengisian kuesioner
if ($status_kuesioner == 0) {
    echo "Anda sudah mengisi kuesioner. Tunggu akses dari admin untuk mengisi ulang.";
    exit();
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    foreach ($_POST['id_pertanyaan'] as $index => $id_pertanyaan) {
        $jawaban = $_POST['jawaban'][$id_pertanyaan] ?? '';
        $link = $_POST['link'][$id_pertanyaan] ?? '';
        $file = $_FILES['file']['name'][$id_pertanyaan] ?? '';
        $target_dir = "uploads/";
        $target_file = $target_dir . basename($file);

        // Upload file jika ada
        if ($file) {
            if (move_uploaded_file($_FILES['file']['tmp_name'][$id_pertanyaan], $target_file)) {
                echo "File {$file} berhasil di-upload.<br>";
            } else {
                echo "Error meng-upload file {$file}.<br>";
            }
        }

        // Ambil pertanyaan dari database berdasarkan id_pertanyaan
        $sql = "SELECT pertanyaan FROM Pertanyaan WHERE id_pertanyaan='$id_pertanyaan'";
        $result = $conn->query($sql);
        $pertanyaan_row = $result->fetch_assoc();
        $pertanyaan_text = $pertanyaan_row['pertanyaan'];

        // Update atau insert jawaban kuesioner
        $check_sql = "SELECT * FROM Kuesioner WHERE id_pertanyaan='$id_pertanyaan' AND id_organisasi='$id_organisasi'";
        $check_result = $conn->query($check_sql);
        if ($check_result->num_rows > 0) {
            // Update data yang sudah ada
            $sql = "UPDATE Kuesioner SET jawaban='$jawaban', link='$link', dokumen='$file', nilai=0, catatan='Catatan', verifikasi=0 
                    WHERE id_pertanyaan='$id_pertanyaan' AND id_organisasi='$id_organisasi'";
        } else {
            // Insert data baru
            $sql = "INSERT INTO Kuesioner (id_pertanyaan, pertanyaan, jawaban, link, dokumen, id_organisasi, unit_eselon1, nama_organisasi, nip_responden, nilai, catatan, verifikasi, id_penilai)
                    VALUES ('$id_pertanyaan', '$pertanyaan_text', '$jawaban', '$link', '$file', '$id_organisasi', '{$organisasi['unit_eselon1']}', '{$organisasi['nama_organisasi']}', '{$organisasi['nip_responden']}', 0, 'Catatan', 0, '$id_penilai')";
        }

        if ($conn->query($sql) === TRUE) {
            echo "Jawaban berhasil disimpan atau diperbarui untuk ID Pertanyaan: $id_pertanyaan<br>";
        } else {
            echo "Error: " . $sql . "<br>" . $conn->error;
        }
    }

    // Update status_kuesioner menjadi 0 setelah pengisian selesai
    $update_status_sql = "UPDATE Organisasi SET status_kuesioner = 0 WHERE id_organisasi = '$id_organisasi'";
    $conn->query($update_status_sql);
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Isi Kuesioner</title>
</head>
<body>
    <h2>Formulir Kuesioner</h2>
    <form method="post" enctype="multipart/form-data">
        <?php
        // Ambil semua pertanyaan dari tabel Pertanyaan
        $sql_pertanyaan = "SELECT * FROM Pertanyaan";
        $result_pertanyaan = $conn->query($sql_pertanyaan);
        while ($pertanyaan = $result_pertanyaan->fetch_assoc()) {
            echo "<p>" . htmlspecialchars($pertanyaan['pertanyaan']) . "</p>";
            echo "<input type='hidden' name='id_pertanyaan[]' value='{$pertanyaan['id_pertanyaan']}'>";
            echo "<input type='radio' name='jawaban[{$pertanyaan['id_pertanyaan']}]' value='Ya'> Ya ";
            echo "<input type='radio' name='jawaban[{$pertanyaan['id_pertanyaan']}]' value='Tidak'> Tidak ";
            echo "<br>";
            echo "<input type='text' name='link[{$pertanyaan['id_pertanyaan']}]' placeholder='Link'>";
            echo "<input type='file' name='file[{$pertanyaan['id_pertanyaan']}]'>";
            echo "<br><br>";
        }
        ?>
        <input type="submit" value="Kirim">
    </form>
</body>
</html>
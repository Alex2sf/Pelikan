<?php
// Koneksi ke database
$conn = new mysqli('localhost', 'root', '', 'sigh');

// Periksa koneksi
if ($conn->connect_error) {
    die("Koneksi gagal: " . $conn->connect_error);
}

// Periksa dan buat folder uploads jika belum ada
$upload_dir = 'uploads/';
if (!is_dir($upload_dir)) {
    if (!mkdir($upload_dir, 0755, true)) {
        die("Gagal membuat folder uploads.");
    }
}

if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_FILES['file'])) {
    $file_name = $_FILES['file']['name'];
    $file_tmp = $_FILES['file']['tmp_name'];
    $file_path = $upload_dir . $file_name;

    // Pindahkan file ke folder uploads
    if (move_uploaded_file($file_tmp, $file_path)) {
        $stmt = $conn->prepare("INSERT INTO files (file_name, file_path) VALUES (?, ?)");
        if ($stmt) {
            $stmt->bind_param("ss", $file_name, $file_path);
            $stmt->execute();
            $stmt->close();
            echo "File berhasil diunggah.";
        } else {
            echo "Gagal mempersiapkan statement: " . $conn->error;
        }
    } else {
        echo "Gagal mengunggah file. Pastikan folder uploads dapat diakses.";
    }
}

// Tutup koneksi
$conn->close();
?>

<!DOCTYPE html>
<html>
<body>
    <form action="upload.php" method="post" enctype="multipart/form-data">
        Pilih file untuk diunggah:
        <input type="file" name="file">
        <input type="submit" value="Unggah File">
    </form>
</body>
</html>

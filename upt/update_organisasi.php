<?php
session_start();
if (!isset($_SESSION['id_akun'])) {
    header("Location: login.php");
    exit();
}

$id_akun = $_SESSION['id_akun'];
$conn = new mysqli('localhost', 'root', '', 'emone'); // Ganti dengan kredensial database Anda

if ($conn->connect_error) {
    die("Koneksi gagal: " . $conn->connect_error);
}

// Ambil data dari form
$unit_eselon1 = $_POST['unit_eselon1'];
$nama_organisasi = $_POST['nama_organisasi'];
$alamat = $_POST['alamat'];
$email_badan = $_POST['email_badan'];
$no_telp_fax = $_POST['no_telp_fax'];
$nip_responden = $_POST['nip_responden'];
$nama_responden = $_POST['nama_responden'];
// Tambahkan variabel untuk nilai_kategori2 hingga nilai_kategori6

// Cek apakah data sudah ada untuk id_akun ini
$sql = "SELECT * FROM Organisasi WHERE id_akun = $id_akun";
$result = $conn->query($sql);

if ($result->num_rows > 0) {
    // Update data
    $sql = "UPDATE Organisasi SET unit_eselon1='$unit_eselon1', nama_organisasi='$nama_organisasi', alamat='$alamat', email_badan='$email_badan', no_telp_fax='$no_telp_fax', nip_responden='$nip_responden', nama_responden='$nama_responden' WHERE id_akun=$id_akun";
} else {
    // Insert data baru
    $sql = "INSERT INTO Organisasi (id_akun, unit_eselon1, nama_organisasi, alamat, email_badan, no_telp_fax, nip_responden, nama_responden, nilai_kategori1) VALUES ('$id_akun', '$unit_eselon1', '$nama_organisasi', '$alamat', '$email_badan', '$no_telp_fax', '$nip_responden', '$nama_responden')";
}

if ($conn->query($sql) === TRUE) {
    echo "Data berhasil disimpan!";
} else {
    echo "Error: " . $sql . "<br>" . $conn->error;
}

$conn->close();
?>

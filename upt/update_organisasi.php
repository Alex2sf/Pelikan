<?php
session_start();

require 'session_timeout.php';

if (!isset($_SESSION['id_akun'])) {
    header("Location: ../index.php");
    exit();
}

$username="";
$username1=$_SESSION["role"];

$id_akun = $_SESSION['id_akun'];
include '../koneksi.php';

// Ambil data dari form
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Ambil data dari form
    $unit_eselon1 = $_POST['unit_eselon1'];
    $nama_organisasi = $_POST['nama_organisasi'];
    $email_badan = $_POST['email_badan'];
    $no_telp_fax = $_POST['no_telp_fax'];
    $alamat = $_POST['alamat'];
    $nip_responden = $_POST['nip_responden'];
    $nama_responden = $_POST['nama_responden'];
    $jabatan = $_POST['jabatan'];

}

// Cek apakah data sudah ada untuk id_akun ini
$sql = "SELECT * FROM organisasi WHERE id_akun = $id_akun";
$result = $conn->query($sql);

if ($result->num_rows > 0) {
    // Update data
    $sql = "UPDATE organisasi SET unit_eselon1='$unit_eselon1', nama_organisasi='$nama_organisasi', alamat='$alamat', email_badan='$email_badan', no_telp_fax='$no_telp_fax', nip_responden='$nip_responden', nama_responden='$nama_responden', jabatan='$jabatan' WHERE id_akun=$id_akun";
} else {
    // Insert data baru
    $sql = "INSERT INTO organisasi (id_akun, unit_eselon1, nama_organisasi, alamat, email_badan, no_telp_fax, nip_responden, nama_responden, jabatan) 
            VALUES ('$id_akun', '$unit_eselon1', '$nama_organisasi', '$alamat', '$email_badan', '$no_telp_fax', '$nip_responden', '$nama_responden', '$jabatan')";
}

// Cek hasil query dan set session untuk menampilkan modal yang sesuai
if ($conn->query($sql) === TRUE) {
    $_SESSION['show_modal'] = 'success'; // Set modal sukses
    header("Location: profile.php"); // Redirect untuk mencegah form resubmission
    exit();
} else {
    $_SESSION['show_modal'] = 'error'; // Set modal error
    header("Location: profile.php"); // Redirect untuk mencegah form resubmission
    exit();
}
?>
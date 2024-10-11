<?php
include '../koneksi.php';

session_start();
if (!isset($_SESSION['id_akun']) || $_SESSION['role'] != 'admin') {
    die('Access denied. You must be logged in as an admin to access this page.');
}

if (isset($_POST['grant_access'])) {
    $id_organisasi = intval($_POST['grant_access']);

    // Update the access status for the selected organization
    $update_query = $conn->prepare("UPDATE organisasi SET can_fill_out = TRUE WHERE id_organisasi = ?");
    $update_query->bind_param('i', $id_organisasi);
    $update_query->execute();

    if ($update_query->affected_rows > 0) {
        echo "Akses telah diberikan untuk organisasi dengan ID: {$id_organisasi}.";
    } else {
        echo "Gagal memberikan akses. Periksa apakah ID organisasi valid.";
    }

    $update_query->close();
} else {
    echo "Permintaan tidak valid.";
}

$conn->close();
?>

<?php
session_start();
require 'session_timeout.php';

if (!isset($_SESSION['id_akun'])) {
    echo json_encode(['success' => false, 'message' => 'Unauthorized']);
    exit();
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $id_organisasi = $_POST['id_organisasi'];
    $action = $_POST['verifikasi_action'];

    $verifikasi_status = ($action === 'verifikasi') ? 0 : 1;

    include '../koneksi.php';


    // Update status verifikasi
    $stmt = $conn->prepare("UPDATE organisasi SET verifikasi = ? WHERE id_organisasi = ?");
    $stmt->bind_param('ii', $verifikasi_status, $id_organisasi);
    
    if ($stmt->execute()) {
        echo json_encode(['success' => true]);
    } else {
        echo json_encode(['success' => false, 'message' => 'Failed to update']);
    }

    $stmt->close();
    $conn->close();
} else {
    echo json_encode(['success' => false, 'message' => 'Invalid request']);
}

<?php
$conn = new mysqli('localhost', 'root', '', 'sigh');

if ($conn->connect_error) {
    die("Koneksi gagal: " . $conn->connect_error);
}

session_start();
if (!isset($_SESSION['id_akun']) || $_SESSION['role'] != 'user') {
    die('Access denied. You must be logged in as a user to submit the form.');
}

$id_akun = $_SESSION['id_akun'];
$organisasi_query = $conn->prepare("SELECT * FROM organisasi WHERE id_akun = ?");
$organisasi_query->bind_param('i', $id_akun);
$organisasi_query->execute();
$organisasi_result = $organisasi_query->get_result();

if ($organisasi_result->num_rows > 0) {
    $organisasi = $organisasi_result->fetch_assoc();
    $id_organisasi = $organisasi['id_organisasi'];
    $can_fill_out = $organisasi['can_fill_out'];

    if (!$can_fill_out) {
        die('Anda tidak dapat mengisi ulang kuesioner. Hubungi admin untuk mendapatkan akses kembali.');
    }

    foreach ($_POST['jawaban'] as $id_pertanyaan => $jawaban) {
        $pertanyaan_query = $conn->prepare("SELECT * FROM pertanyaan WHERE id_pertanyaan = ?");
        $pertanyaan_query->bind_param('i', $id_pertanyaan);
        $pertanyaan_query->execute();
        $pertanyaan_result = $pertanyaan_query->get_result();

        if ($pertanyaan_result->num_rows > 0) {
            $pertanyaan_row = $pertanyaan_result->fetch_assoc();
            $pertanyaan_text = $pertanyaan_row['pertanyaan'];
            $id_kategori = $pertanyaan_row['id_kategori'];
            $id_subkategori1 = $pertanyaan_row['id_subkategori1'];
            $id_subkategori2 = $pertanyaan_row['id_subkategori2'];
            $id_subkategori3 = $pertanyaan_row['id_subkategori3'];
        } else {
            continue;
        }

        $link = isset($_POST['link'][$id_pertanyaan]) ? $_POST['link'][$id_pertanyaan] : NULL;
        $dokumen = isset($_FILES['dokumen']['name'][$id_pertanyaan]) ? $_FILES['dokumen']['name'][$id_pertanyaan] : NULL;

        // Handle file upload
        if ($dokumen) {
            $upload_dir = 'uploads/';
            $upload_file = $upload_dir . basename($_FILES['dokumen']['name'][$id_pertanyaan]);
            if (move_uploaded_file($_FILES['dokumen']['tmp_name'][$id_pertanyaan], $upload_file)) {
                $dokumen = $upload_file; // Save the path to the database
            } else {
                $dokumen = NULL; // If file upload fails
            }
        }

        // Check if the record already exists (UPDATE instead of INSERT if it exists)
        $check_query = $conn->prepare("SELECT * FROM kuesioner WHERE id_pertanyaan = ? AND id_organisasi = ?");
        $check_query->bind_param('ii', $id_pertanyaan, $id_organisasi);
        $check_query->execute();
        $check_result = $check_query->get_result();

        if ($check_result->num_rows > 0) {
            // Update existing record if it exists
            $stmt = $conn->prepare("UPDATE kuesioner SET jawaban = ?, link = ?, dokumen = ? WHERE id_pertanyaan = ? AND id_organisasi = ?");
            $stmt->bind_param('sssii', $jawaban, $link, $dokumen, $id_pertanyaan, $id_organisasi);
        } else {
            // Insert new record
            $stmt = $conn->prepare("INSERT INTO kuesioner (
                id_pertanyaan, pertanyaan, jawaban, link, dokumen, id_organisasi, unit_eselon1, nama_organisasi, nip_responden, id_penilai, id_kategori, id_subkategori1, id_subkategori2, id_subkategori3
            ) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)");
            $stmt->bind_param('issssisssiiiii', 
                $id_pertanyaan, $pertanyaan_text, $jawaban, $link, $dokumen, $id_organisasi, 
                $organisasi['unit_eselon1'], $organisasi['nama_organisasi'], $organisasi['nip_responden'], 
                $organisasi['id_penilai'], $id_kategori, $id_subkategori1, $id_subkategori2, $id_subkategori3
            );
        }
        $stmt->execute();
    }

    // Tetap revoke access setelah kuesioner dikirim
    $update_query = $conn->prepare("UPDATE organisasi SET can_fill_out = FALSE WHERE id_organisasi = ?");
    $update_query->bind_param('i', $id_organisasi);
    $update_query->execute();

    // Tutup statement dan koneksi
    $stmt->close();
    $conn->close();

    echo "Data telah berhasil dikirim. Anda tidak dapat mengisi ulang kuesioner.";
} else {
    echo "Organisasi data tidak ditemukan.";
}
?>

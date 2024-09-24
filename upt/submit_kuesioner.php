<?php
$conn = new mysqli('localhost', 'root', '', 'sigh'); // Ganti dengan kredensial database Anda

// Cek koneksi database
if ($conn->connect_error) {
    die("Koneksi gagal: " . $conn->connect_error);
}

// Check if the form is submitted
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    session_start();
    if (!isset($_SESSION['id_akun']) || $_SESSION['role'] != 'user') {
        die('Access denied. You must be logged in as a user to submit the form.');
    }

    $id_akun = $_SESSION['id_akun']; // Get the user ID from the session
    $organisasi_query = $conn->prepare("SELECT * FROM organisasi WHERE id_akun = ?");
    $organisasi_query->bind_param('i', $id_akun);
    $organisasi_query->execute();
    $organisasi_result = $organisasi_query->get_result();

    if ($organisasi_result->num_rows > 0) {
        $organisasi = $organisasi_result->fetch_assoc();
        $id_organisasi = $organisasi['id_organisasi'];
        $unit_eselon1 = $organisasi['unit_eselon1'];
        $nama_organisasi = $organisasi['nama_organisasi'];
        $nip_responden = $organisasi['nip_responden'];
        $id_penilai = $organisasi['id_penilai'];
    } else {
        die('Organisasi data not found.');
    }

    foreach ($_POST['jawaban'] as $id_pertanyaan => $jawaban) {
        // Prepare the SQL statements
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
            continue; // Skip if the pertanyaan is not found
        }

        $link = isset($_POST['link'][$id_pertanyaan]) ? $_POST['link'][$id_pertanyaan] : NULL;
        $dokumen = isset($_FILES['dokumen']['name'][$id_pertanyaan]) ? $_FILES['dokumen']['name'][$id_pertanyaan] : NULL;

        // Handle file upload
        if ($dokumen) {
            $upload_dir = 'uploads/';
            $upload_file = $upload_dir . basename($_FILES['dokumen']['name'][$id_pertanyaan]);
            move_uploaded_file($_FILES['dokumen']['tmp_name'][$id_pertanyaan], $upload_file);
        }

        // Check if the record already exists
        $check_query = $conn->prepare("SELECT * FROM kuesioner WHERE id_pertanyaan = ? AND id_organisasi = ?");
        $check_query->bind_param('ii', $id_pertanyaan, $id_organisasi);
        $check_query->execute();
        $check_result = $check_query->get_result();

        if ($check_result->num_rows > 0) {
            // Update existing record
            $stmt = $conn->prepare("UPDATE kuesioner SET jawaban = ?, link = ?, dokumen = ? WHERE id_pertanyaan = ? AND id_organisasi = ?");
            $stmt->bind_param('sssii', $jawaban, $link, $dokumen, $id_pertanyaan, $id_organisasi);
        } else {
            // Insert new record
            $stmt = $conn->prepare("INSERT INTO kuesioner (
                id_pertanyaan, pertanyaan, jawaban, link, dokumen, id_organisasi, unit_eselon1, nama_organisasi, nip_responden, id_penilai, id_kategori, id_subkategori1, id_subkategori2, id_subkategori3
            ) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)");
            $stmt->bind_param('issssisssiiiii', 
                $id_pertanyaan, $pertanyaan_text, $jawaban, $link, $dokumen, $id_organisasi, $unit_eselon1, $nama_organisasi, $nip_responden, $id_penilai, 
                $id_kategori, $id_subkategori1, $id_subkategori2, $id_subkategori3
            );
        }
        $stmt->execute();
    }

    // Close statement and connection
    $stmt->close();
    $conn->close();

    echo "Data telah berhasil dikirim.";
} else {
    echo "Permintaan tidak valid.";
}
?>

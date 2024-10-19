<?php
session_start();
include '../koneksi.php';

?>

<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Custom Popup</title>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <!-- CSS untuk styling popup -->
    <style>
        .popup {
            display: block; /* Default terlihat, nanti akan disembunyikan dengan JavaScript */
            position: fixed;
            z-index: 999;
            left: 0;
            top: 0;
            width: 100%;
            height: 100%;
            background-color: rgba(0, 0, 0, 0.5); /* Background hitam transparan */
        }

        .popup-content {
            position: relative;
            margin: 15% auto;
            padding: 20px;
            width: 300px;
            background-color: white;
            border-radius: 8px;
            text-align: center;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2);
        }

        .popup-content h2 {
            font-size: 24px;
            color: #333;
        }

        .popup-content p {
            font-size: 16px;
            color: #666;
        }

        .popup-content button {
            background-color: #4CAF50;
            color: white;
            border: none;
            padding: 10px 20px;
            cursor: pointer;
            border-radius: 4px;
            font-size: 16px;
        }

        .popup-content button:hover {
            background-color: #45a049;
        }
    </style>
</head>
<body>
<?php
session_start(); // Always make sure session is started
$id_akun = $_SESSION['id_akun'];

// Cek apakah pengguna sudah login dan memiliki peran 'user'
if (!isset($_SESSION['id_akun']) || $_SESSION['role'] != 'user') {
    // Jika akses ditolak, tampilkan pop-up
    echo "
    <div id='popup' class='popup'>
        <div class='popup-content'>
            <h2>Access Denied</h2>
            <p>Anda harus masuk sebagai pengguna untuk mengirimkan formulir.</p>
            <button onclick='redirectToLogin()'>OK</button>
        </div>
    </div>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            document.getElementById('popup').style.display = 'block';
        });

        function redirectToLogin() {
            window.location.href = '../index.php'; // Redirect ke halaman login atau halaman lain
        }
    </script>";
    exit();
}

// Prepare query to check organisasi
$organisasi_query = $conn->prepare("SELECT * FROM organisasi WHERE id_akun = ?");
$organisasi_query->bind_param('i', $id_akun);
$organisasi_query->execute();
$organisasi_result = $organisasi_query->get_result();

if ($organisasi_result->num_rows > 0) {
    $organisasi = $organisasi_result->fetch_assoc();
    $id_organisasi = $organisasi['id_organisasi'];
    $can_fill_out = $organisasi['can_fill_out'];

    // Check if the user can still fill out the questionnaire
    if (!$can_fill_out) {
        echo "<div id='popup' class='popup'>
            <div class='popup-content'>
                <h2>Warning</h2>
                <p>Anda tidak dapat mengisi ulang kuesioner. Hubungi admin untuk mendapatkan akses kembali.</p>
                <button onclick='closePopup()'>OK</button>
            </div>
        </div>
        <script>
            function closePopup() {
                document.getElementById('popup').style.display = 'none';
                window.location.href = 'index.php'; // Redirect setelah menutup popup
            }
        </script>";
        exit();
    }

    // Handle form submission
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        foreach ($_POST['jawaban'] as $id_pertanyaan => $jawaban) {
            // Prepare pertanyaan query
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
                continue; // Skip if no question is found
            }

            // Handle optional link and file upload
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

            // Check if the record already exists
            $check_query = $conn->prepare("SELECT * FROM kuesioner WHERE id_pertanyaan = ? AND id_organisasi = ?");
            $check_query->bind_param('ii', $id_pertanyaan, $id_organisasi);
            $check_query->execute();
            $check_result = $check_query->get_result();

            if ($check_result->num_rows > 0) {
                // Update if record exists
                $existing_row = $check_result->fetch_assoc();
                $existing_dokumen = $existing_row['dokumen'];

                if ($dokumen == NULL) {
                    $dokumen = $existing_dokumen; // Use existing document if no new file uploaded
                }

                $stmt = $conn->prepare("UPDATE kuesioner SET jawaban = ?, link = ?, dokumen = ? WHERE id_pertanyaan = ? AND id_organisasi = ?");
                $stmt->bind_param('sssii', $jawaban, $link, $dokumen, $id_pertanyaan, $id_organisasi);
            } else {
                // Insert new record
                $stmt = $conn->prepare("INSERT INTO kuesioner (id_pertanyaan, pertanyaan, jawaban, link, dokumen, id_organisasi, unit_eselon1, nama_organisasi, nip_responden, id_penilai, id_kategori, id_subkategori1, id_subkategori2, id_subkategori3)
                    VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)");
                $stmt->bind_param('issssisssiiiii', $id_pertanyaan, $pertanyaan_text, $jawaban, $link, $dokumen, $id_organisasi, 
                    $organisasi['unit_eselon1'], $organisasi['nama_organisasi'], $organisasi['nip_responden'], 
                    $organisasi['id_penilai'], $id_kategori, $id_subkategori1, $id_subkategori2, $id_subkategori3);
            }
            $stmt->execute();
        }

        // Check for submission type
        if ($_POST['submit_type'] == 'Kirim') {
            // Update can_fill_out status to FALSE
            $update_query = $conn->prepare("UPDATE organisasi SET can_fill_out = FALSE WHERE id_organisasi = ?");
            $update_query->bind_param('i', $id_organisasi);
            $update_query->execute();

            echo "<script>
                Swal.fire({
                    icon: 'success',
                    title: 'Success',
                    text: 'Anda telah mengisi. Kuesioner sudah terkirim.',
                    confirmButtonText: 'OK'
                }).then((result) => {
                    if (result.isConfirmed) {
                        window.location.href = 'index.php'; // Redirect to main page
                    }
                });
            </script>";
        } elseif ($_POST['submit_type'] == 'Simpan') {
            echo "<script>
                Swal.fire({
                    icon: 'success',
                    title: 'Data Disimpan',
                    text: 'Kuesioner telah disimpan. Anda dapat melanjutkan pengisian nanti.',
                    confirmButtonText: 'OK'
                }).then((result) => {
                    if (result.isConfirmed) {
                        window.location.href = 'index.php'; // Redirect to main page
                    }
                });
            </script>";
        }

        // Close statement and connection
        $stmt->close();
        $conn->close();
    }
} else {
    // If no organisasi data found
    echo "
    <div id='popup' class='popup'>
        <div class='popup-content'>
            <h2>Error</h2>
            <p>Data organisasi tidak ditemukan.</p>
            <button onclick='closePopup()'>OK</button>
        </div>
    </div>
    <script>
        function closePopup() {
            document.getElementById('popup').style.display = 'none';
            window.location.href = 'error_page.php'; // Redirect setelah menutup popup
        }
    </script>";
    exit();
}
?>

</body>
</html>

    
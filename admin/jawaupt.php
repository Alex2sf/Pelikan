<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Lihat dan Download Dokumen</title>
</head>
<body>
    <h2>Daftar Dokumen</h2>

    <?php
    // Gunakan path absolut ke folder uploads
    $folder_uploads = 'C:/laragon/www/Pelikan/upt/uploads/';

    // Cek apakah folder uploads ada
    if (is_dir($folder_uploads)) {
        // Buka folder uploads
        if ($dh = opendir($folder_uploads)) {
            // Loop untuk setiap file dalam folder
            while (($file = readdir($dh)) !== false) {
                // Skip . dan .. (current dan parent directory)
                if ($file != "." && $file != "..") {
                    // Path file di browser (relatif ke folder web server)
                    $file_path = '/Pelikan/upt/uploads/' . $file; // Perbaiki path relatif untuk URL

                    // Tipe file berdasarkan ekstensi
                    $file_extension = strtolower(pathinfo($file, PATHINFO_EXTENSION));

                    // Tampilkan file dengan dua tombol: Review dan Download
                    echo "<div>";
                    echo "<p>File: " . htmlspecialchars($file) . "</p>";

                    // Periksa jenis file untuk tindakan berbeda
                    if (in_array($file_extension, ['jpg', 'jpeg', 'png', 'gif'])) {
                        // Jika file gambar, tampilkan sebagai gambar di halaman
                        echo "<img src='" . htmlspecialchars($file_path) . "' alt='Gambar' style='width:300px;'><br>";
                        echo "<a href='" . htmlspecialchars($file_path) . "' target='_blank'><button>Review Gambar</button></a>";
                    } elseif ($file_extension === 'pdf') {
                        // Jika file PDF, buka di tab baru
                        echo "<a href='" . htmlspecialchars($file_path) . "' target='_blank'><button>Review PDF</button></a>";
                    } elseif (in_array($file_extension, ['doc', 'docx'])) {
                        // Jika file DOCX, sambungkan ke Google Docs
                        $google_docs_url = "https://docs.google.com/viewer?url=" . urlencode("http://localhost" . $file_path) . "&embedded=true";
                        echo "<a href='" . htmlspecialchars($google_docs_url) . "' target='_blank'><button>Review DOCX</button></a>";
                    } elseif (in_array($file_extension, ['ppt', 'pptx'])) {
                        // Jika file PPTX, sambungkan ke Google Slides
                        $google_slides_url = "https://docs.google.com/presentation/d/" . urlencode("http://localhost" . $file_path) . "/embed";
                        echo "<a href='" . htmlspecialchars($google_slides_url) . "' target='_blank'><button>Review PPTX</button></a>";
                    } elseif (in_array($file_extension, ['xls', 'xlsx'])) {
                        // Jika file XLSX, sambungkan ke Google Sheets
                        $google_sheets_url = "https://docs.google.com/spreadsheets/d/" . urlencode("http://localhost" . $file_path) . "/embed";
                        echo "<a href='" . htmlspecialchars($google_sheets_url) . "' target='_blank'><button>Review XLSX</button></a>";
                    } else {
                        // Untuk file lain yang tidak diketahui, hanya tawarkan untuk download
                        echo "<a href='" . htmlspecialchars($file_path) . "' target='_blank'><button>Review File</button></a>";
                    }

                    // Tombol download untuk semua file
                    echo "<a href='" . htmlspecialchars($file_path) . "' download><button>Download</button></a>";
                    echo "</div><br>";
                }
            }
            // Tutup folder setelah selesai
            closedir($dh);
        }
    } else {
        echo "<p>Folder uploads tidak ditemukan.</p>";
    }
    ?>
</body>
</html>
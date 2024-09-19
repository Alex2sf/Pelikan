<?php
$conn = new mysqli('localhost', 'root', '', 'sigh'); // Ganti dengan kredensial database Anda

// Cek koneksi database
if ($conn->connect_error) {
    die("Koneksi gagal: " . $conn->connect_error);
}

if (isset($_POST['id_kategori']) && !empty($_POST['id_kategori'])) {
    $id_kategori = $_POST['id_kategori'];

    // Query untuk mengambil pertanyaan berdasarkan kategori yang dipilih
    $sql = "SELECT P.id_pertanyaan, P.pertanyaan, K.kategori, SK1.subkategori1, SK2.subkategori2, SK3.subkategori3, P.bobot, P.web 
            FROM Pertanyaan P 
            JOIN Kategori K ON P.id_kategori = K.id_kategori
            JOIN SubKategori1 SK1 ON P.id_subkategori1 = SK1.id_subkategori1
            JOIN SubKategori2 SK2 ON P.id_subkategori2 = SK2.id_subkategori2
            JOIN SubKategori3 SK3 ON P.id_subkategori3 = SK3.id_subkategori3
            WHERE P.id_kategori = '$id_kategori'
            ORDER BY SK1.id_subkategori1, SK2.id_subkategori2, SK3.id_subkategori3";

    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        echo "<form action='submit_kuesioner.php' method='post' enctype='multipart/form-data'>"; // Start the form
        $last_subkategori1 = '';
        $last_subkategori2 = '';
        $last_subkategori3 = '';

        // Output data every row
        while ($row = $result->fetch_assoc()) {
            // If SubKategori1 changes, create a new header
            if ($last_subkategori1 != $row['subkategori1']) {
                if ($last_subkategori1 != '') {
                    echo "</tbody></table><br>"; // Close previous table if any
                }
                echo "<table border='1' style='border-collapse: collapse; width: 100%; margin-bottom: 10px;' >
                        <thead>
                            <tr style='background-color: #343A40; color: white;'>
                                <th style='padding: 10px; width: 60%;'>{$row['subkategori1']}</th>
                            </tr>
                        </thead>
                        <tbody>";
                $last_subkategori1 = $row['subkategori1'];
                $last_subkategori2 = ''; // Reset SubKategori2
                $last_subkategori3 = ''; // Reset SubKategori3
            }

            // If SubKategori2 changes, create a new header
            if ($last_subkategori2 != $row['subkategori2']) {
                if ($last_subkategori2 != '') {
                    echo "</tbody></table><br>"; // Close previous table if any
                }
                echo "<table border='1' style='border-collapse: collapse; width: 100%; margin-bottom: 10px;' >
                        <thead>
                            <tr style='background-color: #343A40; color: white;'>
                                <th style='padding: 10px; width: 60%;'>{$row['subkategori2']}</th>
                            </tr>
                        </thead>
                        <tbody>";
                $last_subkategori2 = $row['subkategori2'];
                $last_subkategori3 = ''; // Reset SubKategori3
            }

            // If SubKategori3 changes, create a new header
            if ($last_subkategori3 != $row['subkategori3']) {
                if ($last_subkategori3 != '') {
                    echo "</tbody></table><br>"; // Close previous table if any
                }
                echo "<table border='1' style='border-collapse: collapse; width: 100%; margin-bottom: 10px;' >
                        <thead>
                            <tr style='background-color: #343A40; color: white;'>
                                <th style='padding: 10px; width: 40%;'>{$row['subkategori3']}</th>
                                <th style='padding: 10px; width: 10%;'>Bobot</th>
                                <th style='padding: 10px; width: 30%;'>Web</th>
                                <th style='padding: 10px; width: 10%;'>Jawaban</th>
                                <th style='padding: 10px; width: 10%;'>Link</th>
                                <th style='padding: 10px; width: 10%;'>Dokumen</th>
                            </tr>
                        </thead>
                        <tbody>";
                $last_subkategori3 = $row['subkategori3'];
            }

            // Display questions related to SubKategori3
            echo "<tr>
                    <td style='padding: 8px; border-bottom: 1px solid #ddd;'>{$row['pertanyaan']}</td>
                    <td style='padding: 8px; border-bottom: 1px solid #ddd;'>{$row['bobot']}</td>
                    <td style='padding: 8px; border-bottom: 1px solid #ddd;'><a href='{$row['web']}' target='_blank' style='color: #007BFF;'>{$row['web']}</a></td>
                    <td style='padding: 8px; border-bottom: 1px solid #ddd;'>
                        <input type='radio' name='jawaban[{$row['id_pertanyaan']}]' value='Ya'> Ya
                        <input type='radio' name='jawaban[{$row['id_pertanyaan']}]' value='Tidak'> Tidak
                    </td>
                    <td style='padding: 8px; border-bottom: 1px solid #ddd;'>
                        <input type='text' name='link[{$row['id_pertanyaan']}]' placeholder='Masukkan link'>
                    </td>
                    <td style='padding: 8px; border-bottom: 1px solid #ddd;'>
                        <input type='file' name='dokumen[{$row['id_pertanyaan']}]'>
                    </td>
                  </tr>";
        }
        echo "</tbody></table><br>";
        echo "<input type='submit' value='Kirim' style='padding: 10px 20px; background-color: #007BFF; color: white; border: none; border-radius: 5px;'>";
        echo "</form>";
    } else {
        echo "Tidak ada pertanyaan untuk kategori ini.";
    }
}

$conn->close();
?>

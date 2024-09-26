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
        echo "<form action='submit_kuesioner.php' method='post' enctype='multipart/form-data' class='form-kuesioner'>"; // Start the form
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
                echo "<table class='table-kuesioner'>
                        <thead>
                            <tr class='subkategori1'>
                                <th colspan='6'>{$row['subkategori1']}</th>
                            </tr>
                        </thead>
                        <tbody>";
                $last_subkategori1 = $row['subkategori1'];
                $last_subkategori2 = ''; // Reset SubKategori2
                $last_subkategori3 = ''; // Reset SubKategori3
            }

            // If SubKategori2 changes, create a new header
            if ($last_subkategori2 != $row['subkategori2']) {
                echo "<thead>
                        <tr class='subkategori2'>
                            <th colspan='6'>{$row['subkategori2']}</th>
                        </tr>
                      </thead>";
                $last_subkategori2 = $row['subkategori2'];
            }

            // If SubKategori3 changes, create a new header
            if ($last_subkategori3 != $row['subkategori3']) {
                echo "<thead>
                        <tr class='subkategori3'>
                            <th>Pertanyaan</th>
                            <th>Bobot</th>
                            <th>Web</th>
                            <th>Jawaban</th>
                            <th>Link</th>
                            <th>Dokumen</th>
                        </tr>
                      </thead>";
                $last_subkategori3 = $row['subkategori3'];
            }

            // Display questions related to SubKategori3
            echo "<tr>
                    <td>{$row['pertanyaan']}</td>
                    <td>{$row['bobot']}</td>
                    <td><a href='{$row['web']}' target='_blank'>{$row['web']}</a></td>
                    <td>
                        <input type='radio' name='jawaban[{$row['id_pertanyaan']}]' value='Ya'> Ya
                        <input type='radio' name='jawaban[{$row['id_pertanyaan']}]' value='Tidak'> Tidak
                    </td>
                    <td>
                        <input type='text' name='link[{$row['id_pertanyaan']}]' placeholder='Masukkan link' class='form-control'>
                    </td>
                    <td>
                        <input type='file' name='dokumen[{$row['id_pertanyaan']}]' class='form-control'>
                    </td>
                  </tr>";
        }
        echo "</tbody></table><br>";
        echo "<input type='submit' value='Kirim' class='btn-submit'>";
        echo "</form>";
    } else {
        echo "<p class='no-data'>Tidak ada pertanyaan untuk kategori ini.</p>";
    }
}

$conn->close();
?>
<style>
    /* Form Container */
.form-kuesioner {
    margin: 20px auto;
    max-width: 1800px;
    padding: 20px;
    background-color: #fff;
    border-radius: 8px;
    box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
}

/* Tabel Styling */
.table-kuesioner {
    width: 100%;
    border-collapse: collapse;
    margin-bottom: 20px;
}

.table-kuesioner th, .table-kuesioner td {
    padding: 10px;
    text-align: left;
    border: 1px solid #ddd;
}

.table-kuesioner thead th {
    background-color: #343A40;
    color: white;
}

.subkategori1 th, .subkategori2 th {
    background-color: #6C757D;
    color: white;
    font-weight: bold;
}

.subkategori3 th {
    background-color: #007BFF;
    color: white;
    font-weight: bold;
}

/* Input Styles */
.form-control {
    width: 100%;
    padding: 8px;
    margin-bottom: 10px;
    border: 1px solid #ccc;
    border-radius: 4px;
}

.form-control[type="radio"] {
    width: auto;
    margin-right: 5px;
}

/* Submit Button */
.btn-submit {
    background-color: #007BFF;
    color: white;
    border: none;
    padding: 12px 20px;
    cursor: pointer;
    border-radius: 4px;
    font-size: 16px;
}

.btn-submit:hover {
    background-color: #0056b3;
}

/* No Data Message */
.no-data {
    font-size: 18px;
    text-align: center;
    color: #ff0000;
    margin-top: 20px;
}

</style>
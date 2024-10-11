<?php
// Koneksi ke database
include '../koneksi.php';


// Query untuk mengambil data dari database
$sql = "
    SELECT k.kategori, s1.subkategori1, s2.subkategori2, s3.subkategori3, 
           p.pertanyaan, p.bobot, q.jawaban, q.link, q.dokumen, q.catatan, q.verifikasi
    FROM pertanyaan p
    JOIN kategori k ON p.id_kategori = k.id_kategori
    JOIN subkategori1 s1 ON p.id_subkategori1 = s1.id_subkategori1
    JOIN subkategori2 s2 ON p.id_subkategori2 = s2.id_subkategori2
    JOIN subkategori3 s3 ON p.id_subkategori3 = s3.id_subkategori3
    LEFT JOIN kuesioner q ON p.id_pertanyaan = q.id_pertanyaan
";

$result = $conn->query($sql);

// Set header untuk file CSV
header('Content-Type: text/csv');
header('Content-Disposition: attachment; filename="data_kuesioner.csv"');

// Membuat pointer file output
$output = fopen('php://output', 'w');

// Menulis header kolom ke file CSV
fputcsv($output, ['Kategori', 'SubKategori1', 'SubKategori2', 'SubKategori3', 'Pertanyaan', 'Bobot', 'Jawaban', 'Link', 'Dokumen', 'Catatan', 'Verifikasi']);

// Looping melalui hasil query dan menulis data ke CSV
if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        fputcsv($output, [
            $row['kategori'],
            $row['subkategori1'],
            $row['subkategori2'],
            $row['subkategori3'],
            $row['pertanyaan'],
            $row['bobot'],
            $row['jawaban'],
            $row['link'],
            $row['dokumen'],
            $row['catatan'],
            $row['verifikasi']
        ]);
    }
}

// Menutup file pointer dan koneksi
fclose($output);
$conn->close();
exit;
?>

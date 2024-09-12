<?php
session_start();
if (!isset($_SESSION['id_akun']) || $_SESSION['role'] != 'admin') {
    header("Location: login.php");
    exit();
}

// Koneksi ke database
$conn = new mysqli('localhost', 'root', '', 'emone'); // Sesuaikan dengan kredensial database Anda

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['id_organisasi'])) {
    $id_organisasi = $_POST['id_organisasi'];

    // Beri akses ulang kepada user dengan mengubah status_kuesioner menjadi 1
    $sql = "UPDATE Organisasi SET status_kuesioner = 1 WHERE id_organisasi = '$id_organisasi'";

    if ($conn->query($sql) === TRUE) {
        echo "Akses ulang diberikan untuk organisasi ID: $id_organisasi";
    } else {
        echo "Error: " . $sql . "<br>" . $conn->error;
    }
}

// Ambil daftar organisasi
$sql = "SELECT id_organisasi, nama_organisasi FROM Organisasi";
$result = $conn->query($sql);
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin - Beri Akses Kembali</title>
</head>
<body>
    <h2>Berikan Akses Ulang untuk Kuesioner</h2>
    <form method="post" action="admin_akses.php">
        <select name="id_organisasi">
            <?php while ($row = $result->fetch_assoc()): ?>
                <option value="<?php echo $row['id_organisasi']; ?>">
                    <?php echo htmlspecialchars($row['nama_organisasi']); ?>
                </option>
            <?php endwhile; ?>
        </select>
        <input type="submit" value="Beri Akses Ulang">
    </form>
</body>
</html>
<?php
session_start();
if (!isset($_SESSION['id_akun']) || $_SESSION['role'] != 'admin') {
    header("Location: admin_login.php");
    exit();
}

// Koneksi ke database
$conn = new mysqli('localhost', 'root', '', 'emone'); // Ganti dengan kredensial database Anda

if ($conn->connect_error) {
    die("Koneksi gagal: " . $conn->connect_error);
}

// Tambahkan akses penilai ke organisasi
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['add_access'])) {
    $id_penilai = $_POST['id_penilai'];
    $id_organisasi = $_POST['id_organisasi'];

    // Cek apakah kombinasi id_penilai dan id_organisasi sudah ada di tabel Penilai_User_Access
    $check_sql = "SELECT * FROM Penilai_User_Access WHERE id_penilai='$id_penilai' AND id_organisasi='$id_organisasi'";
    $check_result = $conn->query($check_sql);

    if ($check_result->num_rows == 0) {
        // Tambahkan akses jika belum ada
        $sql = "INSERT INTO Penilai_User_Access (id_penilai, id_organisasi) VALUES ('$id_penilai', '$id_organisasi')";
        if ($conn->query($sql) === TRUE) {
            // Update kolom id_penilai di tabel Organisasi jika belum ada penilai lain
            $sql_update_organisasi = "UPDATE Organisasi SET id_penilai = '$id_penilai' WHERE id_organisasi = '$id_organisasi' AND id_penilai IS NULL";
            if ($conn->query($sql_update_organisasi) === TRUE) {
                echo "<p style='color: green;'>Akses berhasil ditambahkan dan tabel Organisasi berhasil diperbarui!</p>";
            } else {
                echo "<p style='color: red;'>Error mengupdate tabel Organisasi: " . $conn->error . "</p>";
            }
        } else {
            echo "<p style='color: red;'>Error: " . $sql . "<br>" . $conn->error . "</p>";
        }
    } else {
        echo "<p style='color: orange;'>Akses sudah ada.</p>";
    }
}

// Menghapus Akses Penilai ke Organisasi
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['delete_access'])) {
    $id_penilai = $_POST['id_penilai'];
    $id_organisasi = $_POST['id_organisasi'];

    // Hapus dari tabel Penilai_User_Access
    $sql_delete = "DELETE FROM Penilai_User_Access WHERE id_penilai='$id_penilai' AND id_organisasi='$id_organisasi'";
    if ($conn->query($sql_delete) === TRUE) {
        // Periksa apakah ada akses lain untuk organisasi tersebut
        $check_other_access_sql = "SELECT * FROM Penilai_User_Access WHERE id_organisasi='$id_organisasi'";
        $check_other_access_result = $conn->query($check_other_access_sql);

        if ($check_other_access_result->num_rows == 0) {
            // Set kolom id_penilai menjadi NULL di tabel Organisasi jika tidak ada akses lain
            $sql_update_null = "UPDATE Organisasi SET id_penilai = NULL WHERE id_organisasi = '$id_organisasi'";
            if ($conn->query($sql_update_null) === TRUE) {
                echo "<p style='color: green;'>Akses berhasil dihapus dan id_penilai di tabel Organisasi berhasil diatur menjadi NULL.</p>";
            } else {
                echo "<p style='color: red;'>Error mengupdate tabel Organisasi: " . $conn->error . "</p>";
            }
        } else {
            echo "<p style='color: green;'>Akses berhasil dihapus.</p>";
        }
    } else {
        echo "<p style='color: red;'>Error: " . $conn->error . "</p>";
    }
}

// Ambil daftar penilai dan organisasi
$penilai_sql = "SELECT * FROM Profile_Penilai";
$penilai_result = $conn->query($penilai_sql);

$organisasi_sql = "SELECT * FROM Organisasi";
$organisasi_result = $conn->query($organisasi_sql);
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Atur Akses Penilai</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f4;
            padding: 20px;
        }
        .form-container {
            background-color: #fff;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            max-width: 600px;
            margin: auto;
            margin-bottom: 20px;
        }
        h2 {
            text-align: center;
            margin-bottom: 20px;
            color: #333;
        }
        label, select, input[type="submit"] {
            width: 100%;
            padding: 10px;
            margin: 10px 0;
            border: 1px solid #ccc;
            border-radius: 4px;
            box-sizing: border-box;
        }
        input[type="submit"] {
            background-color: #007bff;
            color: white;
            border: none;
            cursor: pointer;
            font-size: 16px;
        }
        input[type="submit"]:hover {
            background-color: #0056b3;
        }
    </style>
</head>
<body>
    <div class="form-container">
        <h2>Atur Akses Penilai</h2>
        <form method="post" action="akses_penilai.php">
            <label for="id_penilai">Pilih Penilai:</label>
            <select name="id_penilai" id="id_penilai" required>
                <?php
                $penilai_result->data_seek(0); // Reset hasil query penilai
                while ($penilai = $penilai_result->fetch_assoc()) {
                    echo "<option value='{$penilai['id_penilai']}'>{$penilai['nama_penilai']} (NIP: {$penilai['nip']})</option>";
                }
                ?>
            </select>

            <label for="id_organisasi">Pilih Organisasi:</label>
            <select name="id_organisasi" id="id_organisasi" required>
                <?php
                $organisasi_result->data_seek(0); // Reset hasil query organisasi
                while ($organisasi = $organisasi_result->fetch_assoc()) {
                    echo "<option value='{$organisasi['id_organisasi']}'>{$organisasi['nama_organisasi']} (Unit: {$organisasi['unit_eselon1']})</option>";
                }
                ?>
            </select>

            <input type="submit" name="add_access" value="Tambahkan Akses">
        </form>
    </div>

    <div class="form-container">
        <h2>Hapus Akses Penilai</h2>
        <form method="post" action="akses_penilai.php">
            <label for="id_penilai">Pilih Penilai:</label>
            <select name="id_penilai" id="id_penilai" required>
                <?php
                $penilai_result->data_seek(0); // Reset hasil query penilai
                while ($penilai = $penilai_result->fetch_assoc()) {
                    echo "<option value='{$penilai['id_penilai']}'>{$penilai['nama_penilai']} (NIP: {$penilai['nip']})</option>";
                }
                ?>
            </select>

            <label for="id_organisasi">Pilih Organisasi:</label>
            <select name="id_organisasi" id="id_organisasi" required>
                <?php
                $organisasi_result->data_seek(0); // Reset hasil query organisasi
                while ($organisasi = $organisasi_result->fetch_assoc()) {
                    echo "<option value='{$organisasi['id_organisasi']}'>{$organisasi['nama_organisasi']} (Unit: {$organisasi['unit_eselon1']})</option>";
                }
                ?>
            </select>

            <input type="submit" name="delete_access" value="Hapus Akses">
        </form>
    </div>
</body>
</html>

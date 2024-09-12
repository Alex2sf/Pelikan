<?php
// session_start();
// if (!isset($_SESSION['role']) || $_SESSION['role'] != 'admin') {
//     header("Location: login_penilai.php");
//     exit();
// }

$conn = new mysqli('localhost', 'root', '', 'emone'); // Ganti dengan kredensial database Anda

if ($conn->connect_error) {
    die("Koneksi gagal: " . $conn->connect_error);
}

// Menambahkan Kategori
if (isset($_POST['add_kategori'])) {
    $kategori = $_POST['kategori'];
    $sql = "INSERT INTO Kategori (kategori) VALUES ('$kategori')";
    if ($conn->query($sql) === TRUE) {
        echo "<p style='color: green;'>Kategori berhasil ditambahkan.</p>";
    } else {
        echo "<p style='color: red;'>Error: " . $conn->error . "</p>";
    }
}

// Mengupdate Kategori
if (isset($_POST['update_kategori'])) {
    $id_kategori = $_POST['id_kategori'];
    $kategori = $_POST['kategori'];
    $sql = "UPDATE Kategori SET kategori='$kategori' WHERE id_kategori='$id_kategori'";
    if ($conn->query($sql) === TRUE) {
        echo "<p style='color: green;'>Kategori berhasil diubah.</p>";
    } else {
        echo "<p style='color: red;'>Error: " . $conn->error . "</p>";
    }
}

// Menghapus Kategori
if (isset($_POST['delete_kategori'])) {
    $id_kategori = $_POST['id_kategori'];
    $sql = "DELETE FROM Kategori WHERE id_kategori='$id_kategori'";
    if ($conn->query($sql) === TRUE) {
        echo "<p style='color: green;'>Kategori berhasil dihapus.</p>";
    } else {
        echo "<p style='color: red;'>Error: " . $conn->error . "</p>";
    }
}

// Menambahkan Pertanyaan
if (isset($_POST['add_pertanyaan'])) {
    $pertanyaan = $_POST['pertanyaan'];
    $id_kategori = $_POST['id_kategori'];
    $bobot = $_POST['bobot'];
    $sql = "INSERT INTO Pertanyaan (pertanyaan, id_kategori, bobot) VALUES ('$pertanyaan', '$id_kategori', '$bobot')";
    if ($conn->query($sql) === TRUE) {
        echo "<p style='color: green;'>Pertanyaan berhasil ditambahkan.</p>";
    } else {
        echo "<p style='color: red;'>Error: " . $conn->error . "</p>";
    }
}

// Mengupdate Pertanyaan
if (isset($_POST['update_pertanyaan'])) {
    $id_pertanyaan = $_POST['id_pertanyaan'];
    $pertanyaan = $_POST['pertanyaan'];
    $id_kategori = $_POST['id_kategori'];
    $bobot = $_POST['bobot'];
    $sql = "UPDATE Pertanyaan SET pertanyaan='$pertanyaan', id_kategori='$id_kategori', bobot='$bobot' WHERE id_pertanyaan='$id_pertanyaan'";
    if ($conn->query($sql) === TRUE) {
        echo "<p style='color: green;'>Pertanyaan berhasil diubah.</p>";
    } else {
        echo "<p style='color: red;'>Error: " . $conn->error . "</p>";
    }
}

// Menghapus Pertanyaan
if (isset($_POST['delete_pertanyaan'])) {
    $id_pertanyaan = $_POST['id_pertanyaan'];
    $sql = "DELETE FROM Pertanyaan WHERE id_pertanyaan='$id_pertanyaan'";
    if ($conn->query($sql) === TRUE) {
        echo "<p style='color: green;'>Pertanyaan berhasil dihapus.</p>";
    } else {
        echo "<p style='color: red;'>Error: " . $conn->error . "</p>";
    }
}

// Mendapatkan semua kategori untuk dropdown
$sql = "SELECT id_kategori, kategori FROM Kategori";
$result = $conn->query($sql);
$kategori_options = "";
if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $kategori_options .= "<option value='" . $row['id_kategori'] . "'>" . $row['kategori'] . "</option>";
    }
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Manage Kategori dan Pertanyaan</title>
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
            margin-bottom: 20px;
        }
        h2 {
            text-align: center;
            font-size: 24px;
            color: #333;
        }
        label {
            font-size: 14px;
            color: #333;
        }
        select, input[type="text"], input[type="number"] {
            width: 100%;
            padding: 10px;
            margin: 10px 0;
            border: 1px solid #ccc;
            border-radius: 4px;
            box-sizing: border-box;
        }
        input[type="submit"] {
            width: 100%;
            background-color: #007bff;
            color: white;
            padding: 10px;
            border: none;
            border-radius: 4px;
            cursor: pointer;
            font-size: 16px;
        }
        input[type="submit"]:hover {
            background-color: #0056b3;
        }
        .message {
            font-size: 14px;
            text-align: center;
        }
    </style>
</head>
<body>
    <!-- Form untuk Kategori -->
    <div class="form-container">
        <h2>Kelola Kategori</h2>
        <form method="post" action="">
            <label for="kategori">Tambah Kategori:</label>
            <input type="text" name="kategori" id="kategori" required>
            <input type="submit" name="add_kategori" value="Tambah Kategori">
        </form>
        <form method="post" action="">
            <label for="id_kategori">Pilih Kategori untuk Update atau Hapus:</label>
            <select name="id_kategori" id="id_kategori">
                <?php echo $kategori_options; ?>
            </select>
            <input type="text" name="kategori" placeholder="Nama Kategori Baru">
            <input type="submit" name="update_kategori" value="Update Kategori">
            <input type="submit" name="delete_kategori" value="Hapus Kategori">
        </form>
    </div>

    <!-- Form untuk Pertanyaan -->
    <div class="form-container">
        <h2>Kelola Pertanyaan</h2>
        <form method="post" action="">
            <label for="pertanyaan">Tambah Pertanyaan:</label>
            <input type="text" name="pertanyaan" id="pertanyaan" required>
            <label for="id_kategori">Kategori:</label>
            <select name="id_kategori" id="id_kategori">
                <?php echo $kategori_options; ?>
            </select>
            <label for="bobot">Bobot:</label>
            <input type="number" name="bobot" id="bobot" required>
            <input type="submit" name="add_pertanyaan" value="Tambah Pertanyaan">
        </form>
        <form method="post" action="">
            <label for="id_pertanyaan">Pilih Pertanyaan untuk Update atau Hapus:</label>
            <select name="id_pertanyaan" id="id_pertanyaan">
                <?php
                $sql = "SELECT id_pertanyaan, pertanyaan FROM Pertanyaan";
                $result = $conn->query($sql);
                if ($result->num_rows > 0) {
                    while ($row = $result->fetch_assoc()) {
                        echo "<option value='" . $row['id_pertanyaan'] . "'>" . $row['pertanyaan'] . "</option>";
                    }
                }
                ?>
            </select>
            <input type="text" name="pertanyaan" placeholder="Pertanyaan Baru">
            <select name="id_kategori" id="id_kategori">
                <?php echo $kategori_options; ?>
            </select>
            <input type="number" name="bobot" placeholder="Bobot Baru">
            <input type="submit" name="update_pertanyaan" value="Update Pertanyaan">
            <input type="submit" name="delete_pertanyaan" value="Hapus Pertanyaan">
        </form>
    </div>
</body>
</html>

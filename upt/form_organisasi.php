<?php
session_start();
if (!isset($_SESSION['id_akun'])) {
    header("Location: login.php");
    exit();
}

$id_akun = $_SESSION['id_akun'];
$conn = new mysqli('localhost', 'root', '', 'emone'); // Ganti dengan kredensial database Anda

if ($conn->connect_error) {
    die("Koneksi gagal: " . $conn->connect_error);
}

// Ambil data organisasi berdasarkan id_akun
$sql = "SELECT * FROM Organisasi WHERE id_akun = $id_akun";
$result = $conn->query($sql);
$organisasi = $result->fetch_assoc();
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Form Organisasi</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f5f5f5;
            padding: 20px;
        }
        h2 {
            text-align: center;
            color: #333;
        }
        form {
            background-color: #fff;
            padding: 20px;
            max-width: 600px;
            margin: 0 auto;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            border-radius: 8px;
        }
        label {
            font-weight: bold;
            margin-top: 10px;
            display: block;
            color: #555;
        }
        input[type="text"], input[type="email"] {
            width: 100%;
            padding: 10px;
            margin-top: 5px;
            margin-bottom: 15px;
            border: 1px solid #ccc;
            border-radius: 5px;
            box-sizing: border-box;
        }
        input[type="submit"] {
            background-color: #4CAF50;
            color: white;
            padding: 10px 20px;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            font-size: 16px;
            margin-top: 10px;
        }
        input[type="submit"]:hover {
            background-color: #45a049;
        }
        .form-group {
            display: flex;
            flex-direction: column;
        }
        @media (min-width: 768px) {
            .form-group {
                flex-direction: row;
                justify-content: space-between;
            }
            .form-group label {
                flex: 1;
                margin-right: 10px;
            }
            .form-group input {
                flex: 2;
            }
        }
    </style>
</head>
<body>
    <h2>Form Organisasi</h2>
    <form action="update_organisasi.php" method="post">
        <input type="hidden" name="id_akun" value="<?php echo $id_akun; ?>">

        <div class="form-group">
            <label for="unit_eselon1">Unit Eselon 1:</label>
            <input type="text" name="unit_eselon1" value="<?php echo $organisasi['unit_eselon1'] ?? ''; ?>" required>
        </div>

        <div class="form-group">
            <label for="nama_organisasi">Nama Organisasi:</label>
            <input type="text" name="nama_organisasi" value="<?php echo $organisasi['nama_organisasi'] ?? ''; ?>" required>
        </div>

        <div class="form-group">
            <label for="alamat">Alamat:</label>
            <input type="text" name="alamat" value="<?php echo $organisasi['alamat'] ?? ''; ?>">
        </div>

        <div class="form-group">
            <label for="email_badan">Email Badan:</label>
            <input type="email" name="email_badan" value="<?php echo $organisasi['email_badan'] ?? ''; ?>">
        </div>

        <div class="form-group">
            <label for="no_telp_fax">No. Telp/Fax:</label>
            <input type="text" name="no_telp_fax" value="<?php echo $organisasi['no_telp_fax'] ?? ''; ?>">
        </div>

        <div class="form-group">
            <label for="nip_responden">NIP Responden:</label>
            <input type="text" name="nip_responden" value="<?php echo $organisasi['nip_responden'] ?? ''; ?>" required>
        </div>

        <div class="form-group">
            <label for="nama_responden">Nama Responden:</label>
            <input type="text" name="nama_responden" value="<?php echo $organisasi['nama_responden'] ?? ''; ?>" required>
        </div>

        <input type="submit" value="Simpan">
    </form>
</body>
</html>

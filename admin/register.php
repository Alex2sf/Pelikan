<?php
session_start();
if (!isset($_SESSION['role']) || $_SESSION['role'] !== 'admin') {
    // Jika bukan admin, arahkan ke halaman login
    header("Location: admin_login.php");
    exit();
}

$conn = new mysqli('localhost', 'root', '', 'emone'); // Ganti dengan kredensial database Anda

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = $_POST['username'];
    $password = md5($_POST['password']); // Enkripsi MD5
    $role = $_POST['role'];

    // Query untuk menambahkan akun baru
    $sql = "INSERT INTO Akun_Login (username, password, role) VALUES ('$username', '$password', '$role')";

    if ($conn->query($sql) === TRUE) {
        $id_akun = $conn->insert_id; // Dapatkan id_akun dari akun yang baru saja didaftarkan

        if ($role === 'penilai') {
            $nip = $_POST['nip'] ?? null;
            $nama_penilai = $_POST['nama_penilai'] ?? null;

            $sql_penilai = "INSERT INTO Profile_Penilai     (id_akun, nip, nama_penilai) VALUES ('$id_akun', '$nip', '$nama_penilai')";
            if ($conn->query($sql_penilai) === TRUE) {
                echo "Penilai berhasil didaftarkan!";
            } else {
                echo "Error: " . $sql_penilai . "<br>" . $conn->error;
            }
        } else {
            $unit_eselon1 = $_POST['unit_eselon1'] ?? null;
            $nama_organisasi = $_POST['nama_organisasi'] ?? null;
            $alamat = $_POST['alamat'] ?? null;
            $email_badan = $_POST['email_badan'] ?? null;
            $no_telp_fax = $_POST['no_telp_fax'] ?? null;
            $nip_responden = $_POST['nip_responden'] ?? null;
            $nama_responden = $_POST['nama_responden'] ?? null;
            $nilai_kategori1 = 0; // Nilai default untuk kategori
            $nilai_kategori2 = 0;
            $nilai_kategori3 = 0;
            $nilai_kategori4 = 0;
            $nilai_kategori5 = 0;
            $nilai_kategori6 = 0;

            $sql_organisasi = "INSERT INTO Organisasi (id_akun, unit_eselon1, nama_organisasi, alamat, email_badan, no_telp_fax, nip_responden, nama_responden, nilai_kategori1, nilai_kategori2, nilai_kategori3, nilai_kategori4, nilai_kategori5, nilai_kategori6) VALUES ('$id_akun', '$unit_eselon1', '$nama_organisasi', '$alamat', '$email_badan', '$no_telp_fax', '$nip_responden', '$nama_responden', '$nilai_kategori1', '$nilai_kategori2', '$nilai_kategori3', '$nilai_kategori4', '$nilai_kategori5', '$nilai_kategori6')";

            if ($conn->query($sql_organisasi) === TRUE) {
                echo "User berhasil didaftarkan dan Organisasi berhasil ditambahkan!";
            } else {
                echo "Error: " . $sql_organisasi . "<br>" . $conn->error;
            }
        }
    } else {
        echo "Error: " . $sql . "<br>" . $conn->error;
    }
}
?>


<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Register User atau Penilai</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f4;
            margin: 0;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
        }
        .container {
            background-color: white;
            padding: 20px;
            border-radius: 10px;
            box-shadow: 0 0 15px rgba(0, 0, 0, 0.1);
            width: 100%;
            max-width: 400px;
        }
        h2 {
            text-align: center;
            color: #333;
        }
        label {
            display: block;
            font-weight: bold;
            margin-bottom: 5px;
        }
        input[type="text"], input[type="password"], select {
            width: 100%;
            padding: 10px;
            margin-bottom: 15px;
            border: 1px solid #ccc;
            border-radius: 5px;
        }
        input[type="submit"] {
            width: 100%;
            padding: 10px;
            background-color: #28a745;
            border: none;
            border-radius: 5px;
            color: white;
            font-size: 16px;
            cursor: pointer;
        }
        input[type="submit"]:hover {
            background-color: #218838;
        }
        #penilai-details, #organisasi-details {
            display: none;
        }
    </style>
</head>
<body>
    <div class="container">
        <h2>Register User atau Penilai</h2>
        <form method="post" action="">
            <label>Username:</label>
            <input type="text" name="username" required>

            <label>Password:</label>
            <input type="password" name="password" required>

            <label>Role:</label>
            <select name="role" required>
                <option value="user">User</option>
                <option value="penilai">Penilai</option>
            </select>

            <!-- Detail untuk Penilai -->
            <div id="penilai-details">
                <label>NIP Penilai:</label>
                <input type="text" name="nip">

                <label>Nama Penilai:</label>
                <input type="text" name="nama_penilai">
            </div>

            <!-- Detail untuk Organisasi -->
            <div id="organisasi-details">
                <label>Unit Eselon 1:</label>
                <input type="text" name="unit_eselon1">

                <label>Nama Organisasi:</label>
                <input type="text" name="nama_organisasi">

                <label>Alamat:</label>
                <input type="text" name="alamat">

                <label>Email Badan:</label>
                <input type="email" name="email_badan">

                <label>No. Telp / Fax:</label>
                <input type="text" name="no_telp_fax">

                <label>NIP Responden:</label>
                <input type="text" name="nip_responden">

                <label>Nama Responden:</label>
                <input type="text" name="nama_responden">
            </div>

            <input type="submit" value="Register">
        </form>
    </div>

    <script>
        // Script untuk menampilkan input berdasarkan peran yang dipilih
        document.querySelector('select[name="role"]').addEventListener('change', function() {
            if (this.value === 'penilai') {
                document.getElementById('penilai-details').style.display = 'block';
                document.getElementById('organisasi-details').style.display = 'none';
            } else {
                document.getElementById('penilai-details').style.display = 'none';
                document.getElementById('organisasi-details').style.display = 'block';
            }
        });
    </script>
</body>
</html>

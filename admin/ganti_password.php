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

// Mengambil semua akun untuk ditampilkan di dropdown
$sql = "SELECT id_akun, username FROM Akun_Login";
$result = $conn->query($sql);
$akun_options = "";
if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $akun_options .= "<option value='" . $row['id_akun'] . "'>" . $row['username'] . "</option>";
    }
}

// Memproses input form untuk mengganti password
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $id_akun = $_POST['id_akun'];
    $password_baru = $_POST['password_baru'];
    $konfirmasi_password = $_POST['konfirmasi_password'];

    // Cek apakah password baru dan konfirmasi password sama
    if ($password_baru == $konfirmasi_password) {
        // Update password di database
        $sql_update = "UPDATE Akun_Login SET password='$password_baru' WHERE id_akun='$id_akun'";
        if ($conn->query($sql_update) === TRUE) {
            echo "<p style='color: green;'>Password berhasil diubah untuk akun ID: $id_akun.</p>";
        } else {
            echo "<p style='color: red;'>Error: " . $conn->error . "</p>";
        }
    } else {
        echo "<p style='color: red;'>Password baru dan konfirmasi password tidak sama.</p>";
    }
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Ganti Password - Admin</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f4;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            margin: 0;
        }
        .form-container {
            background-color: #fff;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            width: 300px;
        }
        h2 {
            text-align: center;
            margin-bottom: 20px;
            font-size: 24px;
            color: #333;
        }
        label {
            font-size: 14px;
            color: #333;
        }
        select, input[type="password"] {
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
    <div class="form-container">
        <h2>Ganti Password</h2>
        <form method="post" action="">
            <label for="id_akun">Pilih Akun:</label>
            <select name="id_akun" id="id_akun" required>
                <?php echo $akun_options; ?>
            </select><br>
            
            <label for="password_baru">Password Baru:</label>
            <input type="password" name="password_baru" id="password_baru" required><br>
            
            <label for="konfirmasi_password">Konfirmasi Password Baru:</label>
            <input type="password" name="konfirmasi_password" id="konfirmasi_password" required><br>
            
            <input type="submit" value="Ganti Password">
        </form>
    </div>
</body>
</html>

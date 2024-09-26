<?php
session_start();
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = $_POST['username'];
    $password = md5($_POST['password']); // Enkripsi MD5

    // Koneksi ke database
    $conn = new mysqli('localhost', 'root', '', 'sigh'); // Ganti dengan kredensial database Anda
    if ($conn->connect_error) {
        die("Koneksi gagal: " . $conn->connect_error); // Tampilkan pesan jika koneksi gagal
    }

    // Periksa kredensial
    $sql = "SELECT id_akun, role FROM Akun_Login WHERE username='$username' AND password='$password' AND role='penilai'";
    
    // Debug query
    echo "Query: $sql<br>";

    $result = $conn->query($sql);

    if (!$result) {
        die("Query gagal: " . $conn->error); // Tampilkan pesan jika query gagal
    }

    if ($result->num_rows > 0) {
        echo "Data ditemukan di database.<br>"; // Debug: Data ditemukan
        $row = $result->fetch_assoc();
        $_SESSION['id_akun'] = $row['id_akun'];
        $_SESSION['role'] = $row['role'];
        header("Location: list_organisasi.php"); // Arahkan ke halaman dashboard penilai
        exit();
    } else {
        echo "<p style='color: red;'>Username atau password salah.</p>";
        echo "Tidak ada data yang cocok ditemukan di database.<br>"; // Debug: Tidak ada data
    }

    // Tutup koneksi
    $conn->close();
}
?>


<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login Penilai</title>
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
        .login-container {
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
        input[type="text"],
        input[type="password"] {
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
        .error-message {
            color: red;
            font-size: 14px;
            text-align: center;
        }
    </style>
</head>
<body>
    <div class="login-container">
        <h2>Login Penilai</h2>
        <form method="post" action="login_penilai.php">
            <label for="username">Username:</label>
            <input type="text" name="username" id="username" required><br>
            
            <label for="password">Password:</label>
            <input type="password" name="password" id="password" required><br>
            
            <input type="submit" value="Login">
        </form>
    </div>
</body>
</html>

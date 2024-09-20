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
        header("Location: penilai_beranda.php"); // Arahkan ke halaman dashboard penilai
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
            background-image: url(img/KKP.jpg);
            background-size: cover;
            background-repeat: no-repeat;
            background-position: center center;
            background-attachment: fixed;
            font-family: Arial, sans-serif;
            display: flex;
            align-items: center;
            justify-content: center;
            height: 100vh;
            margin: 0;
        }
        .login-container {
            background-color: rgba(69, 53, 193, 0.8);
            padding: 30px;
            border-radius: 10px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2);
            width: 100%;
            max-width: 500px;
            max-height: 90vh;
            overflow-y: auto;
            color: #ffffff;
        }
        h2 {
            text-align: center;
            color: #ffffff;
            margin-bottom: 20px;
        }
        label {
            display: block;
            font-weight: 600;
            margin-bottom: 8px;
            color: #333;
        }
        input[type="text"], input[type="password"], select, input[type="email"] {
            width: 100%;
            padding: 12px;
            margin-bottom: 20px;
            border: 1px solid #ddd;
            border-radius: 5px;
            box-sizing: border-box;
            color: #333;
            font-size: 16px;
        }
        input[type="submit"] {
            width: 100%;
            padding: 15px;
            background-color: #4535C1;
            border: none;
            border-radius: 5px;
            color: #ffffff;
            font-size: 18px;
            cursor: pointer;
            transition: background-color 0.3s ease;
        }
        input[type="submit"]:hover {
            background-color: #2f2a8a;
        }
        #penilai-details, #organisasi-details {
            display: none;
        }

        /* Custom styles for the modal */
        .modal-header {
            background-color: #4535C1;
            color: white;
        }
        .modal-footer {
            background-color: #f1f1f1;
        }
        .modal-title {
            font-size: 1.5rem;
            font-weight: bold;
        }
        .modal-body {
            font-size: 1rem;
        }
        .btn-close {
            filter: invert(1);
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

<?php
session_start();
$conn = new mysqli('localhost', 'root', '', 'emone'); // Ganti dengan kredensial database Anda

if ($conn->connect_error) {
    die("Koneksi gagal: " . $conn->connect_error);
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = $_POST['username'];
    $password = $_POST['password'];

    // Query untuk mendapatkan data admin dari database
    $sql = "SELECT * FROM Akun_Login WHERE username = '$username' AND role = 'admin'";
    $result = $conn->query($sql);

    if ($result->num_rows == 1) {
        $row = $result->fetch_assoc();
        // Verifikasi password
        if ($password === $row['password']) { // Gunakan password_verify jika password sudah di-hash
            $_SESSION['id_akun'] = $row['id_akun'];
            $_SESSION['role'] = $row['role'];
            // Jika login berhasil, arahkan ke register.php
            header("Location: admin_dashboard.php");
            exit();
        } else {
            $error = "Password salah.";
        }
    } else {
        $error = "Username tidak ditemukan atau bukan admin.";
    }
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login Admin</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-image: url(img/KKP.jpg);
            background-size: cover;
            background-repeat: no-repeat;
            background-position: center center;
            background-attachment: fixed;
            display: flex;
            align-items: center;
            justify-content: center;
            height: 100vh;
            margin: 0;
        }
        .login-container {
            background-color: rgba(69, 53, 193, 0.8); /* Gunakan rgba untuk opacity pada warna latar belakang */
            padding: 30px;
            border-radius: 10px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2);
            width: 100%;
            max-width: 400px; /* Batasi lebar maksimum */
            max-height: 90vh; /* Batasi tinggi maksimum container */
            overflow-y: auto; /* Tambahkan scrollbar vertikal jika diperlukan */
        }
        h2 {
            text-align: center;
            color: #ffffff; /* Sesuaikan dengan warna utama */
            margin-bottom: 20px;
        }
        label {
            display: block;
            font-weight: 600;
            margin-bottom: 8px;
            color: #ffffff; /* Warna teks label sesuai tema */
        }
        input[type="text"], input[type="password"] {
            width: 100%;
            padding: 12px;
            margin-bottom: 20px;
            border: 1px solid #ddd;
            border-radius: 5px;
            box-sizing: border-box;
            color: #333; /* Warna teks dalam input */
            font-size: 16px;
        }
        input[type="submit"] {
            width: 100%;
            padding: 15px;
            background-color: #4535C1; /* Warna tombol sesuai tema */
            border: none;
            border-radius: 5px;
            color: #ffffff; /* Teks tombol putih */
            font-size: 18px;
            cursor: pointer;
            transition: background-color 0.3s ease;
        }
        input[type="submit"]:hover {
            background-color: #2f2a8a; /* Warna latar belakang saat hover */
        }
        .error-message {
        color: #ff4d4d; /* Red color to indicate error */
        background-color: #ffe6e6; /* Light red background for better visibility */
        padding: 10px;
        border-radius: 5px;
        text-align: center;
        margin-bottom: 20px;
        display: none; /* Initially hidden */
    }

    </style>
</head>

<body>

<div class="login-container">
    <h2>Login Admin</h2>
    <?php if(isset($error)): ?>
        <p class="error-message"><?php echo $error; ?></p>
    <?php endif; ?>
    <form method="post" action="admin_login.php">
        <label>Username:</label>
        <input type="text" name="username" required>

        <label>Password:</label>
        <input type="password" name="password" required>

        <input type="submit" value="Login">
    </form>
</div>

</body>
</html>

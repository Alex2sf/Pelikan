<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Landing Page</title>
    <style>
        /* Reset default styles */
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            font-family: Arial, sans-serif;
        }

        body {
            background-color: #f4f4f4;
            color: #333;
            line-height: 1.6;
        }

        /* Navbar styles */
        .navbar {
            background-color: #333;
            padding: 10px 20px;
            color: #fff;
        }

        .navbar .container {
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        .navbar .logo {
            color: #fff;
            font-size: 24px;
            text-decoration: none;
        }

        .navbar .nav-links {
            list-style: none;
            display: flex;
        }

        .navbar .nav-links li {
            margin-left: 20px;
        }

        .navbar .nav-links a {
            color: #fff;
            text-decoration: none;
            font-size: 18px;
        }

        .navbar .nav-links a:hover {
            text-decoration: underline;
        }

        /* Content styles */
        .content {
            padding: 40px 20px;
            max-width: 1000px;
            margin: auto;
        }

        .content section {
            margin-bottom: 40px;
            background-color: #fff;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        }

        .content h2 {
            color: #333;
            margin-bottom: 10px;
        }

        .content p {
            font-size: 16px;
            color: #666;
            margin-bottom: 20px;
        }

        .content img {
            max-width: 100%;
            height: auto;
            border-radius: 8px;
            margin-bottom: 20px;
        }

        .btn {
            display: inline-block;
            background-color: #333;
            color: #fff;
            padding: 10px 20px;
            border-radius: 5px;
            text-decoration: none;
            font-size: 16px;
        }

        .btn:hover {
            background-color: #555;
        }

        /* Footer styles */
        footer {
            background-color: #333;
            color: #fff;
            text-align: center;
            padding: 10px 0;
            position: fixed;
            bottom: 0;
            width: 100%;
        }
    </style>
</head>
<body>
    <!-- Navbar -->
    <nav class="navbar">
        <div class="container">
            <a href="#" class="logo">Admin Dashboard</a>
            <ul class="nav-links">
                <li><a href="register.php">Daftar Akun</a></li>
                <li><a href="akses_penilai.php">Akses Penilai</a></li>
                <li><a href="tambah_kuesioner.php">Kuesioner</a></li>
                <li><a href="akses_admin.php">Akses UPT</a></li>

            </ul>
        </div>
    </nav>

    <!-- Main Content -->
    <div class="content">
        <!-- Daftar Akun Section -->
        <section id="daftar-akun">
            <h2>Daftar Akun</h2>
            <img src="https://via.placeholder.com/800x400" alt="Daftar Akun Image">
            <p>Halaman ini memungkinkan admin untuk mengelola semua akun pengguna yang terdaftar dalam sistem. Anda dapat menambah, mengedit, dan menghapus akun sesuai kebutuhan.</p>
            <a href="#" class="btn">Kelola Akun</a>
        </section>

        <!-- Akses Penilai Section -->
        <section id="akses-penilai">
            <h2>Akses Penilai</h2>
            <img src="https://via.placeholder.com/800x400" alt="Akses Penilai Image">
            <p>Di sini, Anda dapat mengatur hak akses untuk penilai dan mengelola proses verifikasi kuesioner. Fitur ini memastikan bahwa hanya pengguna yang berwenang yang dapat mengakses informasi sensitif.</p>
            <a href="#" class="btn">Atur Akses Penilai</a>
        </section>

        <!-- Kuesioner Section -->
        <section id="kuesioner">
            <h2>Kuesioner</h2>
            <img src="https://via.placeholder.com/800x400" alt="Kuesioner Image">
            <p>Halaman ini memungkinkan admin untuk melihat dan mengelola semua kuesioner yang telah diisi oleh pengguna. Anda dapat meninjau hasil kuesioner, mengedit, atau menghapus kuesioner sesuai kebutuhan.</p>
            <a href="#" class="btn">Kelola Kuesioner</a>
        </section>
    </div>

    <!-- Footer -->
    <footer>
        <p>&copy; 2024 Admin Dashboard. All rights reserved.</p>
    </footer>
</body>
</html>



<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Landing Page Kementerian Kelautan dan Perikanan</title>
    <!-- Tambahkan CSS Bootstrap untuk desain yang lebih baik -->
    <link href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            font-family: Arial, sans-serif;
        }
        .navbar {
            margin-bottom: 30px;
        }
        .jumbotron {
            background-color: #0056b3;
            color: white;
        }
        .content-section {
            padding: 30px 0;
        }
        footer {
            background-color: #f8f9fa;
            padding: 20px 0;
            text-align: center;
        }
    </style>
</head>
<body>
    <!-- Navbar -->
    <nav class="navbar navbar-expand-lg navbar-dark bg-dark">
        <a class="navbar-brand" href="#">Kementerian Kelautan dan Perikanan</a>
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarNav">
            <ul class="navbar-nav ml-auto">
                <li class="nav-item">
                    <a class="nav-link" href="kuesioner.php">Kuesioner</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="form_organisasi.php">Profile</a>
                </li>
            </ul>
        </div>
    </nav>

    <!-- Jumbotron -->
    <div class="jumbotron text-center">
        <h1>Selamat Datang di Kementerian Kelautan dan Perikanan</h1>
        <p>Bersama Kita Menjaga dan Memanfaatkan Laut untuk Kesejahteraan Bangsa</p>
    </div>

    <!-- Section Kuesioner -->
    <section id="kuesioner" class="content-section text-center">
        <div class="container">
            <h2>Kuesioner</h2>
            <p>Silakan isi kuesioner untuk memberikan masukan terkait pelayanan dan kebijakan kami.</p>
            <a href="kuesioner.php" class="btn btn-primary">Isi Kuesioner</a>
        </div>
    </section>

    <!-- Section Profile -->
    <section id="profile" class="content-section text-center bg-light">
        <div class="container">
            <h2>Profile</h2>
            <p>Kementerian Kelautan dan Perikanan bertugas mengelola sumber daya kelautan dan perikanan secara berkelanjutan untuk kesejahteraan masyarakat.</p>
            <a href="profile.php" class="btn btn-secondary">Lihat Profile</a>
        </div>
    </section>

    <!-- Footer -->
    <footer>
        <div class="container">
            <p>&copy; 2024 Kementerian Kelautan dan Perikanan. All Rights Reserved.</p>
        </div>
    </footer>

    <!-- Tambahkan JS Bootstrap untuk interaktivitas -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>
</html>

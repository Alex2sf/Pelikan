<?php
// Database connection (update with your own connection details)
ob_start();
session_start();
include '../koneksi.php';


// Handle form submissions for deletion
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['delete'])) {
    $delete_id = $_POST['delete_id'];

    // Hapus data dari tabel 'kuesioner' terlebih dahulu
    $stmt = $conn->prepare("DELETE FROM kuesioner WHERE id_pertanyaan = ?");
    $stmt->bind_param("i", $delete_id);
    $stmt->execute();
    $stmt->close();

    // Hapus data dari tabel 'Pertanyaan'
    $stmt = $conn->prepare("DELETE FROM pertanyaan WHERE id_pertanyaan = ?");
    $stmt->bind_param("i", $delete_id);

    if ($stmt->execute()) {
        echo "Pertanyaan berhasil dihapus!";
    } else {
        echo "Error: " . $stmt->error;
    }

    $stmt->close();

    header("Location: adminrud_kuesioner.php");
    exit;
}

// Fetch options for dropdowns for editing
$kategori_options = $conn->query("SELECT id_kategori, kategori FROM Kategori");
$subkategori1_options = $conn->query("SELECT id_subkategori1, subkategori1 FROM SubKategori1");
$subkategori2_options = $conn->query("SELECT id_subkategori2, subkategori2 FROM SubKategori2");
$subkategori3_options = $conn->query("SELECT id_subkategori3, subkategori3 FROM SubKategori3");

// Handle form submissions for updates
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['update'])) {
    $id = $_POST['id'];
    $pertanyaan = $_POST['pertanyaan'];
    $id_kategori = $_POST['id_kategori'];
    $id_subkategori1 = $_POST['id_subkategori1'];
    $id_subkategori2 = $_POST['id_subkategori2'];
    $id_subkategori3 = $_POST['id_subkategori3'];
    $bobot = $_POST['bobot'];
    $web = isset($_POST['web']) && !empty($_POST['web']) ? $_POST['web'] : null;

    // Siapkan statement untuk pembaruan data
    $stmt = $conn->prepare("UPDATE pertanyaan SET pertanyaan = ?, id_kategori = ?, id_subkategori1 = ?, id_subkategori2 = ?, id_subkategori3 = ?, bobot = ?, web = ? WHERE id_pertanyaan = ?");
    $stmt->bind_param("siiiidsi", $pertanyaan, $id_kategori, $id_subkategori1, $id_subkategori2, $id_subkategori3, $bobot, $web, $id);

    // Eksekusi statement
    if ($stmt->execute()) {
        echo "Data berhasil diperbarui!";
    } else {
        echo "Error: " . $stmt->error;
    }
    $stmt->close();

    // Redirect setelah update
    header("Location: adminrud_kuesioner.php");
    exit;
}

// Fetch the question data to edit if an ID is provided
if (isset($_GET['id'])) {
    $id = $_GET['id'];
    $stmt = $conn->prepare("SELECT * FROM Pertanyaan WHERE id_pertanyaan = ?");
    $stmt->bind_param("i", $id);
    $stmt->execute();
    $result = $stmt->get_result();
    $questionData = $result->fetch_assoc();
    $stmt->close();
?>

<?php
ob_start();
session_start();
if (!isset($_SESSION['role']) || $_SESSION['role'] !== 'admin') {
    header("Location: admin_login.php");
    exit();
}

$username = isset($_SESSION['username']) ? $_SESSION['username'] : '';
$username1 = 'admin';
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Kuesioner</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" rel="stylesheet">
    <link href="../css/bootstrap.min.css" rel="stylesheet">
    <link href="../css/pelikan.css" type="text/css" rel="stylesheet">
    <style>
         body {
        
        }
       
        .title-container {
            margin-top: 50px; /* Jarak dari atas halaman */
            padding: 20px;
            background-color: #ffffff; /* Latar belakang putih untuk judul */
            box-shadow: 0px 4px 8px rgba(0, 0, 0, 0.1); /* Efek bayangan */
            border-radius: 10px; /* Sudut membulat */
        }
        h1 {
            font-family: 'Arial', sans-serif; /* Jenis huruf */
            font-size: 36px; /* Ukuran huruf besar */
            font-weight: bold; /* Tebal huruf */
            color: #343a40; /* Warna teks abu-abu gelap */
            text-transform: uppercase; /* Teks kapital semua */
            letter-spacing: 2px; /* Jarak antar huruf */
            text-shadow: 2px 2px 4px rgb(69, 53, 193); /* Efek bayangan teks sesuai permintaan */
        }
    </style>
</head>
<body>
<nav class="navbar navbar-expand-lg bg-body-tertiary fixed-top" style="border-bottom: 2px solid #4535C1; height: 60px;">

            <div class="container-fluid fs-5">
                <a class="navbar-brand fs-5" href="#" style="padding-left:60px; padding-top:-10px">
                    <img src="../img/pelikanlogo.png" alt="Logo" width="60" class="d-inline-block align-text-top">
                </a>
                <div>Admin</div>
                <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                    <span class="navbar-toggler-icon"></span>
                </button>
                <div class="collapse navbar-collapse" id="navbarNav" style="padding-right:60px;">
                    <ul class="nav nav-tabs ms-auto">
                        <li class="nav-item px-2">
                            <a class="nav-link black" aria-current="page" href="admin_dashboard.php">Beranda</a>
                        </li>
                        <li class="nav-item px-2">
                            <a class="nav-link black" href="register.php">Daftar Akun</a>
                        </li>
                        <li class="nav-item dropdown">
                            <a class="nav-link dropdown-toggle active" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                                Kuesioner
                            </a>
                            <ul class="dropdown-menu">
                                <li><a class="dropdown-item" href="add_data.php">Tambah Kuesioner</a></li>
                                <li><a class="dropdown-item" href="adminrud_kuesioner.php">Edit Kuisoner</a></li>
    
                            </ul>
                        </li>
                        
                         <!-- Dropdown Akses -->
                         <li class="nav-item dropdown">
                            <a class="nav-link dropdown-toggle black" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                                Akses
                            </a>
                            <ul class="dropdown-menu">
                                <li><a class="dropdown-item" href="admin_akses.php">Akses UNOR</a></li>
                                <li><a class="dropdown-item" href="akses_penilai.php">Akses Penilai</a></li>
                            </ul>
                        </li>
                        <li class="nav-item px-2">
                            <a class="nav-link black" href="Daftar.php">List UNOR</a>
                        </li>
                        <?php
                        if ($username==$username1){
                            echo '<li class="nav-item">
                            <a class="nav-link black" href="login.php">Login</a>
                            </li>';
                        }else{
                            echo '<li class="nav-item dropdown">
                            <a class="nav-link dropdown-toggle black" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                                Profile
                            </a>
                            <ul class="dropdown-menu">
                                <li><a class="dropdown-item" href="profile.php">My Profile</a></li>
                                <li><a class="dropdown-item" id="logout" href="#" data-bs-toggle="modal" data-bs-target="#modalLogout">Logout</a></li>
                            </ul>
                            </li>';
                        }
                        ?>
                    </ul>
                </div>
            </div>
        </nav>

    <div class="container mt-5" class="d-flex justify-content-start align-items-center" class="d-inline-flex">
    <div class="container">
        <!-- Bagian untuk menampilkan judul di tengah -->
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-auto title-container">
                <h1 class="text-center">Edit Kuesioner</h1>
            </div>
        </div>
       
        </table>

        <div class="container mt-5">
    <h4>Edit Pertanyaan</h4>
    <form action="editkuesioner.php" method="post" enctype="multipart/form-data">
        <input type="hidden" name="id" value="<?php echo $questionData['id_pertanyaan']; ?>">

        <div class="mb-3">
            <label for="pertanyaan" class="form-label">Pertanyaan:</label>
            <input type="text" class="form-control" id="pertanyaan" name="pertanyaan" value="<?php echo $questionData['pertanyaan']; ?>" required>
        </div>

        <div class="mb-3">
            <label for="id_kategori" class="form-label">Kategori:</label>
            <select class="form-select" id="id_kategori" name="id_kategori" required>
                <?php while ($row = $kategori_options->fetch_assoc()) { ?>
                    <option value="<?php echo $row['id_kategori']; ?>" <?php if ($row['id_kategori'] == $questionData['id_kategori']) echo 'selected'; ?>>
                        <?php echo $row['kategori']; ?>
                    </option>
                <?php } ?>
            </select>
        </div>

        <div class="mb-3">
            <label for="id_subkategori1" class="form-label">SubKategori 1:</label>
            <select class="form-select" id="id_subkategori1" name="id_subkategori1" required>
                <?php while ($row = $subkategori1_options->fetch_assoc()) { ?>
                    <option value="<?php echo $row['id_subkategori1']; ?>" <?php if ($row['id_subkategori1'] == $questionData['id_subkategori1']) echo 'selected'; ?>>
                        <?php echo $row['subkategori1']; ?>
                    </option>
                <?php } ?>
            </select>
        </div>

        <div class="mb-3">
            <label for="id_subkategori2" class="form-label">SubKategori 2:</label>
            <select class="form-select" id="id_subkategori2" name="id_subkategori2" required>
                <?php while ($row = $subkategori2_options->fetch_assoc()) { ?>
                    <option value="<?php echo $row['id_subkategori2']; ?>" <?php if ($row['id_subkategori2'] == $questionData['id_subkategori2']) echo 'selected'; ?>>
                        <?php echo $row['subkategori2']; ?>
                    </option>
                <?php } ?>
            </select>
        </div>

        <div class="mb-3">
            <label for="id_subkategori3" class="form-label">SubKategori 3:</label>
            <select class="form-select" id="id_subkategori3" name="id_subkategori3" required>
                <?php while ($row = $subkategori3_options->fetch_assoc()) { ?>
                    <option value="<?php echo $row['id_subkategori3']; ?>" <?php if ($row['id_subkategori3'] == $questionData['id_subkategori3']) echo 'selected'; ?>>
                        <?php echo $row['subkategori3']; ?>
                    </option>
                <?php } ?>
            </select>
        </div>

        <div class="mb-3">
            <label for="bobot" class="form-label">Bobot:</label>
            <input type="number" class="form-control" id="bobot" name="bobot" step="0.01" value="<?php echo $questionData['bobot']; ?>" required>
        </div>

        <div class="mb-3">
            <label for="web" class="form-label">Website (optional):</label>
            <input type="text" class="form-control" id="web" name="web" value="<?php echo $questionData['web']; ?>" maxlength="255">
        </div>

        <button type="submit" name="update" class="btn btn-primary">Update Pertanyaan</button>
    </form>
</div>

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/5.3.0/js/bootstrap.bundle.min.js"></script>
</body>
</html>

<?php
} else {
    echo "<p>ID pertanyaan tidak ditemukan.</p>";
}

$conn->close();
?>
<?php
// Database connection (update with your own connection details)
ob_start();
session_start();
if (!isset($_SESSION['id_akun']) || $_SESSION['role'] != 'admin') {
    header("Location: admin_login.php");
    exit();
}
$username="";
$username1=$_SESSION["role"];
include '../koneksi.php';


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

    if (!empty($file_path)) {
        $stmt = $conn->prepare("UPDATE Pertanyaan SET pertanyaan = ?, id_kategori = ?, id_subkategori1 = ?, id_subkategori2 = ?, id_subkategori3 = ?, bobot = ?, web = ?, file_path = ? WHERE id_pertanyaan = ?");
        $stmt->bind_param("siiiiissi", $pertanyaan, $id_kategori, $id_subkategori1, $id_subkategori2, $id_subkategori3, $bobot, $web, $file_path, $id);
    } else {
        $stmt = $conn->prepare("UPDATE Pertanyaan SET pertanyaan = ?, id_kategori = ?, id_subkategori1 = ?, id_subkategori2 = ?, id_subkategori3 = ?, bobot = ?, web = ? WHERE id_pertanyaan = ?");
        $stmt->bind_param("siiiiiss", $pertanyaan, $id_kategori, $id_subkategori1, $id_subkategori2, $id_subkategori3, $bobot, $web, $id);
    }

    if ($stmt->execute()) {
        echo "Data berhasil diperbarui!";
    } else {
        echo "Error: " . $stmt->error;
    }
    $stmt->close();

    header("Location: adminrud_kuesioner.php");
    exit;
}

// Handle form submissions for deletion
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['delete'])) {
    $delete_id = $_POST['delete_id'];

    // Hapus data dari tabel 'kuesioner' terlebih dahulu
    $stmt = $conn->prepare("DELETE FROM kuesioner WHERE id_pertanyaan = ?");
    $stmt->bind_param("i", $delete_id);
    $stmt->execute();
    $stmt->close();

    // Hapus data dari tabel 'Pertanyaan'
    $stmt = $conn->prepare("DELETE FROM Pertanyaan WHERE id_pertanyaan = ?");
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

// Memeriksa apakah pengguna memilih kategori tertentu
$id_kategori = isset($_GET['id_kategori']) ? $_GET['id_kategori'] : '';

// Query untuk mengambil pertanyaan sesuai kategori yang dipilih
if ($id_kategori) {
    // Filter berdasarkan kategori yang dipilih
    $questions = $conn->query("
        SELECT p.*, k.kategori 
        FROM Pertanyaan p 
        LEFT JOIN Kategori k ON p.id_kategori = k.id_kategori
        WHERE p.id_kategori = '$id_kategori'
    ");
} else {
    // Jika tidak ada kategori yang dipilih, ambil semua pertanyaan
    $questions = $conn->query("
        SELECT p.*, k.kategori 
        FROM Pertanyaan p 
        LEFT JOIN Kategori k ON p.id_kategori = k.id_kategori
    ");
}
?>

<!-- Form Dropdown untuk memilih kategori -->
<form method="GET" action="">
    <label for="kategori">Pilih Kategori:</label>
    <select name="id_kategori" id="kategori" onchange="this.form.submit()">
        <option value="">Semua Kategori</option>
        <?php
        // Fetch all categories
        $categories = $conn->query("SELECT * FROM Kategori");

        // Loop through categories and create options
        while ($category = $categories->fetch_assoc()) { ?>
            <option value="<?php echo $category['id_kategori']; ?>"
                <?php if (isset($_GET['id_kategori']) && $_GET['id_kategori'] == $category['id_kategori']) echo 'selected'; ?>>
                <?php echo $category['kategori']; ?>
            </option>
        <?php } ?>
    </select>
</form>

<?php

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
    <script type="text/javascript" src="../js/bootstrap.js"></script>
    <script type="text/javascript" src="../js/bootstrap.min.js"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" rel="stylesheet">
    <link href="../css/bootstrap.min.css" rel="stylesheet">
    <link href="../css/pelikan.css" type="text/css" rel="stylesheet">
    <style>
         body {
           
            background-size: cover; /* Gambar akan menutupi seluruh background */
            background-position: center; /* Posisi gambar di tengah */
            background-repeat: no-repeat; /* Tidak mengulang gambar */
            background-attachment: fixed; /* Gambar tetap pada posisinya saat di-scroll */
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
          /* CSS untuk mengubah warna tulisan saat link aktif */
    .nav-link.active {
        color: white !important; /* Mengubah warna tulisan menjadi putih */
        background-color: #4535C1; /* Mengatur latar belakang jika aktif (ganti dengan warna yang diinginkan) */
    }
    
    /* CSS untuk mengatur warna default untuk link */
    .nav-link {
        color: black; /* Warna default untuk semua link */
    }
    
    /* CSS untuk logout */
    #logout {
        color: red; /* Warna merah untuk link logout */
    }
    </style>
</head>
<body>
<?php
    include('navbar.php');  // Include navbar.php
?>

    <div class="container mt-5" class="d-flex justify-content-start align-items-center" class="d-inline-flex">
    <div class="container">
        <!-- Bagian untuk menampilkan judul di tengah -->
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-auto title-container">
                <h1 class="text-center">Edit Kuesioner</h1>
            </div>
        </div>
        <form method="GET" action="">
    <label for="kategori">Pilih Kategori:</label>
    <select name="id_kategori" id="kategori" onchange="this.form.submit()">
        <option value="">Semua Kategori</option>
        <?php
        // Ambil semua kategori dari database
        $categories = $conn->query("SELECT * FROM Kategori");

        // Loop kategori untuk isi dropdown
        while ($category = $categories->fetch_assoc()) { ?>
            <option value="<?php echo $category['id_kategori']; ?>"
                <?php if (isset($_GET['id_kategori']) && $_GET['id_kategori'] == $category['id_kategori']) echo 'selected'; ?>>
                <?php echo $category['kategori']; ?>
            </option>
        <?php } ?>
    </select>
</form>

        <!-- Table to display all questions -->
        <h4>Semua Kuesioner</h4>
        <table class="table table-striped">
            <thead>
                <tr>
                    <th style="text-align: center; vertical-align: middle;">No</th>
                    <th style="text-align: center; vertical-align: middle;">Kategori</th>
                    <th style="text-align: center; vertical-align: middle;">Pertanyaan</th>
                    <th style="text-align: center; vertical-align: middle;">Aksi</th>
                </tr>
            </thead>
            <tbody>
                
                <?php 
                $no=1;
                while ($row = $questions->fetch_assoc()) { ?>
                    <tr>
                         <!-- Kolom Nomor Urut -->
                        <td><?php echo $no++; ?></td> <!-- $no akan bertambah setiap iterasi loop -->
                        
                        <!-- Menampilkan kategori -->
                        <td><?php echo $row['kategori']; ?></td>

                    
                        <!-- Menampilkan Pertanyaan -->
                        <td><?php echo $row['pertanyaan']; ?></td>

                        <!-- Kolom Aksi (Edit & Delete) --> 
                        <td style="vertical-align: middle;">
                           <!-- Tombol Edit dengan Ikon -->
                           <a href="editkuesioner.php?id=<?php echo $row['id_pertanyaan']; ?>" class="btn btn-warning me-2">
                            <i class="fas fa-edit"></i> <!-- Ikon Edit -->
                            </a>
                        
                        <!-- Tombol Delete dengan Ikon -->
                        <form action="adminrud_kuesioner.php" method="post" style="display:inline;">
                            <input type="hidden" name="delete_id" value="<?php echo $row['id_pertanyaan']; ?>">
                            <button type="submit" name="delete" class="btn btn-danger btn-space" onclick="return confirm('Anda yakin ingin menghapus pertanyaan ini?');">
                                <i class="fas fa-trash"></i> <!-- Ikon Delete -->
                            </button>
                            </form>
                        </td>
                        </tr>
                <?php } ?>
            </tbody>
        </table>

        <?php
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

        <!-- Form for editing a specific question -->
        <h4>Edit Pertanyaan</h4>
         <!-- Tombol Kembali -->
    <button class="btn btn-secondary mb-3" onclick="window.location.href='adminrud_kuesioner.php'">
        <i class="fas fa-arrow-left"></i> Kembali
    </button>
    </a>
        <form action="adminrud_kuesioner.php" method="post" enctype="multipart/form-data">
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
                <input type="number" class="form-control" id="bobot" name="bobot" value="<?php echo $questionData['bobot']; ?>" required>
            </div>

            <div class="mb-3">
                <label for="web" class="form-label">Website (optional):</label>
                <input type="text" class="form-control" id="web" name="web" value="<?php echo $questionData['web']; ?>" maxlength="255">
            </div>
            
            <button type="submit" name="update" class="btn btn-primary">Update Pertanyaan</button>
        </form>
        <?php } ?>

    </div>

    <!-- Modal Konfirmasi Logout -->
 <div class="modal fade" id="modalLogout" tabindex="-1" aria-labelledby="modalLogoutLabel" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="modalLogoutLabel">Konfirmasi Logout</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        Apakah Anda yakin ingin logout?
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                        <button type="button" class="btn btn-danger" id="confirmLogoutBtn">Logout</button>
                    </div>
                </div>
            </div>
        </div>

    <!-- Modal -->
   <!-- SweetAlert2 -->
     <!-- SweetAlert2 -->

      <!-- Script untuk menangani modal dan submit form -->
      <script type="text/javascript">
            document.getElementById("confirmLogoutBtn").addEventListener("click", function() {
                window.location.href = "logout.php"; // Redirect to the logout page
            });
        </script>
</body>
</html>

<?php
// Close the database connection
$conn->close();
?>

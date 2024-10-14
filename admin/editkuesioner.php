<?php
// Database connection (update with your own connection details)
ob_start();
session_start();
if (!isset($_SESSION['id_akun']) || $_SESSION['role'] != 'admin') {
    header("Location: admin_login.php");
    exit();
}include '../koneksi.php';


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
    <script type="text/javascript" src="../js/bootstrap.js"></script>
    <script type="text/javascript" src="../js/bootstrap.min.js"></script>
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
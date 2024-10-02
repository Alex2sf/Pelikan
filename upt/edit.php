<?php
// Database connection (update with your own connection details)
ob_start();
session_start();
$servername = "localhost";
$username = "root";
$password = "";
$database = "sigh";

$conn = new mysqli($servername, $username, $password, $database);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

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

// Fetch all questions
$questions = $conn->query("SELECT * FROM Pertanyaan");
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
    <title>Admin RUD Kuesioner</title>
    <link href="../css/bootstrap.min.css" rel="stylesheet">
    <link href="../css/pelikan.css" type="text/css" rel="stylesheet">
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
                                <li><a class="dropdown-item" href="admin_akses.php">Akses UPT</a></li>
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

    <div class="container mt-5">
        <h2>Admin RUD Kuesioner</h2>

        <!-- Table to display all questions -->
        <h4>Semua Kuesioner</h4>
        <table class="table table-striped">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Pertanyaan</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody>
                <?php while ($row = $questions->fetch_assoc()) { ?>
                    <tr>
                        <td><?php echo $row['id_pertanyaan']; ?></td>
                        <td><?php echo $row['pertanyaan']; ?></td>
                        <td>
                            <a class="btn btn-warning" aria-current="page" href="edit.php">edit</a>
                            <!-- <a href="adminrud_kuesioner.php?id=<?php echo $row['id_pertanyaan']; ?>" class="btn btn-warning">Edit</a> -->
                            
                            <!-- Tombol Delete -->
                            <form action="adminrud_kuesioner.php" method="post" style="display:inline;">
                                <input type="hidden" name="delete_id" value="<?php echo $row['id_pertanyaan']; ?>">
                                <button type="submit" name="delete" class="btn btn-danger" onclick="return confirm('Anda yakin ingin menghapus pertanyaan ini?');">Delete</button>
                            </form>

                            <!-- Tombol Download -->
                            <?php if (!empty($row['file_path'])) { ?>
                                <a href="<?php echo $row['file_path']; ?>" class="btn btn-success" download>Download</a>
                            <?php } else { ?>
                                <button class="btn btn-secondary" disabled>No Document</button>
                            <?php } ?>
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
</body>
</html>

<?php
// Close the database connection
$conn->close();
?>

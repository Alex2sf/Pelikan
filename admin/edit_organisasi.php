<?php
ob_start();
include '../koneksi.php';

session_start();
if (!isset($_SESSION['role']) || $_SESSION['role'] != 'admin') {
    die('Access denied. Only admins can access this page.');
}

if ($_SERVER['REQUEST_METHOD'] == 'GET' && isset($_GET['id_organisasi'])) {
    $id_organisasi = $_GET['id_organisasi'];

    // Fetch the organisasi data
    $query = $conn->prepare("SELECT nama_organisasi FROM organisasi WHERE id_organisasi = ?");
    $query->bind_param('i', $id_organisasi);
    $query->execute();
    $result = $query->get_result();
    $organisasi = $result->fetch_assoc();

    if (!$organisasi) {
        die('Organisasi not found');
    }
}

if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['id_organisasi']) && isset($_POST['nama_organisasi'])) {
    $id_organisasi = $_POST['id_organisasi'];
    $nama_organisasi = $_POST['nama_organisasi'];

    // Update the organisasi data
    $update_query = $conn->prepare("UPDATE organisasi SET nama_organisasi = ? WHERE id_organisasi = ?");
    $update_query->bind_param('si', $nama_organisasi, $id_organisasi);
    $update_query->execute();

    header('Location: admin_akses.php');
    exit;
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Organisasi</title>
    <link href="../css/bootstrap.min.css" type="text/css" rel="stylesheet">
</head>
<body>
    <div class="container">
        <h1>Edit Organisasi</h1>
        <form method="POST" action="">
            <input type="hidden" name="id_organisasi" value="<?php echo $id_organisasi; ?>">
            <div class="form-group">
                <label for="nama_organisasi">Nama Organisasi:</label>
                <input type="text" class="form-control" id="nama_organisasi" name="nama_organisasi" value="<?php echo $organisasi['nama_organisasi']; ?>">
            </div>
            <button type="submit" class="btn btn-primary">Save Changes</button>
        </form>
    </div>
</body>
</html>

<?php
$conn->close();
?>
<?php
$conn = new mysqli('localhost', 'root', '', 'sigh'); // Ganti dengan kredensial database Anda

// Cek koneksi database
if ($conn->connect_error) {
    die("Koneksi gagal: " . $conn->connect_error);
}

// Check if the user is an admin
session_start();
if (!isset($_SESSION['role']) || $_SESSION['role'] != 'admin') {
    die('Access denied. Only admins can access this page.');
}

// Fetch users and their organizations
$sql = "SELECT o.id_organisasi, o.nama_organisasi, a.username, u.status_kuesioner 
        FROM organisasi o 
        JOIN akun_login a ON o.id_akun = a.id_akun
        JOIN user_access_status u ON o.id_organisasi = u.id_organisasi";

$result = $conn->query($sql);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Access</title>
</head>
<body>

<h1>Manage User Access</h1>

<table border="1" style="border-collapse: collapse; width: 100%;">
    <thead>
        <tr>
            <th>Organization</th>
            <th>Username</th>
            <th>Status</th>
            <th>Action</th>
        </tr>
    </thead>
    <tbody>
        <?php while ($row = $result->fetch_assoc()) { ?>
        <tr>
            <td><?php echo $row['nama_organisasi']; ?></td>
            <td><?php echo $row['username']; ?></td>
            <td><?php echo $row['status_kuesioner'] == 1 ? 'Completed' : 'Not Completed'; ?></td>
            <td>
                <?php if ($row['status_kuesioner'] == 1) { ?>
                    <a href="grant_access.php?id_organisasi=<?php echo $row['id_organisasi']; ?>">Grant Access</a>
                <?php } else { ?>
                    <a href="revoke_access.php?id_organisasi=<?php echo $row['id_organisasi']; ?>">Revoke Access</a>
                <?php } ?>
            </td>
        </tr>
        <?php } ?>
    </tbody>
</table>

</body>
</html>

<?php
$conn->close();
?>

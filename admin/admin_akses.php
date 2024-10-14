<?php
ob_start();
include '../koneksi.php';

session_start();
if (!isset($_SESSION['role']) || $_SESSION['role'] != 'admin') {
    die('Access denied. Only admins can access this page.');
}
$username = "";
$username1 = $_SESSION["role"];
$modal_message = "";
$modal_type = "";

// Proses Grant Access
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['id_organisasi'])) {
    $id_organisasi = $_POST['id_organisasi'];
    
    // Update can_fill_out menjadi TRUE
    $update_query = $conn->prepare("UPDATE organisasi SET can_fill_out = TRUE WHERE id_organisasi = ?");
    $update_query->bind_param('i', $id_organisasi);
    if ($update_query->execute()) {
        $modal_message = "Access granted. User can now retake the questionnaire.";
        $modal_type = "success";
    } else {
        $modal_message = "Failed to grant access.";
        $modal_type = "error";
    }
}

// Ambil data users dan status mereka
$users_query = $conn->query("SELECT id_organisasi, nama_organisasi, can_fill_out FROM organisasi");
?>

<!DOCTYPE html>
<html lang="en">
    <head>
    <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Document</title>
        <script type="text/javascript" src="../js/bootstrap.js"></script>
        <script type="text/javascript" src="../js/bootstrap.min.js"></script>
        <link href="../css/bootstrap.min.css" type="text/css" rel="stylesheet">
        <link href="../css/pelikan.css" type="text/css" rel="stylesheet">
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
        <style>
        /* Styling untuk halaman admin akses */
body {
    font-family: Arial, sans-serif;
    background-image: url(img/KKP.jpg);
    background-size: cover;
    background-repeat: no-repeat;
    background-position: center center;
    background-attachment: fixed;
    margin: 0;
    margin-top: 120px;
    padding: 0;
}
footer {
                width: 100%;
                background-color: #4535C1;
                color: white;
                padding: 10px;
                position: fixed;
                bottom: 0;
                left: 0;
                text-align: center;
            }
.container {
    width: 100%;
    max-width: 1200px;
    margin: 50px auto;
    background-color: #fff;
    padding: 20px;
    border-radius: 8px;
    box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
}

h2,h1 {
    text-align: center;
    margin-bottom: 20px;
    font-size: 24px;
    color: #4535C1;
    font-weight: bold;
    text-transform: uppercase;
    text-shadow: 0 2px 4px rgba(0, 0, 0, 0.2); 
}

form {
    display: flex;
    flex-direction: column;
    gap: 15px;
}

label {
    font-size: 16px;
    color: #333;
}

select {
    padding: 10px;
    border: 1px solid #ccc;
    border-radius: 4px;
    background-color: #fff;
    font-size: 16px;
    color: #333;
}

table {
    width: 90%; /* Atur lebar tabel menjadi 90% dari kontainer */
    border-collapse: collapse;
    margin-top: 10px;
    margin-bottom: 20px;
    font-size: 16px;
    text-align: left;
    transition: all 0.3s ease;
    margin-left: auto;
    margin-right: auto; /* Mengatur agar tabel berada di tengah dengan jarak seimbang */
}


table, th, td {
    border: 1px solid #ddd;
}

th, td {
    padding: 12px 15px;
    border-bottom: 1px solid #ddd;
}

/* Header Styling */
th {
    background-color: #4535C1;
    color: white;
}

thead {
    background-color: #4535C1;
    color: white;
    font-weight: bold;
}

/* Alternating Row Colors */
tr:nth-child(even) {
    background-color: #f9f9f9;
}

/* Hover Effect: Glowing & More Light */


/* Hover Effect on Table Data */


td:first-child {
    color: #000000;
}

td a {
    color: #4535C1;
    text-decoration: none;
    font-weight: bold;
}

td a:hover {
    color: #2e24a3;
}

input[type="text"],
input[type="email"],
select {
    width: 100%;
    padding: 12px;
    margin-bottom: 20px;
    border: 1px solid rgba(255, 255, 255, 0.4); /* Light border */
    background: #ddd; /* Slightly transparent background */
    color: black;
    border-radius: 8px;
    font-size: 16px;
    outline: none;
    transition: border-color 0.3s ease, background-color 0.3s ease; /* Smooth interaction */
}

input[type="text"]:focus,
input[type="email"]:focus,
select:focus {
    border-color: #4535C1;
    background-color: rgba(255, 255, 255, 0.3); /* More solid on focus */
}

/* Submit Button with Futuristic Hover Effect */
input[type="submit"] {
    width: 100%;
    padding: 15px;
    background-color: #4535C1;
    border: none;
    border-radius: 5px;
    color: #ffffff;
    font-size: 18px;
    cursor: pointer;
    transition: background-color 0.3s ease, box-shadow 0.3s ease;
}

input[type="submit"]:hover {
    background-color: #5a47e4; /* Warna ungu yang lebih terang */
    box-shadow: 0 4px 12px rgba(0, 0, 0, 0.2); /* Menambahkan shadow */
}
/* Tombol Balik */
.btn-balik {
    margin-top: 20px;
    display: block;
    width: 100%;
    padding: 10px;
    text-align: center;
    background-color: #ccc;
    color: #333;
    border: none;
    border-radius: 4px;
    font-size: 16px;
    cursor: pointer;
    transition: background-color 0.3s ease;
}

.btn-balik:hover {
    background-color: #999;
}

    </style>
</head>

<body>
<?php
    include('navbar.php');  // Include navbar.php
?>
<!-- Halaman konten lainnya di sini -->

    <h1>Grant Questionnaire Access</h1>
    <table>
        <thead>
            <tr>
                <th>Nama Organisasi</th>
                <th>Status Pengisian</th>
                <th>Action</th>
            </tr>
        </thead>
        <tbody>
        <?php while ($user = $users_query->fetch_assoc()): ?>
        <tr>
            <td><?php echo htmlspecialchars($user['nama_organisasi']); ?></td>
            <td><?php echo $user['can_fill_out'] ? 'Dapat Mengisi' : 'Tidak Dapat Mengisi'; ?></td>
            <td>
                <?php if (!$user['can_fill_out']): ?>
                <form method="POST" action="">
                    <input type="hidden" name="id_organisasi" value="<?php echo $user['id_organisasi']; ?>">
                    <input type="submit" value="Grant Access">
                </form>
                <?php endif; ?>
            </td>
        </tr>
    <?php endwhile; ?>
        </tbody>
    </table>

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
 <!--Footer-->
 <footer>
        <div class="container-fluid text-center" style="color:white;">
            <div class="row">
                <div class="col">
            </div>  
                <div class="col-8">
                    ©2024 <a style="text-decoration: none; color:aquamarine">Kementerian Kelautan dan Perikanan</a>. All Rights Reserved
                </div>
                <div class="col">
                </div>
            </div>
        </div>
</footer>
  <!-- Script untuk menangani modal dan submit form -->
  <script type="text/javascript">
            document.getElementById("confirmLogoutBtn").addEventListener("click", function() {
                window.location.href = "logout.php"; // Redirect to the logout page
            });
        </script>

<?php if (!empty($modal_message)) { ?>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@10"></script>
    <script>
        Swal.fire({
            title: '<?php echo $modal_type == "success" ? "Success" : "Error"; ?>',
            text: '<?php echo $modal_message; ?>',
            icon: '<?php echo $modal_type == "success" ? "success" : "error"; ?>',
            confirmButtonText: 'OK'
        }).then((result) => {
            if (result.isConfirmed) {
                // Arahkan ke halaman beranda setelah OK diklik
                window.location.href = 'admin_dashboard.php';
            }
        });
    </script>
<?php } ?>

</body>
</html>

<?php
$conn->close();
?>

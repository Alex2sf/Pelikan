<?php
$conn = new mysqli('localhost', 'root', '', 'emone'); // Ganti dengan kredensial database Anda

$modal_message = '';
$modal_type = '';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = $_POST['username'];
    $password = md5($_POST['password']); // Enkripsi MD5
    $role = $_POST['role'];

    // Cek apakah username sudah ada
    $check_username = "SELECT * FROM Akun_Login WHERE username = '$username'";
    $result_username = $conn->query($check_username);

    if ($result_username->num_rows > 0) {
        $modal_message = 'Username sudah terpakai. Silakan gunakan username yang lain.';
        $modal_type = 'danger'; // Tipe modal untuk error
    } else {
        // Jika tidak ada username yang sama, lanjutkan proses registrasi
        $sql = "INSERT INTO Akun_Login (username, password, role) VALUES ('$username', '$password', '$role')";

        if ($conn->query($sql) === TRUE) {
            $id_akun = $conn->insert_id; // Dapatkan id_akun dari akun yang baru saja didaftarkan

            if ($role === 'penilai') {
                $nip = $_POST['nip'] ?? null;
                $nama_penilai = $_POST['nama_penilai'] ?? null;

                // Cek apakah NIP sudah ada di Profile_Penilai
                $check_nip = "SELECT * FROM Profile_Penilai WHERE nip = '$nip'";
                $result_nip = $conn->query($check_nip);

                if ($result_nip->num_rows > 0) {
                    $modal_message = 'NIP sudah terpakai. Silakan gunakan NIP yang lain.';
                    $modal_type = 'danger';
                } else {
                    $sql_penilai = "INSERT INTO Profile_Penilai (id_akun, nip, nama_penilai) VALUES ('$id_akun', '$nip', '$nama_penilai')";
                    if ($conn->query($sql_penilai) === TRUE) {
                        $modal_message = 'Penilai berhasil didaftarkan!';
                        $modal_type = 'success'; // Tipe modal untuk success
                    } else {
                        $modal_message = 'Error: ' . $sql_penilai . "<br>" . $conn->error;
                        $modal_type = 'danger';
                    }
                }
            } else {
                $unit_eselon1 = $_POST['unit_eselon1'] ?? null;
                $nama_organisasi = $_POST['nama_organisasi'] ?? null;
                $alamat = $_POST['alamat'] ?? null;
                $email_badan = $_POST['email_badan'] ?? null;
                $no_telp_fax = $_POST['no_telp_fax'] ?? null;
                $nip_responden = $_POST['nip_responden'] ?? null;
                $nama_responden = $_POST['nama_responden'] ?? null;

                $sql_organisasi = "INSERT INTO Organisasi (id_akun, unit_eselon1, nama_organisasi, alamat, email_badan, no_telp_fax, nip_responden, nama_responden) VALUES ('$id_akun', '$unit_eselon1', '$nama_organisasi', '$alamat', '$email_badan', '$no_telp_fax', '$nip_responden', '$nama_responden')";

                if ($conn->query($sql_organisasi) === TRUE) {
                    $modal_message = 'User berhasil didaftarkan dan Organisasi berhasil ditambahkan!';
                    $modal_type = 'success';
                } else {
                    $modal_message = 'Error: ' . $sql_organisasi . "<br>" . $conn->error;
                    $modal_type = 'danger';
                }
            }
        } else {
            $modal_message = 'Error: ' . $sql . "<br>" . $conn->error;
            $modal_type = 'danger';
        }
    }
}
?>


<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Register User atau Penilai</title>
    <link href="../css/bootstrap.min.css" type="text/css" rel="stylesheet">
    <link href="../css/pelikan.css" type="text/css" rel="stylesheet">
    <style>
 body {
            background-image: url(../img/KKP.jpg);
            background-size: cover;
            background-repeat: no-repeat;
            background-position: center center;
            background-attachment: fixed;
            font-family: Arial, sans-serif;
            display: flex;
            align-items: center;
            justify-content: center;
            height: 100vh;
            margin: 0;
        }
        .container {
            background-color: rgba(69, 53, 193, 0.8);
            padding: 30px;
            border-radius: 10px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2);
            width: 100%;
            max-width: 600px;
            max-height: 90vh;
            overflow-y: auto;
            color: #ffffff;
        }
        h2 {
            text-align: center;
            color: #ffffff;
            margin-bottom: 20px;
        }
        label {
            display: block;
            font-weight: 600;
            margin-bottom: 8px;
            color: #333;
        }
        input[type="text"], input[type="password"], select, input[type="email"] {
            width: 100%;
            padding: 12px;
            margin-bottom: 20px;
            border: 1px solid #ddd;
            border-radius: 5px;
            box-sizing: border-box;
            color: #333;
            font-size: 16px;
        }
        input[type="submit"] {
            width: 100%;
            padding: 15px;
            background-color: #4535C1;
            border: none;
            border-radius: 5px;
            color: #ffffff;
            font-size: 18px;
            cursor: pointer;
            transition: background-color 0.3s ease;
        }
        input[type="submit"]:hover {
            background-color: #ddd;
        }
        #penilai-details, #organisasi-details {
            display: none;
        }

        /* Custom styles for the modal */
        .modal-header {
            background-color: #4535C1;
            color: white;
        }
        .modal-footer {
            background-color: #f1f1f1;
        }
        .modal-title {
            font-size: 1.5rem;
            font-weight: bold;
        }
        .modal-body {
            font-size: 1rem;
        }
        .btn-close {
            filter: invert(1);
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="pt-4 text-center">
            <img src="../img/Logo KKP Sekunder B Putih.png" style="width: 250px; height: auto;" alt="Logo KKP">
        </div>
        <h2>Register User atau Penilai</h2>
        <form method="post" action="">
            <label>Username:</label>
            <input type="text" name="username" required>

            <label>Password:</label>
            <input type="password" name="password" required>

            <label>Role:</label>
            <select name="role" required>
                <option value="user">User</option>
                <option value="penilai">Penilai</option>
            </select>

            <!-- Detail untuk Penilai -->
            <div id="penilai-details">
                <label>NIP Penilai:</label>
                <input type="text" name="nip">

                <label>Nama Penilai:</label>
                <input type="text" name="nama_penilai">
            </div>

            <!-- Detail untuk Organisasi -->
            <div id="organisasi-details">
                <label>Unit Eselon 1:</label>
                <input type="text" name="unit_eselon1">

                <label>Nama Organisasi:</label>
                <input type="text" name="nama_organisasi">

                <label>Alamat:</label>
                <input type="text" name="alamat">

                <label>Email Badan:</label>
                <input type="email" name="email_badan">

                <label>No. Telp / Fax:</label>
                <input type="text" name="no_telp_fax">

                <label>NIP Responden:</label>
                <input type="text" name="nip_responden">

                <label>Nama Responden:</label>
                <input type="text" name="nama_responden">
            </div>

            <input type="submit" value="Register">
        </form>
        <a href="admin_dashboard.php"  style="display: block; color:white; margin-top: 10px; text-align: center;">Kembali ke Beranda</a>
    </div>

    <!-- Modal -->
   <!-- SweetAlert2 -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script>
        <?php if (!empty($modal_message)) { ?>
            Swal.fire({
                title: '<?php echo $modal_type == "success" ? "Success" : "Error"; ?>',
                text: '<?php echo $modal_message; ?>',
                icon: '<?php echo $modal_type == "success" ? "Success" : "Error"; ?>',
                confirmButtonText: 'OK'
            });

            <?php } ?>

// Show/hide form sections based on role selection
document.querySelector('select[name="role"]').addEventListener('change', function() {
    var role = this.value;
    document.getElementById('penilai-details').style.display = role === 'penilai' ? 'block' : 'none';
    document.getElementById('organisasi-details').style.display = role === 'user' ? 'block' : 'none';
});
    </script>
</body>
</html>

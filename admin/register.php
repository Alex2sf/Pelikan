<?php
include '../koneksi.php';

session_start();
if (!isset($_SESSION['id_akun']) || $_SESSION['role'] != 'admin') {
    header("Location: admin_login.php");
    exit();
}

$username="";
$username1=$_SESSION["role"];


$modal_message = '';
$modal_type = '';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = $_POST['username'];
    $password = md5($_POST['password']);
    $role = $_POST['role'];

    // Cek apakah username sudah ada
    $check_username = "SELECT * FROM akun_login WHERE username = '$username'";
    $result_username = $conn->query($check_username);

    if ($result_username->num_rows > 0) {
        $modal_message = 'Username sudah terpakai. Silakan gunakan username yang lain.';
        $modal_type = 'danger';
    } else {
        try {
            // Proses registrasi Akun_Login
            $sql = "INSERT INTO akun_login (username, password, role) VALUES ('$username', '$password', '$role')";
            if ($conn->query($sql) === TRUE) {
                $id_akun = $conn->insert_id;

                if ($role === 'penilai') {
                    // Proses untuk Penilai
                    $nip = $_POST['nip'] ?? null;
                    $nama_penilai = $_POST['nama_penilai'] ?? null;

                    $check_nip = "SELECT * FROM profile_penilai WHERE nip = '$nip'";
                    $result_nip = $conn->query($check_nip);

                    if ($result_nip->num_rows > 0) {
                        $modal_message = 'NIP sudah terpakai. Silakan gunakan NIP yang lain.';
                        $modal_type = 'danger';
                    } else {
                        $sql_penilai = "INSERT INTO profile_penilai (id_akun, nip, nama_penilai) VALUES ('$id_akun', '$nip', '$nama_penilai')";
                        if ($conn->query($sql_penilai) === TRUE) {
                            $modal_message = 'Penilai berhasil didaftarkan!';
                            $modal_type = 'success';
                        } else {
                            $modal_message = 'Error: ' . $sql_penilai . "<br>" . $conn->error;
                            $modal_type = 'danger';
                        }
                    }
                } else {
                    // Proses untuk User
                    $unit_eselon1 = $_POST['unit_eselon1'] ?? null;
                    $nama_organisasi = $_POST['nama_organisasi'] ?? null;
                    $alamat = $_POST['alamat'] ?? null;
                    $email_badan = $_POST['email_badan'] ?? null;
                    $no_telp_fax = $_POST['no_telp_fax'] ?? null;
                    $nip_responden = $_POST['nip_responden'] ?? null;
                    $nama_responden = $_POST['nama_responden'] ?? null;

                    // Pastikan SQL query terbentuk dengan benar
                    $sql_organisasi = "INSERT INTO organisasi (id_akun, unit_eselon1, nama_organisasi, alamat, email_badan, no_telp_fax, nip_responden, nama_responden) VALUES ('$id_akun', '$unit_eselon1', '$nama_organisasi', '$alamat', '$email_badan', '$no_telp_fax', '$nip_responden', '$nama_responden')";

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
        } catch (mysqli_sql_exception $e) {
            $modal_message = 'Error: ' . $e->getMessage();
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
    <script type="text/javascript" src="../js/bootstrap.js"></script>
        <script type="text/javascript" src="../js/bootstrap.min.js"></script>
        <link href="../css/bootstrap.min.css" type="text/css" rel="stylesheet">
        <link href="../css/pelikan.css" type="text/css" rel="stylesheet">
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
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
            font-family: Arial, sans-serif;
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

      
                /* Gaya untuk input link */
            input[type="text"] {
                padding: 5px;
                width: 150px;
                border: 2px solid #007BFF;
                border-radius: 50px;
                transition: 0.3s ease;
                text-align: center;
            }

            input[type="text"]:focus, input[type="text"]:valid {
                box-shadow: 0 0 1px rgba(0, 91, 234, 0.2);
            }
            table th, table td {
                padding: 10px;
                text-align: center; /* Menyelaraskan konten secara horizontal ke tengah */
                vertical-align: middle; /* Menyelaraskan konten secara vertikal ke tengah */
                border-bottom: 1px solid #ddd;
            }

            table td input[type="radio"],
            table td input[type="text"],
            table td input[type="file"] {
                margin: 0 auto; /* Membuat elemen berada di tengah */
                display: block; /* Memastikan elemen berbentuk blok untuk posisi */
            }
            .upload-box {
                font-size: 5 px;
                background: white;
                border-radius: 50px;
                box-shadow: 0px 0px 5px black;
                width: 350px;
                outline:none;
            }
            ::-webkit-file-upload-button{
                color: white;
                background: #206a5d;
                padding:5px;
                border:none;
                border-radius:20px;
                box-shadow: 1px 0 1px 1px #6b4559;
                outline: none;
            }
            ::-webkit-file-upload-button:hover{
                background: #438a5e;
                cursor: pointer;
            }
    </style>
</head>
<body>

<?php
    include('navbar.php');  // Include navbar.php
?>
    <div class="container">
        <div class="pt-4 text-center">
            <img src="../img/Logo KKP Sekunder B Putih.png" style="width: 250px; height: auto;" alt="Logo KKP">
        </div>
        <h2>Register User atau Penilai</h2>
        <form method="post" action="">

            <label>Username:</label>
            <input style = ' width: 100%;
            padding: 12px;
            margin-bottom: 20px;
            border: 1px solid #ddd;
            border-radius: 5px;
            box-sizing: border-box;
            color: #333;
            font-size: 16px;'type="text" name="username" required>

       

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
            

            <input type="submit" value="Register">
        </form>
        <a href="admin_dashboard.php"  style="display: block; color:white; margin-top: 10px; text-align: center;">Kembali ke Beranda</a>
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
     <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script>
        // Modal untuk pesan sukses/error
        <?php if (!empty($modal_message)) { ?>
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
        <?php } ?>

        // Tampilkan detail form sesuai dengan role
        document.querySelector('select[name="role"]').addEventListener('change', function() {
            var role = this.value;
            document.getElementById('penilai-details').style.display = role === 'penilai' ? 'block' : 'none';
            document.getElementById('organisasi-details').style.display = role === 'user' ? 'block' : 'none';
        });

        // Modal konfirmasi sebelum submit form
        document.getElementById('registerForm').addEventListener('submit', function(event) {
            event.preventDefault(); // Mencegah form langsung dikirim

            Swal.fire({
                title: 'Konfirmasi',
                text: "Apakah Anda yakin data sudah benar?",
                icon: 'question',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Ya, submit!',
                cancelButtonText: 'Batal'
            }).then((result) => {
                if (result.isConfirmed) {
                    // Jika pengguna menekan "Yes", form akan dikirimkan
                    this.submit();
                }
            });
        });
    </script>
</body>
</html>

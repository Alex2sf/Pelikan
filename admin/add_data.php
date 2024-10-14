<?php
// Database connection (update with your own connection details)
ob_start();
session_start();
if (!isset($_SESSION['role']) || $_SESSION['role'] !== 'admin') {
    header("Location: admin_login.php");
    exit();
}


$username="";
$username1=$_SESSION["role"];


include '../koneksi.php';


// Handle form submissions
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (isset($_POST['action'])) {
        $action = $_POST['action'];

        if ($action == 'add_category') {
            $kategori = $_POST['kategori'];
            $stmt = $conn->prepare("INSERT INTO kategori (kategori) VALUES (?)");
            $stmt->bind_param("s", $kategori);      
            $stmt->execute();
            $stmt->close();
        } elseif ($action == 'add_subkategori1') {
            $subkategori1 = $_POST['subkategori1'];
            $id_kategori1 = $_POST['id_kategori1'];
            $stmt = $conn->prepare("INSERT INTO subkategori1 (subkategori1, id_kategori) VALUES (?, ?)");
            $stmt->bind_param("si", $subkategori1, $id_kategori1);
            $stmt->execute();
            $stmt->close();
        } elseif ($action == 'add_subkategori2') {
            $subkategori2 = $_POST['subkategori2'];
            $id_subkategori1 = $_POST['id_subkategori1'];
            $stmt = $conn->prepare("INSERT INTO subkategori2 (subkategori2, id_subkategori1) VALUES (?, ?)");
            $stmt->bind_param("si", $subkategori2, $id_subkategori1);
            $stmt->execute();
            $stmt->close();
        } elseif ($action == 'add_subkategori3') {
            $subkategori3 = $_POST['subkategori3'];
            $id_subkategori2 = $_POST['id_subkategori2'];
            $web = $_POST['web'];
            $stmt = $conn->prepare("INSERT INTO subkategori3 (subkategori3, id_subkategori2, web) VALUES (?, ?, ?)");
            $stmt->bind_param("sis", $subkategori3, $id_subkategori2, $web);
            $stmt->execute();
            $stmt->close();
        } elseif ($action == 'add_question') {
            $pertanyaan = $_POST['pertanyaan'];
            $id_kategori = $_POST['id_kategori'];
            $id_subkategori1 = $_POST['id_subkategori1'];
            $id_subkategori2 = $_POST['id_subkategori2'];
            $id_subkategori3 = $_POST['id_subkategori3'];
            $bobot = $_POST['bobot'];
            $web = $_POST['web'];
            $stmt = $conn->prepare("INSERT INTO pertanyaan (pertanyaan, id_kategori, id_subkategori1, id_subkategori2, id_subkategori3, bobot, web) VALUES (?, ?, ?, ?, ?, ?, ?)");
            $stmt->bind_param("siiiiis", $pertanyaan, $id_kategori, $id_subkategori1, $id_subkategori2, $id_subkategori3, $bobot, $web);
            $stmt->execute();
            $stmt->close();
        }
    }
}

// Fetch options for dropdowns
$kategori_options = $conn->query("SELECT id_kategori, kategori FROM kategori");
$subkategori1_options = $conn->query("SELECT id_subkategori1, subkategori1 FROM subkategori1");
$subkategori2_options = $conn->query("SELECT id_subkategori2, subkategori2 FROM subkategori2");
$subkategori3_options = $conn->query("SELECT id_subkategori3, subkategori3 FROM subkategori3");
?>

<!DOCTYPE html>
<html lang="en">
    <head>
    <script>
        
        function showConfirmation() {
            alert("Kategori berhasil ditambahkan!");
        }
        function showConfirmation1() {
            alert("SubKategori 1 berhasil ditambahkan!");
        }
        function showConfirmation2() {
            alert("SubKategori 2 berhasil ditambahkan!");
        }
        function showConfirmation3(){
            alert("SubKategori 3 berhasil ditambahkan!");
        }
        function ConfirmationQuestion(){
            alert("Pertanyaan Telah Berhasil Ditambahkan!");
        }
    </script>
     <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Add Data</title>
    <script type="text/javascript" src="../js/bootstrap.js"></script>
        <script type="text/javascript" src="../js/bootstrap.min.js"></script>
        <link href="../css/bootstrap.min.css" type="text/css" rel="stylesheet">
        <link href="../css/pelikan.css" type="text/css" rel="stylesheet">
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <style>
        <style>
             .modal {
            display: none; /* Modal disembunyikan secara default */
            position: fixed;
            z-index: 1;
            left: 0;
            top: 0;
            width: 100%;
            height: 100%;
            background-color: rgba(0, 0, 0, 0.5); /* Latar belakang gelap dengan transparansi */
        }

        .modal-content {
            background-color: #fff;
            margin: 15% auto;
            padding: 20px;
            border: 1px solid #888;
            width: 80%;
            max-width: 400px;
            text-align: center;
            border-radius: 10px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2);
        }

        .modal-content h4 {
            color: #333;
        }

        .modal-content button {
            background-color: #4CAF50;
            color: white;
            padding: 10px 20px;
            border: none;
            cursor: pointer;
            border-radius: 5px;
        }

        .modal-content button:hover {
            background-color: #45a049;
        }
        body {
            margin-top: 80px;
            font-family: Arial, sans-serif;
            background-image: url('img/KKP.jpg');
            background-size: cover;
            background-repeat: no-repeat;
            background-position: center;
            background-attachment: fixed;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            min-height: 100vh;
            padding: 20px;
        }



        .form-container {
            background: rgba(255, 255, 255, 0.9);
            padding: 30px;
            border-radius: 12px;
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.2);
            max-width: 14500px;
            width: 100%;
            margin: 20px;
            margin-top: 60px;
        }

        h2 {
            text-align: center;
            margin-bottom: 20px;
            font-size: 24px;
            color: #4535C1;
            font-weight: bold;
            text-transform: uppercase;
            text-shadow: 0 2px 4px rgba(0, 0, 0, 0.2); 
                }
        h3 {
            text-align: center;
            margin-bottom: 20px;
            font-size: 24px;
            color: #4535C1;
            font-weight: bold;
            text-transform: uppercase;
            text-shadow: 0 2px 4px rgba(0, 0, 0, 0.2); 
        }

        label {
            display: block;
            margin-bottom: 8px;
            font-weight: bold;
            font-size: 14px;
            color: #333;
        }

        input[type="text"],
        input[type="email"],
        select,
        input[type="number"] {
            width: 100%;
            padding: 12px;
            margin-bottom: 15px;
            border: 1px solid #ccc;
            border-radius: 6px;
            font-size: 16px;
            outline: none;
        }

        input[type="text"]:focus,
        input[type="email"]:focus,
        select:focus,
        input[type="number"]:focus {
            border-color: #4535C1;
            background-color: #f4f4f4;
        }

        button {
            background-color: #4535C1;
            color: #fff;
            padding: 10px 20px;
            border: none;
            border-radius: 6px;
            cursor: pointer;
            transition: background-color 0.3s ease;
            font-size: 16px;
        }

        button:hover {
            background-color: #5a47e4;
        }

        @media (max-width: 768px) {
            .form-container {
                padding: 20px;
            }

            h2 {
                font-size: 20px;
            }
        }

        @media (max-width: 480px) {
            h2 {
                font-size: 18px;
            }

            button {
                font-size: 14px;
            }
        }
    </style>
    </style>
</head>
<body>

<?php
    include('navbar.php');  // Include navbar.php
?>
<!-- Halaman konten lainnya di sini -->

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
        <div class="form-container">
        <!-- Formulir untuk Menambahkan Kategori -->
        <!-- <form action="add_data.php" method="post" onsubmit="showConfirmation(event)" name="formKategori">
            <h3>Tambah Kategori</h3>
            <input type="hidden" name="action" value="add_category">
            <label for="kategori">Kategori:</label>
            <input type="text" id="kategori" name="kategori" required>
            <button type="submit">Tambah Kategori</button>
        </form> -->
        <div id="modalKategori" class="modal">
            <div class="modal-content">
                <h4>Kategori berhasil ditambahkan!</h4>
                <p>Form akan dikirimkan dalam 2 detik...</p>
                <button onclick="closeModal('modalKategori')">Tutup</button>
            </div>
        </div>

        <!-- Formulir untuk Menambahkan SubKategori1 -->
        <form action="add_data.php" method="post" onsubmit="showConfirmation1(event)" name="formSubKategori1">
            <h3>Tambah SubKategori 1</h3>
            <input type="hidden" name="action" value="add_subkategori1">
            <label for="subkategori1">SubKategori 1:</label>
            <input type="text" id="subkategori1" name="subkategori1" required>
            <label for="id_kategori1">Kategori:</label>
            <select id="id_kategori1" name="id_kategori1" required>
                <?php while ($row = $kategori_options->fetch_assoc()) { ?>
                    <option value="<?php echo $row['id_kategori']; ?>"><?php echo $row['kategori']; ?></option>
                <?php } ?>
            </select>
            <button type="submit">Tambah SubKategori 1</button>
        </form>
        <div id="modalSubKategori1" class="modal">
            <div class="modal-content">
                <h4>SubKategori 1 berhasil ditambahkan!</h4>
                <p>Form akan dikirimkan dalam 2 detik...</p>
                <button onclick="closeModal('modalSubKategori1')">Tutup</button>
            </div>
        </div>

        <!-- Formulir untuk Menambahkan SubKategori2 -->
        <form action="add_data.php" method="post" onsubmit="showConfirmation2(event)" name="formSubKategori2">
            <h3>Tambah SubKategori 2</h3>
            <input type="hidden" name="action" value="add_subkategori2">
            <label for="subkategori2">SubKategori 2:</label>
            <input type="text" id="subkategori2" name="subkategori2" required>
            <label for="id_subkategori1">SubKategori 1:</label>
            <select id="id_subkategori1" name="id_subkategori1" required>
                <?php while ($row = $subkategori1_options->fetch_assoc()) { ?>
                    <option value="<?php echo $row['id_subkategori1']; ?>"><?php echo $row['subkategori1']; ?></option>
                <?php } ?>
            </select>
            <button type="submit">Tambah SubKategori 2</button>
        </form>
        <div id="modalSubKategori2" class="modal">
            <div class="modal-content">
                <h4>SubKategori 2 berhasil ditambahkan!</h4>
                <p>Form akan dikirimkan dalam 2 detik...</p>
                <button onclick="closeModal('modalSubKategori2')">Tutup</button>
            </div>
        </div>

        <!-- Formulir untuk Menambahkan SubKategori3 -->
        <form action="add_data.php" method="post" onsubmit="showConfirmation3(event)" name="formSubKategori3">
            <h3>Tambah SubKategori 3</h3>
            <input type="hidden" name="action" value="add_subkategori3">
            <label for="subkategori3">SubKategori 3:</label>
            <input type="text" id="subkategori3" name="subkategori3" required>
            <label for="id_subkategori2">SubKategori 2:</label>
            <select id="id_subkategori2" name="id_subkategori2" required>
                <?php while ($row = $subkategori2_options->fetch_assoc()) { ?>
                    <option value="<?php echo $row['id_subkategori2']; ?>"><?php echo $row['subkategori2']; ?></option>
                <?php } ?>
            </select>
            <label for="web">Website (optional):</label>
            <input type="text" id="web" name="web">
            <button type="submit">Tambah SubKategori 3</button>
        </form>
        <div id="modalSubKategori3" class="modal">
            <div class="modal-content">
                <h4>SubKategori 3 berhasil ditambahkan!</h4>
                <p>Form akan dikirimkan dalam 2 detik...</p>
                <button onclick="closeModal('modalSubKategori3')">Tutup</button>
            </div>
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
                <!-- Formulir untuk Menambahkan Pertanyaan
                <form action="add_data.php" method="post" onsubmit="ConfirmationQuestion(event)" name="formPertanyaan">
                    <h3>Tambah Pertanyaan</h3>
                    <input type="hidden" name="action" value="add_question">
                    <label for="pertanyaan">Pertanyaan:</label>
                    <input type="text" id="pertanyaan" name="pertanyaan" required>
                    <label for="id_kategori">Kategori:</label>
                    <select id="id_kategori" name="id_kategori" required>
                        <?php
                        // Refetch options for Kategori dropdown
                        $kategori_options = $conn->query("SELECT id_kategori, kategori FROM kategori");
                        while ($row = $kategori_options->fetch_assoc()) { ?>
                            <option value="<?php echo $row['id_kategori']; ?>"><?php echo $row['kategori']; ?></option>
                        <?php } ?>
                    </select>
                    <label for="id_subkategori1">SubKategori 1:</label>
                    <select id="id_subkategori1" name="id_subkategori1" required>
                        <?php
                        // Refetch options for SubKategori1 dropdown
                        $subkategori1_options = $conn->query("SELECT id_subkategori1, subkategori1 FROM subkategori1");
                        while ($row = $subkategori1_options->fetch_assoc()) { ?>
                            <option value="<?php echo $row['id_subkategori1']; ?>"><?php echo $row['subkategori1']; ?></option>
                        <?php } ?>
                    </select>
                    <label for="id_subkategori2">SubKategori 2:</label>
                    <select id="id_subkategori2" name="id_subkategori2" required>
                        <?php
                        // Refetch options for SubKategori2 dropdown
                        $subkategori2_options = $conn->query("SELECT id_subkategori2, subkategori2 FROM subkategori2");
                        while ($row = $subkategori2_options->fetch_assoc()) { ?>
                            <option value="<?php echo $row['id_subkategori2']; ?>"><?php echo $row['subkategori2']; ?></option>
                        <?php } ?>
                    </select>
                    <label for="id_subkategori3">SubKategori 3:</label>
                    <select id="id_subkategori3" name="id_subkategori3" required>
                        <?php
                        // Refetch options for SubKategori3 dropdown
                        $subkategori3_options = $conn->query("SELECT id_subkategori3, subkategori3 FROM subkategori3");
                        while ($row = $subkategori3_options->fetch_assoc()) { ?>
                            <option value="<?php echo $row['id_subkategori3']; ?>"><?php echo $row['subkategori3']; ?></option>
                        <?php } ?>
                    </select>
                    <label for="bobot">Bobot:</label>
                    <input type="number" id="bobot" name="bobot" required>
                    <label for="web">Website (optional):</label>
                    <input type="text" id="web" name="web">
                    <button type="submit">Tambah Pertanyaan</button>
                    </form>
                    <div id="modalPertanyaan" class="modal">
                    <div class="modal-content">
                        <h4>Pertanyaan berhasil ditambahkan!</h4>
                        <p>Form akan dikirimkan dalam 2 detik...</p>
                        <button onclick="closeModal('modalPertanyaan')">Tutup</button>
                        </div>
                    </div> -->
       
        <!-- Script untuk menangani modal dan submit form -->
        <script type="text/javascript">
            document.getElementById("confirmLogoutBtn").addEventListener("click", function() {
                window.location.href = "logout.php"; // Redirect to the logout page
            });
        </script>
        <script>
             // Fungsi untuk menampilkan modal
         function showModal(modalId) {
            var modal = document.getElementById(modalId);
            modal.style.display = "block";
        }

        // Fungsi untuk menutup modal
        function closeModal(modalId) {
            var modal = document.getElementById(modalId);
            modal.style.display = "none";
        }

        // Fungsi untuk Kategori
        function showConfirmation(event) {
            event.preventDefault();
            showModal('modalKategori');
            setTimeout(function() {
                document.forms['formKategori'].submit();
            }, 2000);
        }

        // Fungsi untuk SubKategori 1
        function showConfirmation1(event) {
            event.preventDefault();
            showModal('modalSubKategori1');
            setTimeout(function() {
                document.forms['formSubKategori1'].submit();
            }, 2000);
        }

        // Fungsi untuk SubKategori 2
        function showConfirmation2(event) {
            event.preventDefault();
            showModal('modalSubKategori2');
            setTimeout(function() {
                document.forms['formSubKategori2'].submit();
            }, 2000);
        }

        // Fungsi untuk SubKategori 3
        function showConfirmation3(event) {
            event.preventDefault();
            showModal('modalSubKategori3');
            setTimeout(function() {
                document.forms['formSubKategori3'].submit();
            }, 2000);
        }

        // Fungsi untuk Pertanyaan
        function ConfirmationQuestion(event) {
            event.preventDefault();
            showModal('modalPertanyaan');
            setTimeout(function() {
                document.forms['formPertanyaan'].submit();
            }, 2000);
        }
        </script>
         
</body>
</html>

<?php
// Close the database connection
$conn->close();
?>

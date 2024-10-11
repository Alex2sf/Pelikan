<?php
ob_start();
session_start();
$username="";
$username1=$_SESSION["role"];
$servername = "localhost";
$username = "root";
$password = "";
$database = "sigh";

// Database connection
$conn = new mysqli('localhost', 'root', '', 'sigh');

        // Fetch data based on AJAX requests
        if (isset($_GET['action'])) {
            $action = $_GET['action'];
            if ($action === 'fetch_kategori') {
                $sql = "SELECT id_kategori, kategori FROM kategori";
                $result = $conn->query($sql);
                while ($row = $result->fetch_assoc()) {
                    echo "<option value='" . $row['id_kategori'] . "'>" . $row['kategori'] . "</option>";
                }
                exit();
            } elseif ($action === 'fetch_subkategori1' && isset($_GET['id_kategori'])) {
                $id_kategori = $_GET['id_kategori'];
                $sql = "SELECT id_subkategori1, subkategori1 FROM subkategori1 WHERE id_kategori = $id_kategori";
                $result = $conn->query($sql);
                while ($row = $result->fetch_assoc()) {
                    echo "<option value='" . $row['id_subkategori1'] . "'>" . $row['subkategori1'] . "</option>";
                }
                exit();
            } elseif ($action === 'fetch_subkategori2' && isset($_GET['id_subkategori1'])) {
                $id_subkategori1 = $_GET['id_subkategori1'];
                $sql = "SELECT id_subkategori2, subkategori2 FROM subkategori2 WHERE id_subkategori1 = $id_subkategori1";
                $result = $conn->query($sql);
                while ($row = $result->fetch_assoc()) {
                    echo "<option value='" . $row['id_subkategori2'] . "'>" . $row['subkategori2'] . "</option>";
                }
                exit();
            } elseif ($action === 'fetch_subkategori3' && isset($_GET['id_subkategori2'])) {
                $id_subkategori2 = $_GET['id_subkategori2'];
                $sql = "SELECT id_subkategori3, subkategori3 FROM subktegori3 WHERE id_subkategori2 = $id_subkategori2";
                $result = $conn->query($sql);
                while ($row = $result->fetch_assoc()) {
                    echo "<option value='" . $row['id_subkategori3'] . "'>" . $row['subkategori3'] . "</option>";
                }
                exit();
            }
        }

  // Handle form submission
  if ($_SERVER['REQUEST_METHOD'] === 'POST') {
      $kategori = $_POST['kategori'];
      $subkategori1 = $_POST['subkategori1'];
      $subkategori2 = $_POST['subkategori2'];
      $subkategori3 = $_POST['subkategori3'];
      $pertanyaan = $_POST['pertanyaan'];
      $bobot = $_POST['bobot'];
      $web = $_POST['web'];
      $sql = "INSERT INTO pertanyaan (pertanyaan, id_kategori, id_subkategori1, id_subkategori2, id_subkategori3,  bobot, web) 
              VALUES ('$pertanyaan', $kategori, $subkategori1, $subkategori2, $subkategori3, '$bobot', '$web')";
      $conn->query($sql);
      echo "Question added successfully!";
  }
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Add Question</title>
  <script type="text/javascript" src="../js/bootstrap.js"></script>
        <script type="text/javascript" src="../js/bootstrap.min.js"></script>
        <link href="../css/bootstrap.min.css" type="text/css" rel="stylesheet">
        <link href="../css/pelikan.css" type="text/css" rel="stylesheet">
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
  <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
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
                                <li><a class="dropdown-item" href="add_data.php">Tambah Kategori Kuesioner</a></li>
                                <li><a class="dropdown-item" href="add_pertanyaan.php">Tambah Pertanyaan Kuesioner</a></li>
                                <li><a class="dropdown-item" href="daftar_organisasi.php">Hasil Kuesioner</a></li>
                                <li><a class="dropdown-item" href="adminrud_kuesioner.php">Edit Kuesioner</a></li>
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
<form method="post" name="formPertanyaan">
<div class="form-container">
<h3>Tambah Pertanyaan</h3>  
  <form method="POST">
    <!-- Select Kategori -->
    <label for="kategori">Kategori:</label>
    <select id="kategori" name="kategori" required>
      <option value="">Select Kategori</option>
    </select><br><br>

    <!-- Select SubKategori1 -->
    <label for="subkategori1">SubKategori 1:</label>
    <select id="subkategori1" name="subkategori1" required>
      <option value="">Select SubKategori 1</option>
    </select><br><br>

    <!-- Select SubKategori2 -->
    <label for="subkategori2">SubKategori 2:</label>
    <select id="subkategori2" name="subkategori2" required>
      <option value="">Select SubKategori 2</option>
    </select><br><br>

    <!-- Select SubKategori3 -->
    <label for="subkategori3">SubKategori 3:</label>
    <select id="subkategori3" name="subkategori3" required>
      <option value="">Select SubKategori 3</option>
    </select><br><br>

    <!-- Pertanyaan Field -->
    <input type="hidden" name="action" value="add_question">
            <label for="pertanyaan">Pertanyaan:</label>
            <input type="text" id="pertanyaan" name="pertanyaan" required>  


            <label for="bobot">Bobot:</label>
            <input type="number" id="bobot" name="bobot" step="0.01" required>
            <label for="web">Website (optional):</label>
            <input type="text" id="web" name="web">

    <!-- Submit Button -->
    <button type="submit">Add Question</button>
  </form>

  <script>
    // jQuery to populate Kategori dropdown on page load
    $(document).ready(function() {
      $.ajax({
        url: '?action=fetch_kategori',
        method: 'GET',
        success: function(data) {
          $('#kategori').append(data);
        }
      });

      // Update SubKategori1 based on Kategori selection
      $('#kategori').change(function() {
        var kategoriId = $(this).val();
        $('#subkategori1').html('<option value="">Select SubKategori 1</option>');
        $('#subkategori2').html('<option value="">Select SubKategori 2</option>');
        $('#subkategori3').html('<option value="">Select SubKategori 3</option>');
        if (kategoriId) {
          $.ajax({
            url: '?action=fetch_subkategori1&id_kategori=' + kategoriId,
            method: 'GET',
            success: function(data) {
              $('#subkategori1').append(data);
            }
          });
        }
      });

      // Update SubKategori2 based on SubKategori1 selection
      $('#subkategori1').change(function() {
        var subkategori1Id = $(this).val();
        $('#subkategori2').html('<option value="">Select SubKategori 2</option>');
        $('#subkategori3').html('<option value="">Select SubKategori 3</option>');
        if (subkategori1Id) {
          $.ajax({
            url: '?action=fetch_subkategori2&id_subkategori1=' + subkategori1Id,
            method: 'GET',
            success: function(data) {
              $('#subkategori2').append(data);
            }
          });
        }
      });

      // Update SubKategori3 based on SubKategori2 selection
      $('#subkategori2').change(function() {
        var subkategori2Id = $(this).val();
        $('#subkategori3').html('<option value="">Select SubKategori 3</option>');
        if (subkategori2Id) {
          $.ajax({
            url: '?action=fetch_subkategori3&id_subkategori2=' + subkategori2Id,
            method: 'GET',
            success: function(data) {
              $('#subkategori3').append(data);
            }
          });
        }
      });
    });
  </script>
</body>
</html>

<?php
session_start();
if (!isset($_SESSION['id_akun'])) {
    header("Location: login.php");
    exit();
}
$username="";
$username1=$_SESSION["role"];

$conn = new mysqli('localhost', 'root', '', 'emone'); // Ganti dengan kredensial database Anda
// Cek koneksi database
if ($conn->connect_error) {
    die("Koneksi gagal: " . $conn->connect_error);
}

// Fetch categories for dropdown
$categorySql = "SELECT * FROM Kategori";
$categoryResult = $conn->query($categorySql);
?>

<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Kuesioner</title>
        
        <!-- Bootstrap CSS -->
        <link href="../css/bootstrap.min.css" type="text/css" rel="stylesheet">
        <link href="../css/pelikan.css" type="text/css" rel="stylesheet">
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
        
        <!-- Bootstrap JS -->
        <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
        <script type="text/javascript" src="../js/bootstrap.js"></script>
        <script type="text/javascript" src="../js/bootstrap.min.js"></script>

        <style>
            body {
                font-family: Arial, sans-serif;
                justify-content: center;
                margin: 20px;
            }
            label, select {
                display: block;
                margin-bottom: 10px;
            }
            input[type="radio"], input[type="text"], input[type="file"] {
                margin-right: 10px;
            }
            .form-control {  width: 100%;
                padding: 10px;
                margin-bottom: 20px;
                border: 1px solid #ccc;
                border-radius: 4px;
                font-size: 16px;
                box-sizing: border-box;
                transition: border-color 0.3s ease;

            }
            .form-control:focus {
                border-color: #5b9bd5;
                outline: none;
                box-shadow: 0 0 5px rgba(91, 155, 213, 0.3);
            }

            textarea.form-control {
                height: 150px;
                resize: vertical;
            }
            select.form-control {
                appearance: none;
                background: url('data:image/svg+xml;charset=US-ASCII,<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 140 140"><polygon points="0,0 70,70 140,0"/></svg>') no-repeat right 10px center;
                background-size: 12px;
                padding-right: 30px;
            }
        </style>
    </head>
    <body>
        <!--Navigasi Bar-->
        <nav class="navbar navbar-expand-lg bg-body-tertiary fixed-top" style="border-bottom: 2px solid #4535C1; height: 60px;">
            <div class="container-fluid fs-5">
                <a class="navbar-brand fs-5" href="#" style="padding-left:60px; padding-top:-10px">
                    <img src="../img/pelikanlogo.png" alt="Logo" width="60" class="d-inline-block align-text-top">
                </a>
                <div>Pelikan</div>
                <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                    <span class="navbar-toggler-icon"></span>
                </button>
                <div class="collapse navbar-collapse" id="navbarNav" style="padding-right:60px;">
                    <ul class="nav nav-tabs ms-auto">
                        <li class="nav-item px-2">
                            <a class="nav-link black" aria-current="page" href="index.php">Beranda</a>
                        </li>
                        <li class="nav-item px-2">
                            <a class="nav-link black" href="peringkat.php">Peringkat</a>
                        </li>
                        <li class="nav-item px-2">
                            <a class="nav-link active" href="kuesioner.php">Kuesioner</a>
                        </li>
                        <li class="nav-item px-2">
                            <a class="nav-link black" href="alur.php">Alur</a>
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

        <!-- Spacing after navbar -->
        <div style="margin-top: 80px;"></div>

        <!-- Dropdown for selecting category -->
        <label for="kategori">Pilih Kategori:</label>
        <select id="kategori" name="kategori" class="form-control">
            <option value="">Pilih Kategori</option>
            <?php
            if ($categoryResult->num_rows > 0) {
                while ($categoryRow = $categoryResult->fetch_assoc()) {
                    echo "<option value='{$categoryRow['id_kategori']}'>{$categoryRow['kategori']}</option>";
                }
            }
            ?>
        </select>

        
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


        <!-- Container for questionnaire loaded via AJAX -->
        <div id="questionnaireContainer"></div>

        <script>
            $(document).ready(function() {
                // Save answers to localStorage
                function saveAnswers() {
                    var id_kategori = $('#kategori').val();
                    if (!id_kategori) return;

                    $('#questionnaireContainer').find('input, textarea, select').each(function() {
                        var id = $(this).attr('name') || $(this).attr('id');
                        if (id) {
                            if ($(this).attr('type') === 'radio') {
                                if ($(this).is(':checked')) {
                                    localStorage.setItem(id, $(this).val());
                                }
                            } else if ($(this).attr('type') === 'file') {
                                // Skip file inputs (can't store in localStorage)
                            } else {
                                localStorage.setItem(id, $(this).val());
                            }
                        }
                    });
                }

                // Load answers from localStorage
                function loadAnswers() {
                    $('#questionnaireContainer').find('input, textarea, select').each(function() {
                        var id = $(this).attr('name') || $(this).attr('id');
                        if (id) {
                            var savedValue = localStorage.getItem(id);
                            if (savedValue !== null) {
                                if ($(this).attr('type') === 'radio') {
                                    if ($(this).val() === savedValue) {
                                        $(this).prop('checked', true);
                                    }
                                } else {
                                    $(this).val(savedValue);
                                }
                            }
                        }
                    });
                }

                // When category is selected
                $('#kategori').on('change', function() {
                    saveAnswers();
                    var id_kategori = $(this).val();

                    if (id_kategori === "") {
                        $('#questionnaireContainer').empty();
                        return;
                    }

                    $.ajax({
                        url: 'bankkuesioner.php',
                        type: 'POST',
                        data: { id_kategori: id_kategori },
                        success: function(data) {
                            $('#questionnaireContainer').html(data);
                            loadAnswers();
                        }
                    });
                });

                // Save answers when inputs change
                $('#questionnaireContainer').on('change', 'input, textarea, select', function() {
                    saveAnswers();
                });
            });

            // Script untuk menangani modal dan submit form
            document.getElementById("confirmLogoutBtn").addEventListener("click", function() {
                window.location.href = "logout.php"; // Redirect to the logout page
            });
        </script>
    </body>
</html>

<?php
$conn->close();
?>

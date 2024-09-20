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
        /* Basic styling and layout */
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            background-image: url(img/KKP.jpg);
            background-size: cover;
            background-repeat: no-repeat;
            background-position: center center;
            background-attachment: fixed;
            font-family: 'Arial', sans-serif;
            background-color: #f0f0f0;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            margin-top: 120px;
        }

        .container {
            background-color: #ffffff;
            padding: 30px;
            border-radius: 12px;
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
            text-align: center;
            width: 500px;  /* Increased width */
            max-width: 90%;  /* Ensure the form is responsive */
            margin: auto;
        }

        h1 {
            background-color: #98F5E1;
            padding: 12px;
            border-radius: 25px;
            font-size: 20px;
            margin-bottom: 25px;
            color: #000;
        }

        label {
            font-size: 16px;
            display: block;
            margin-bottom: 10px;
            text-align: left;
        }

        select, input[type="text"] {
            width: 100%;
            padding: 12px;
            margin-bottom: 20px;
            border: none;
            border-radius: 20px;
            background-color: #45C1E1;
            color: white;
            font-size: 16px;
            text-align: left;
            transition: all 0.3s ease;
        }

        select:focus, input[type="text"]:focus {
            outline: none;
            background-color: #38A0C9;
        }

        button {
            width: 100%;
            padding: 14px;
            border: none;
            border-radius: 25px;
            background-color: #45C1E1;
            color: white;
            font-size: 18px;  /* Increased font size */
            cursor: pointer;
            transition: background-color 0.3s ease, transform 0.2s ease;
        }

        button:hover {
            background-color: #2FA9C9;
            transform: scale(1.05);
        }

        .success-message, .error-message {
            display: none;
            font-size: 16px;
            margin-top: 15px;
            padding: 10px;
            border-radius: 8px;
        }

        .success-message {
            background-color: #d4edda;
            color: #155724;
        }

        .error-message {
            background-color: #f8d7da;
            color: #721c24;
        }

        @media (min-width: 768px) {
            /* Larger screens */
            .container {
                width: 600px;  /* Increased width for larger screens */
            }
        }

        @media (min-width: 1024px) {
            /* Even larger screens */
            .container {
                width: 700px;  /* Increased width for even larger screens */
            }

            button {
                font-size: 20px;  /* Larger button font size */
            }

            select, input[type="text"] {
                font-size: 18px;  /* Larger select field font size */
            }

            label {
                font-size: 18px;  /* Larger label font size */
            }
        }
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
                            <a class="nav-link active" aria-current="page" href="admin_dashboard.php">Beranda</a>
                        </li>
                        <li class="nav-item px-2">
                            <a class="nav-link black" href="register.php">Daftar Akun</a>
                        </li>
                        <li class="nav-item px-2">
                            <a class="nav-link black" href="akses_penilai.php">Akses Penilai</a>
                        </li>
                        <li class="nav-item px-2">
                            <a class="nav-link black" href="add_data.php">Kuesioner</a>
                        </li>
                        <li class="nav-item px-2">
                            <a class="nav-link black" href="admin_akses.php">Akses UPT</a>
                        </li>
                        <li class="nav-item px-2">
                            <a class="nav-link black" href="Daftar.php">Daftar Upt</a>
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

    <div class="container">
        <h1>Atur Akses Penilai</h1>
        <form id="accessForm" method="POST">
            <label for="penilai">Pilih Penilai</label>
            <select id="penilai" name="penilai">
                <option value="">-- Pilih Penilai --</option>
                <option value="1">Nama Penilai (NIP: 1234567)</option>
                <option value="2">Nama Penilai (NIP: 7654321)</option>
                <!-- Add more options as needed -->
            </select>

            <label for="organisasi">Pilih Organisasi</label>
            <select id="organisasi" name="organisasi">
                <option value="">-- Pilih Organisasi --</option>
                <option value="A">Organisasi A (Unit Eselon 1)</option>
                <option value="B">Organisasi B (Unit Eselon 2)</option>
                <!-- Add more options as needed -->
            </select>

            <button type="submit" id="submitButton">Tambahkan Akses</button>
        </form>

        <div class="success-message" id="successMessage">Akses berhasil ditambahkan!</div>
        <div class="error-message" id="errorMessage">Terjadi kesalahan, silakan coba lagi.</div>
    </div>

    <script>
        // Form validation and interaction
        document.getElementById('accessForm').addEventListener('submit', function(event) {
            event.preventDefault();  // Prevent form from submitting immediately

            // Get form values
            const penilai = document.getElementById('penilai').value;
            const organisasi = document.getElementById('organisasi').value;

            // Check if both fields are selected
            if (penilai && organisasi) {
                // Show success message
                document.getElementById('successMessage').style.display = 'block';
                document.getElementById('errorMessage').style.display = 'none';

                // Submit the form
                setTimeout(() => {
                    this.submit();
                }, 1500);  // Delay to show the message before submission
            } else {
                // Show error message if fields are empty
                document.getElementById('errorMessage').style.display = 'block';
                document.getElementById('successMessage').style.display = 'none';
            }
        });
    </script>

    <?php
        if ($_SERVER["REQUEST_METHOD"] == "POST") {
            // Get the submitted form data
            $penilai = $_POST['penilai'];
            $organisasi = $_POST['organisasi'];

            // Handle the form submission (you can replace this with database logic)
            if (!empty($penilai) && !empty($organisasi)) {
                // For demonstration, echo the received values
                echo "<div style='text-align:center; margin-top: 20px;'>";
                echo "Penilai (NIP): " . htmlspecialchars($penilai) . "<br>";
                echo "Organisasi: " . htmlspecialchars($organisasi) . "<br>";
                echo "</div>";
            }
        }
    ?>
</body>
</html>

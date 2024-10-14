<?php
session_start();
require 'session_timeout.php';

if (!isset($_SESSION['id_akun'])) {
    header("Location: ../index.php");
    exit();
}
include '../koneksi.php';

$username="";
$username1=$_SESSION["role"];
// Check connection


// Query to get organization rankings
$query = "
    SELECT 
    nama_organisasi, 
    ROUND(
        (COALESCE(nilai_kategori1, 0) + 
         COALESCE(nilai_kategori2, 0) + 
         COALESCE(nilai_kategori3, 0) + 
         COALESCE(nilai_kategori4, 0) + 
         COALESCE(nilai_kategori5, 0) + 
         COALESCE(nilai_kategori6, 0)), 2
    ) AS total_nilai 
FROM 
    organisasi 
ORDER BY 
    total_nilai DESC;
";

$result = mysqli_query($conn, $query);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <script type="text/javascript" src="../js/bootstrap.js"></script>
        <script type="text/javascript" src="../js/bootstrap.min.js"></script>
        <link href="../css/bootstrap.min.css" type="text/css" rel="stylesheet">
        <link href="../css/pelikan.css" type="text/css" rel="stylesheet">
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <title>Peringkat Organisasi</title>
    <style>
        /* Body Styling */
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f7f6;
            margin: 0;
            padding: 0;
            text-align: center;
            background-image: url('../img/Kantor KKP.jpg'); /* Path to your background image */
            background-size: cover;
            background-position: center;
            background-attachment: fixed;
            background-repeat: no-repeat;
        }

        h2 {
            color: #333;
            margin-top: 20px;
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
        /* Table Container */
        .table-container {
            max-width: 80%;
            margin: 30px auto;
            background-color: white;
            padding: 20px;
            box-shadow: 0 2px 8px rgba(0, 0, 0, 0.1);
            border-radius: 8px;
        }

        /* Table Styling */
        table {
            width: 100%;
            border-collapse: collapse;
            overflow: hidden;
            border-radius: 8px;
        }

        th, td {
            padding: 15px;
            text-align: center;
        }

        th {
            background-color: #007BFF;
            color: white;
            font-size: 16px;
            text-transform: uppercase;
            letter-spacing: 1px;
        }

        td {
            font-size: 14px;
            color: #555;
        }

        /* Row Hover Effect */
        tr:nth-child(even) {
            background-color: #f9f9f9;
        }

        tr:hover {
            background-color: #d1ecf1;
        }

        /* Rank Medal Colors */
        .rank-1 {
            color: #FFD700;
            font-weight: bold;
        }
        .rank-2 {
            color: #C0C0C0;
            font-weight: bold;
        }
        .rank-3 {
            color: #CD7F32;
            font-weight: bold;
        }

        /* Responsive Table */
        @media screen and (max-width: 768px) {
            .table-container {
                width: 95%;
            }
            th, td {
                padding: 10px;
                font-size: 12px;
            }
        }

        /* Button Styling */
        .back-button {
            display: inline-block;
            margin-top: 20px;
            padding: 10px 20px;
            background-color: #6c757d;
            color: white;
            text-decoration: none;
            border-radius: 5px;
            transition: background-color 0.3s ease;
        }

        .back-button:hover {
            background-color: #5a6268;
        }
    </style>
</head>
<body>
<?php include 'navbar.php'; ?>

<h2>Peringkat Organisasi Berdasarkan Total Nilai</h2>

<div class="table-container">
    <table>
        <thead>
            <tr>
                <th>No</th>
                <th>Organisasi</th>
                <th>Total Nilai</th>
            </tr>
        </thead>
        <tbody>
            <?php
            if (mysqli_num_rows($result) > 0) {
                $no = 1;
                while ($row = mysqli_fetch_assoc($result)) {
                    // Assign class for top 3 ranks (gold, silver, bronze)
                    $rank_class = "";
                    if ($no == 1) {
                        $rank_class = "rank-1";
                    } elseif ($no == 2) {
                        $rank_class = "rank-2";
                    } elseif ($no == 3) {
                        $rank_class = "rank-3";
                    }

                    echo "<tr>";
                    echo "<td class='{$rank_class}'>{$no}</td>";
                    echo "<td>{$row['nama_organisasi']}</td>";
                    echo "<td>{$row['total_nilai']}</td>";
                    echo "</tr>";
                    $no++;
                }
            } else {
                echo "<tr><td colspan='3'>No data available</td></tr>";
            }
            ?>
        </tbody>
    </table>
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
        
         <!-- Script untuk menangani modal dan submit form -->
         <script type="text/javascript">
            document.getElementById("confirmLogoutBtn").addEventListener("click", function() {
            window.location.href = "logout.php"; // Redirect to the logout page
            });
        </script>

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
</body>
</html>

<?php
// Close the connection
mysqli_close($conn);

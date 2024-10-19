<?php
ob_start();
session_start();
// Koneksi ke database
$username = isset($_SESSION['username']) ? $_SESSION['username'] : '';
$username1 = 'admin';
// Database connection
include '../koneksi.php';


// Query to get the list of organizations and evaluators
$sql = "
    SELECT 
        o.nama_organisasi, 
        o.nama_responden AS nama_organisasi_responden, 
        pr.nama_penilai AS nama_penilai,
        pr.nip AS nip_penilai
    FROM penilai_user_access pua
    INNER JOIN organisasi o ON pua.id_organisasi = o.id_organisasi
    INNER JOIN profile_penilai pr ON pua.id_penilai = pr.id_penilai
    ORDER BY o.nama_organisasi ASC
";

$result = $conn->query($sql);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Organization and Evaluator List</title>
    <script type="text/javascript" src="../js/bootstrap.js"></script>
        <script type="text/javascript" src="../js/bootstrap.min.js"></script>
        <link href="../css/bootstrap.min.css" type="text/css" rel="stylesheet">
        <link href="../css/pelikan.css" type="text/css" rel="stylesheet">
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <style>
           <style>
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
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f9;
            margin: 20px;
            user-select: none; 
                outline: none; /* Menghilangkan outline fokus */
        }
        h1 {
            text-align: center;
            color: #333;
        }
        h3 {
        text-align: center; /* Menempatkan teks di tengah */
        color: #4535c1; /* Mengubah warna teks menjadi biru sesuai permintaan */
        }
        table {
            width: 100%;
            margin: 20px auto;
            border-collapse: collapse;
            background-color: #fff;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        }
        table, th, td {
            border: 1px solid #ddd;
        }
        th, td {
            padding: 15px;
            text-align: center;
        }
        th {
            background-color: #4535c1;
            color: white;
            text-transform: uppercase;
        }
        tr:nth-child(even) {
            background-color: #f9f9f9;
        }
        tr:hover {
            background-color: #f1f1f1;
        }
        .btn-download {
            background-color: #28a745;
            color: white;
            padding: 10px 20px;
            text-decoration: none;
            border-radius: 5px;
            border: none;
            font-size: 14px;
            cursor: pointer;
            transition: background-color 0.3s;
        }
        .btn-download:hover {
            background-color: #218838;
        }
          /* CSS untuk mengubah warna tulisan saat link aktif */
    .nav-link.active {
        color: white !important; /* Mengubah warna tulisan menjadi putih */
        background-color: #4535C1; /* Mengatur latar belakang jika aktif (ganti dengan warna yang diinginkan) */
    }
    
    /* CSS untuk mengatur warna default untuk link */
    .nav-link {
        color: black; /* Warna default untuk semua link */
    }
    
    /* CSS untuk logout */
    #logout {
        color: red; /* Warna merah untuk link logout */
    }
        table {
            width: 100%;
            border-collapse: collapse;
        }
        table, th, td {
            border: 1px solid black;
        }
        th, td {
            padding: 10px;
            text-align: left;
        }
    </style>
</head>
<body>
<?php
    include('navbar.php');  // Include navbar.php
?>
<h1 style='margin-top:100px;'>Unit Organisasi & Penilai</h1>

<table>
    <thead>
        <tr>
            <th>Organization Name</th>
            <th>Organization Respondent Name</th>
            <th>Evaluator Name</th>
            <th>NIP Penilai</th>

        </tr>
    </thead>
    <tbody>
        <?php
        if ($result->num_rows > 0) {
            // Output data for each row
            while($row = $result->fetch_assoc()) {
                echo "<tr>";
                echo "<td>" . htmlspecialchars($row['nama_organisasi']) . "</td>";
                echo "<td>" . htmlspecialchars($row['nama_organisasi_responden']) . "</td>";
                echo "<td>" . htmlspecialchars($row['nama_penilai']) . "</td>";
                echo "<td>" . htmlspecialchars($row['nip_penilai']) . "</td>";

                echo "</tr>";
            }
        } else {
            echo "<tr><td colspan='3'>No records found</td></tr>";
        }
        ?>
    </tbody>
</table>

</body>
</html>

<?php
// Close connection
$conn->close();
?>

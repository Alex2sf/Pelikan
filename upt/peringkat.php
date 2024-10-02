<?php
// Database connection
$host = 'localhost';  // Your database host
$dbname = 'sigh';  // Your database name
$username = 'root';  // Your database username
$password = '';  // Your database password

// Create connection using MySQLi
$conn = mysqli_connect($host, $username, $password, $dbname);

// Check connection
if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}

// Query to get organization rankings
$query = "
    SELECT 
        nama_organisasi, 
        (nilai_kategori1 + nilai_kategori2 + nilai_kategori3 + 
         nilai_kategori4 + nilai_kategori5 + nilai_kategori6) AS total_nilai 
    FROM 
        organisasi 
    ORDER BY 
        total_nilai DESC";

$result = mysqli_query($conn, $query);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Peringkat Organisasi</title>
    <style>
        table {
            width: 50%;
            margin: 20px auto;
            border-collapse: collapse;
        }
        table, th, td {
            border: 1px solid black;
        }
        th, td {
            padding: 10px;
            text-align: center;
        }
        th {
            background-color: #f2f2f2;
        }
    </style>
</head>
<body>

<h2 style="text-align: center;">Peringkat Organisasi Berdasarkan Total Nilai</h2>

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
                echo "<tr>";
                echo "<td>{$no}</td>";
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

</body>
</html>

<?php
// Close the connection
mysqli_close($conn);

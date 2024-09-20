<?php
// index.php

ob_start();
session_start();
$username="";
$username1=$_SESSION["role"];
// Database connection
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "emone";  // Change this to your database name

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
  die("Connection failed: " . $conn->connect_error);
}

// Fetch all unique eselon1 with their corresponding organizations
$sql = "SELECT DISTINCT unit_eselon1 FROM organisasi";
$result = $conn->query($sql);
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
           <style>
/* Body Styling */
body {
    font-family: Arial, sans-serif;
    background-color: #f4f6f9;
    padding-top: 100px;
}

/* Heading Styling */
h2 {
    font-size: 2.5em;
    font-weight: 300;
    text-align: center;
    color: #4535C1;
    margin-bottom: 30px;
    text-transform: uppercase;
    text-shadow: 0 2px 4px rgba(0, 0, 0, 0.2); 
}

/* Container Styling */
.container {
    max-width: 80%;
    margin: 0 auto;
    background-color: white;
    padding: 20px;
    border-radius: 10px;
    box-shadow: 0px 0px 10px rgba(0, 0, 0, 0.1);
}

/* Basic Table Styling */
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

/* Status Badge Styling */
.status {
    padding: 6px 12px;
    border-radius: 12px;
    color: white;
    background-color: #ff4d4d;
    font-weight: bold;
}

.status.completed {
    background-color: #00c851;
}

/* Make Table Responsive */
.table-wrapper {
    overflow-x: auto;
}

table {
    min-width: 600px;
}

/* Responsive Design for Mobile */
@media (max-width: 768px) {
    table {
        width: 100%;
        border: 0;
    }

    thead {
        display: none;
    }

    tbody tr {
        display: block;
        margin-bottom: 15px;
        border-bottom: 2px solid #ddd;
    }

    tbody td {
        display: block;
        width: 100%;
        text-align: right;
        padding-left: 50%;
        position: relative;
        border-bottom: 1px solid #ddd;
    }

    tbody td:before {
        content: attr(data-label);
        position: absolute;
        left: 0;
        width: 50%;
        padding-left: 15px;
        font-weight: bold;
        text-align: left;
    }
}

/* Dynamic Button Style */
button {
    background-color: #4535C1;
    color: white;
    padding: 10px 20px;
    border: none;
    border-radius: 5px;
    cursor: pointer;
    transition: background-color 0.3s ease;
}

button:hover {
    background-color: #3228A8;
    box-shadow: 0 0 30px rgba(69, 53, 193, 0.8), 0 0 20px rgba(255, 255, 255, 0.5); /* Stronger button glow */
    transition: all 0.3s ease-in-out;
}

/* Footer Styling */
footer {
    text-align: center;
    margin-top: 50px;
    color: #666;
}

/* Toggle Button for Extra Rows */
.toggle-btn {
    cursor: pointer;
    color: blue;
}

.hidden-row {
    display: none;
}

    </style>
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

    
<body>

<h2>Daftar Organisasi Berdasarkan Eselon</h2>

<!-- Table showing Eselon and Organizations -->
<table>
    <thead>
        <tr>
            <th>Nama Eselon</th>
            <th>Aksi</th>
        </tr>
    </thead>
    <tbody>
        <?php
        if ($result->num_rows > 0) {
            $index = 0;
            // Output data of each eselon
            while ($row = $result->fetch_assoc()) {
                $eselon = $row['unit_eselon1'];
                echo "<tr>";
                echo "<td><span class='toggle-btn' onclick='toggleOrganizations($index)'>➤ $eselon</span></td>";
                echo "<td></td>";  // Empty action column for the eselon row
                echo "</tr>";

                // Hidden row for the organizations under this eselon
                echo "<tr id='org-$index' class='hidden-row'>";
                echo "<td colspan='2'>";
                echo "<table style='width: 100%;'>";
                echo "<thead>";
                echo "<tr><th>Nama Organisasi</th><th>Aksi</th></tr>";
                echo "</thead>";
                echo "<tbody>";
                
                // Fetch organizations under this eselon
                $sql_org = "SELECT id_organisasi, nama_organisasi FROM organisasi WHERE unit_eselon1 = ?";
                $stmt = $conn->prepare($sql_org);
                $stmt->bind_param("s", $eselon);
                $stmt->execute();
                $org_result = $stmt->get_result();

                if ($org_result->num_rows > 0) {
                    while ($org_row = $org_result->fetch_assoc()) {
                        echo "<tr>";
                        echo "<td>" . $org_row['nama_organisasi'] . "</td>";
                        echo "<td>";
                        echo "<form action='change_password.php' method='POST'>";
                        echo "<input type='hidden' name='id_organisasi' value='" . $org_row['id_organisasi'] . "'>";
                        echo "<button type='submit'>Ganti Password</button>";
                        echo "</form>";
                        echo "</td>";
                        echo "</tr>";
                    }
                } else {
                    echo "<tr><td colspan='2'>No organizations found.</td></tr>";
                }
                
                echo "</tbody>";
                echo "</table>";
                echo "</td>";
                echo "</tr>";

                $index++;
            }
        }
        ?>
    </tbody>
</table>

</body>
</html>

<?php
$conn->close();
?>

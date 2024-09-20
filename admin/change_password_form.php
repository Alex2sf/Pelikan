<?php
// change_password_form.php

// Database connection
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "emone";  // Change this to your database name

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
  die("Connection failed: " . $conn->connect_error);
}

// Check if the organization ID is present
if (isset($_GET['id_organisasi'])) {
    $id_organisasi = $_GET['id_organisasi'];

    // Fetch the associated account for the organization
    $sql = "SELECT a.username 
            FROM akun_login a 
            JOIN organisasi o ON a.id_akun = o.id_akun
            WHERE o.id_organisasi = ?";
    
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $id_organisasi);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
        $username = $row['username'];
    } else {
        echo "No organization found.";
        exit();
    }
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $id_organisasi = $_POST['id_organisasi'];
    $new_password = $_POST['new_password'];

    // Hash the new password using md5 (not recommended for production)
    $hashed_password = md5($new_password);

    // Update the password in the akun_login table
    $sql = "UPDATE akun_login 
            SET password = ? 
            WHERE id_akun = (SELECT id_akun FROM organisasi WHERE id_organisasi = ?)";
    
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("si", $hashed_password, $id_organisasi);

    if ($stmt->execute()) {
        echo "Password updated successfully!";
    } else {
        echo "Error updating password: " . $conn->error;
    }
}

$conn->close();
?>

<!DOCTYPE html>
<html>
    <style>
        /* General Styles */
body {
    font-family: Arial, sans-serif;
    margin: 0;
    padding: 0;
    background-color: #f7f7f7;
    color: #333;
    display: flex;
    justify-content: center;
    align-items: center;
    height: 100vh;
}

h2 {
    font-size: 1.8rem;
    color: #4535C1; /* Primary color */
    text-align: center;
    margin-bottom: 30px;
}

form {
    background-color: #fff;
    padding: 30px;
    border-radius: 10px;
    box-shadow: 0px 8px 20px rgba(0, 0, 0, 0.1); /* Smooth shadow */
    max-width: 400px;
    width: 100%;
    margin: 0 auto;
    transition: transform 0.3s ease, box-shadow 0.3s ease;
}

/* Form hover effect */
form:hover {
    transform: translateY(-5px); /* Lift effect */
    box-shadow: 0px 10px 25px rgba(0, 0, 0, 0.15); /* Deeper shadow on hover */
}

/* Form labels and inputs */
label {
    font-weight: bold;
    color: #333;
    display: block;
    margin-bottom: 10px;
    font-size: 1rem;
}

input[type="password"] {
    width: 100%;
    padding: 10px;
    margin-bottom: 20px;
    border: 1px solid #ccc;
    border-radius: 5px;
    background-color: rgba(255, 255, 255, 0.9); /* Slightly transparent */
    transition: border-color 0.3s ease, box-shadow 0.3s ease;
}

/* Focused input style */
input[type="password"]:focus {
    border-color: #4535C1;
    box-shadow: 0px 0px 5px rgba(69, 53, 193, 0.3); /* Primary color shadow */
    outline: none;
}

/* Button styles */
button {
    width: 100%;
    padding: 12px 0;
    background-color: #4535C1; /* Primary button color */
    color: #fff;
    border: none;
    border-radius: 5px;
    font-size: 1rem;
    cursor: pointer;
    transition: background-color 0.3s ease, transform 0.3s ease, box-shadow 0.3s ease;
}

/* Hover and active state for button */
button:hover {
    background-color: #37299e; /* Darker shade on hover */
    transform: translateY(-2px); /* Slight lift on hover */
    box-shadow: 0px 4px 12px rgba(69, 53, 193, 0.3); /* Shadow on hover */
}

button:active {
    transform: translateY(0); /* Reset on click */
    box-shadow: none; /* Remove shadow on click */
}

/* Responsive styles */
@media (max-width: 600px) {
    form {
        padding: 20px;
        max-width: 90%; /* Slightly reduced width for smaller screens */
    }

    h2 {
        font-size: 1.6rem; /* Smaller title on mobile */
    }
}

    </style>
<head>
    <title>Change Password</title>
</head>
<body>

<h2>Change Password for <?php echo $username; ?></h2>

<form action="change_password_form.php" method="POST">
    <input type="hidden" name="id_organisasi" value="<?php echo $id_organisasi; ?>">
    <label for="new_password">New Password:</label>
    <input type="password" name="new_password" required>
    <br><br>
    <button type="submit">Update Password</button>
</form>
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

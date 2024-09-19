<?php
// change_password.php

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $id_organisasi = $_POST['id_organisasi'];

    // Redirect to the password change form with the organization ID
    header("Location: change_password_form.php?id_organisasi=$id_organisasi");
    exit();
}
?>

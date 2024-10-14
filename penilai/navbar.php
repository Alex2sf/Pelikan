<?php
// Mendapatkan nama halaman saat ini
$current_page = basename($_SERVER['PHP_SELF']);
?>

<nav class="navbar navbar-expand-lg bg-body-tertiary fixed-top" style="border-bottom: 2px solid #4535C1; height: 60px;">
    <div class="container-fluid fs-5">
        <a class="navbar-brand fs-5" href="#" style="padding-left:60px; padding-top:-10px">
            <img src="../img/pelikanlogo.png" alt="Logo" width="60" class="d-inline-block align-text-top">
        </a>
        <div class="pelikan">PELIKAN (penilai)</div>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarNav" style="padding-right:60px;">
            <ul class="nav nav-tabs ms-auto">
                <li class="nav-item px-2">
                    <a class="nav-link <?php echo ($current_page == 'penilai_beranda.php' ? 'active' : 'black'); ?>" href="penilai_beranda.php">Beranda</a>
                </li>
                <li class="nav-item px-2">
                    <a class="nav-link <?php echo ($current_page == 'list_organisasi.php' ? 'active' : 'black'); ?>" href="list_organisasi.php">Daftar Organisasi</a>
                </li>
                
                <?php
                if ($username == $username1) {
                    echo '<li class="nav-item">
                            <a class="nav-link black" href="../index.php">Login</a>
                          </li>';
                } else {
                    echo '<li class="nav-item">
                            <a class="nav-link text-danger" id="logout" href="logout_penilai.php" data-bs-toggle="modal" data-bs-target="#modalLogout">Logout</a>
                          </li>';
                }
                ?>
            </ul>
        </div>
    </div>
</nav>

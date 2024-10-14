<nav class="navbar navbar-expand-lg bg-body-tertiary fixed-top" style="border-bottom: 2px solid #4535C1; height: 60px;">
    <div class="container-fluid fs-5">
        <!-- Logo -->
        <a class="navbar-brand fs-5" href="#" style="padding-left: 60px; padding-top: -10px;">
            <img src="../img/pelikanlogo.png" alt="Logo" width="60" class="d-inline-block align-text-top">
        </a>

        <!-- Nama Aplikasi -->
        <div>Admin</div>

        <!-- Button Toggle untuk Mobile View -->
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>

        <!-- Menu Navbar -->
        <div class="collapse navbar-collapse" id="navbarNav" style="padding-right: 60px;">
            <ul class="nav nav-tabs ms-auto">
                <!-- Menu Beranda -->
                <li class="nav-item px-2">
                    <a class="nav-link <?php echo basename($_SERVER['PHP_SELF']) == 'admin_dashboard.php' ? 'active' : ''; ?>" aria-current="page" href="admin_dashboard.php" style="color: black;">Beranda</a>
                </li>

                <!-- Menu Daftar Akun -->
                <li class="nav-item px-2">
                    <a class="nav-link <?php echo basename($_SERVER['PHP_SELF']) == 'register.php' ? 'active' : ''; ?>" href="register.php" style="color: black;">Daftar Akun</a>
                </li>

                <!-- Kuesioner Dropdown -->
                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle <?php echo in_array(basename($_SERVER['PHP_SELF']), ['add_data.php', 'add_pertanyaan.php', 'daftar_organisasi.php', 'adminrud_kuesioner.php']) ? 'active' : ''; ?>" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false" style="color: black;">
                        Kuesioner
                    </a>
                    <ul class="dropdown-menu">
                        <li><a class="dropdown-item" href="add_data.php">Tambah Kategori Kuesioner</a></li>
                        <li><a class="dropdown-item" href="add_pertanyaan.php">Tambah Pertanyaan Kuesioner</a></li>
                        <li><a class="dropdown-item" href="daftar_organisasi.php">Hasil Kuesioner</a></li>
                        <li><a class="dropdown-item" href="adminrud_kuesioner.php">Edit Kuesioner</a></li>
                    </ul>
                </li>

                <!-- Akses Dropdown -->
                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle <?php echo in_array(basename($_SERVER['PHP_SELF']), ['admin_akses.php', 'akses_penilai.php', 'akses_waktuorganisasi.php']) ? 'active' : ''; ?>" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false" style="color: black;">
                        Akses
                    </a>
                    <ul class="dropdown-menu">
                        <li><a class="dropdown-item" href="admin_akses.php">Akses UNOR</a></li>
                        <li><a class="dropdown-item" href="akses_penilai.php">Akses Penilai</a></li>
                        <li><a class="dropdown-item" href="akses_waktuorganisasi.php">Akses Waktu Organisasi</a></li>
                    </ul>
                </li>

                <!-- List UNOR -->
                <li class="nav-item px-2">
                    <a class="nav-link <?php echo basename($_SERVER['PHP_SELF']) == 'Daftar.php' ? 'active' : ''; ?>" href="Daftar.php" style="color: black;">List UNOR</a>
                </li>

                <!-- Alur -->
                <li class="nav-item px-2">
                    <a class="nav-link <?php echo basename($_SERVER['PHP_SELF']) == 'alur_admin.php' ? 'active' : ''; ?>" href="alur_admin.php" style="color: black;">Alur</a>
                </li>

                <!-- Login/Logout Conditional -->
                <li class="nav-item px-2">
                    <?php
                    if ($username == $username1) {
                        echo '<a class="nav-link" href="login.php" style="color: black;">Login</a>';
                    } else {
                        echo '<a class="nav-link" id="logout" href="#" data-bs-toggle="modal" data-bs-target="#modalLogout" style="color: red;">Logout</a>';
                    }
                    ?>
                </li>
            </ul>
        </div>
    </div>
</nav>

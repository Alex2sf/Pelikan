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
                    <a class="nav-link <?php if(basename($_SERVER['PHP_SELF']) == 'index.php'){echo 'active';} ?>" href="index.php">Beranda</a>
                </li>
                <li class="nav-item px-2">
                    <a class="nav-link <?php if(basename($_SERVER['PHP_SELF']) == 'peringkat.php'){echo 'active';} ?>" href="peringkat.php">Peringkat</a>
                </li>
                <li class="nav-item px-2">
                    <a class="nav-link <?php if(basename($_SERVER['PHP_SELF']) == 'kuesioner_valid.php'){echo 'active';} ?>" href="kuesioner_valid.php">Kuesioner</a>
                </li>
                <li class="nav-item px-2">
                    <a class="nav-link <?php if(basename($_SERVER['PHP_SELF']) == 'alur.php'){echo 'active';} ?>" href="alur.php">Alur</a>
                </li>
                <?php
                if ($username==$username1){
                    echo '<li class="nav-item">
                    <a class="nav-link black" href="../login_new.php">Login</a>
                    </li>';
                } else {
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

<?php
$hal = isset($_GET['hal']) ? $_GET['hal'] : 'home';
?>

<nav class="main-header navbar navbar-expand-md navbar-light navbar-white">
    <div class="container">

        <!-- Brand -->
        <a href="<?= BASE_URL ?>" class="navbar-brand">
            <img src="<?= BASE_URL ?>assets/img/logo_yatim.png"
                alt="Logo"
                class="brand-image img-circle elevation-3"
                style="opacity:.9;width:35px;">
            <span class="brand-text font-weight-bold"><?= $site_name ?></span>
        </a>

        <!-- Burger -->
        <button class="navbar-toggler" type="button"
            data-toggle="collapse" data-target="#navbarCollapse">
            <span class="navbar-toggler-icon"></span>
        </button>

        <div class="collapse navbar-collapse" id="navbarCollapse">

            <!-- LEFT MENU -->
            <ul class="navbar-nav">

                <li class="nav-item">
                    <a href="<?= BASE_URL ?>?hal=home"
                        class="nav-link <?= ($hal == 'home') ? 'active' : '' ?>">
                        Beranda
                    </a>
                </li>

                <li class="nav-item">
                    <a href="<?= BASE_URL ?>?hal=bantuan"
                        class="nav-link <?= ($hal == 'bantuan') ? 'active' : '' ?>">
                        Program Bantuan
                    </a>
                </li>

                <li class="nav-item">
                    <a href="<?= BASE_URL ?>?hal=tentang"
                        class="nav-link <?= ($hal == 'tentang') ? 'active' : '' ?>">
                        Tentang Kami
                    </a>
                </li>

                <li class="nav-item">
                    <a href="<?= BASE_URL ?>?hal=kontak"
                        class="nav-link <?= ($hal == 'kontak') ? 'active' : '' ?>">
                        Kontak
                    </a>
                </li>

            </ul>

            <!-- RIGHT MENU -->
            <ul class="navbar-nav ml-auto">

                <!-- LOGIN PENERIMA -->
                <li class="nav-item mr-2">
                    <a href="<?= BASE_URL ?>?hal=loginpenerima"
                        class="btn btn-primary btn-sm <?= ($hal == 'loginpenerima') ? 'active' : '' ?>">
                        <i class="fas fa-hand-holding-heart"></i> Login Penerima
                    </a>
                </li>

                <!-- LOGIN ADMIN -->
                <li class="nav-item">
                    <a href="<?= BASE_URL ?>?hal=loginuser"
                        class="btn btn-danger btn-sm <?= ($hal == 'loginuser') ? 'active' : '' ?>">
                        <i class="fas fa-user-shield"></i> Login Admin
                    </a>
                </li>

            </ul>

        </div>
    </div>
</nav>

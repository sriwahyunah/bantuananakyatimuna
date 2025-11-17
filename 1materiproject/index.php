<?php
session_start();

// Jika belum login sebagai admin, arahkan ke login
if (!isset($_SESSION['admin'])) {
    header("Location: landing.php");
    exit;
}

ini_set('display_errors', 1);
error_reporting(E_ALL);
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <?php include 'pages/header.php'; ?>
</head>

<body class="hold-transition dark-mode sidebar-mini layout-fixed layout-navbar-fixed layout-footer-fixed sidebar-collapse">

<div class="wrapper">

    <!-- Preloader -->
    <div class="preloader flex-column justify-content-center align-items-center">
        <img class="animation__wobble" src="dist/img/AdminLTELogo.png" alt="AdminLTELogo" height="60" width="60">
    </div>

    <!-- NAVBAR -->
    <nav class="main-header navbar navbar-expand navbar-dark bg-dark">
        <?php include 'pages/navbar.php'; ?>
    </nav>

    <!-- SIDEBAR -->
    <aside class="main-sidebar sidebar-dark-primary elevation-4">
        <?php include 'pages/sidebar.php'; ?>
    </aside>

    <!-- CONTENT WRAPPER -->
    <div class="content-wrapper">
        <section class="content p-3">

            <?php
            $halaman = $_GET['halaman'] ?? 'landingafterlogin';

            $routes = [
                'admin' => 'views/admin/admin.php',
                'tambahadmin' => 'views/admin/tambahadmin.php',
                'editadmin' => 'views/admin/editadmin.php',

                'penerima' => 'views/penerima/penerima.php',
                'tambahpenerima' => 'views/penerima/tambahpenerima.php',
                'editpenerima' => 'views/penerima/editpenerima.php',

                'bantuan' => 'views/bantuan/bantuan.php',
                'tambahbantuan' => 'views/bantuan/tambahbantuan.php',
                'editbantuan' => 'views/bantuan/editbantuan.php',

                'transaksi' => 'views/transaksi/transaksi.php',
                'tambahtransaksi' => 'views/transaksi/tambahtransaksi.php',
                'edittransaksi' => 'views/transaksi/edittransaksi.php',

                'profile' => 'views/profile.php',

                'dashboard' => 'views/dashboard.php',
                'home' => 'views/dashboard.php',

                'landingafterlogin' => 'views/landingafterlogin.php'
            ];

            if (array_key_exists($halaman, $routes) && file_exists($routes[$halaman])) {
                include $routes[$halaman];
            } else {
                include 'views/dashboard.php';
            }
            ?>

        </section>
    </div>

    <!-- FOOTER -->
    <footer class="main-footer text-center">
        <?php include 'pages/footer.php'; ?>
    </footer>

</div>

<!-- SCRIPTS -->
<script src="plugins/jquery/jquery.min.js"></script>
<script src="plugins/bootstrap/js/bootstrap.bundle.min.js"></script>
<script src="plugins/overlayScrollbars/js/jquery.overlayScrollbars.min.js"></script>
<script src="dist/js/adminlte.js"></script>
<script src="plugins/chart.js/Chart.min.js"></script>

</body>
</html>

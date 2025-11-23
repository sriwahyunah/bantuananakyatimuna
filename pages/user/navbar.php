<?php
// ==============================================
// File: pages/user/navbar.php
// Dibuat ulang sesuai struktur database pada gambar
// ==============================================

$namauser = $_SESSION['namauser'] ?? 'Pengguna';
$role     = $_SESSION['role']     ?? 'user';  // enum: admin, petugas, editor
$foto     = $_SESSION['foto']     ?? 'default.png';

// Dashboard otomatis berdasarkan role
$dashboard = [
    'admin'   => 'dashboardadmin',
    'petugas' => 'dashboardpetugas',
    'editor'  => 'dashboardeditor'
];

$dashboard_url = BASE_URL . '?hal=' . ($dashboard[$role] ?? 'dashboardadmin');

// Logout semua role sama
$logout_url = BASE_URL . '?hal=logout';



/**
 * =====================================================
 * Breadcrumb Otomatis
 * =====================================================
 */
if (!function_exists('buat_breadcrumb_otomatis')) {

    function buat_breadcrumb_otomatis()
    {
        $hal = $_GET['hal'] ?? 'dashboardadmin';

        // Jika dashboard → breadcrumb simple
        if (str_contains($hal, 'dashboard')) {
            echo '
            <ol class="breadcrumb float-sm-right">
                <li class="breadcrumb-item active">Dashboard</li>
            </ol>';
            return;
        }

        // Modul utama sesuai database
        $fallbacks = [
            'admin'     => 'admin/daftaradmin',
            'user'      => 'user/daftaruser',
            'penerima'  => 'penerima/daftarpenerima',
            'bantuan'   => 'bantuan/daftarbantuan',
            'transaksi' => 'transaksi/daftartransaksi',
        ];

        $parts = explode('/', $hal);
        $breadcrumb = [];

        // Link pertama: Dashboard
        $breadcrumb[] = '<li class="breadcrumb-item"><a href="?hal=dashboardadmin">Dashboard</a></li>';

        // Loop membuat breadcrumb otomatis
        for ($i = 0; $i < count($parts); $i++) {
            $segment   = ucfirst(str_replace(['_', '-'], ' ', $parts[$i]));
            $clean_seg = htmlspecialchars($segment);

            if ($i < count($parts) - 1) {
                // Parent
                $parent = $parts[$i];

                $suburl = '?hal=' . ($fallbacks[$parent] ?? implode('/', array_slice($parts, 0, $i + 1)));

                $breadcrumb[] = '<li class="breadcrumb-item"><a href="' . $suburl . '">' . $clean_seg . '</a></li>';
            } else {
                // Last segment = aktif
                $breadcrumb[] = '<li class="breadcrumb-item active">' . $clean_seg . '</li>';
            }
        }

        echo '<ol class="breadcrumb float-sm-right">' . implode('', $breadcrumb) . '</ol>';
    }
}



/**
 * =====================================================
 * Judul Halaman Otomatis
 * =====================================================
 */
if (!function_exists('judul_halaman_otomatis')) {
    function judul_halaman_otomatis()
    {
        $hal = $_GET['hal'] ?? 'dashboardadmin';

        if (str_contains($hal, 'dashboard')) {
            return 'Dashboard';
        }

        $parts = explode('/', $hal);
        return ucfirst(str_replace(['_', '-'], ' ', end($parts)));
    }
}

?>

<!-- ============================================== -->
<!-- NAVBAR ATAS -->
<!-- ============================================== -->
<nav class="main-header navbar navbar-expand navbar-white navbar-light">

  <!-- Menu kiri -->
  <ul class="navbar-nav">
    <li class="nav-item">
      <a class="nav-link" data-widget="pushmenu" href="#" role="button">
        <i class="fas fa-bars"></i>
      </a>
    </li>

    <li class="nav-item d-none d-sm-inline-block">
      <a href="<?= $dashboard_url ?>" class="nav-link">Beranda</a>
    </li>
  </ul>

  <!-- Menu kanan -->
  <ul class="navbar-nav ml-auto">
    <li class="nav-item dropdown user-menu">
      <a href="#" class="nav-link dropdown-toggle" data-toggle="dropdown">
        
        <img src="<?= BASE_URL ?>uploads/user/<?= $foto ?>"
             class="img-circle elevation-2"
             style="width:30px;height:30px;object-fit:cover;">

        <?= htmlspecialchars($namauser); ?> (<?= htmlspecialchars($role); ?>)
      </a>

      <ul class="dropdown-menu dropdown-menu-right">
        <li><a class="dropdown-item" href="#"><i class="fas fa-id-card mr-2"></i> Profil</a></li>
        <li><a class="dropdown-item text-danger" href="<?= $logout_url ?>">
            <i class="fas fa-sign-out-alt mr-2"></i> Logout
        </a></li>
      </ul>
    </li>
  </ul>

</nav>


<!-- ============================================== -->
<!-- CONTENT WRAPPER -->
<!-- ============================================== -->
<div class="content-wrapper">

  <div class="content-header">
    <div class="container-fluid d-flex justify-content-between align-items-center">
      <h5 class="m-0"><?= judul_halaman_otomatis(); ?></h5>
      <?php buat_breadcrumb_otomatis(); ?>
    </div>
  </div>

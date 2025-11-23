<?php
// =======================================
// File: pages/user/sidebarpetugas.php
// Sidebar PETUGAS (tanpa kelola user)
// =======================================

if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

require_once __DIR__ . '/../../includes/path.php';
require_once __DIR__ . '/../../includes/koneksi.php';

// DATA USER LOGIN
$id_user = $_SESSION['id_user'] ?? 0;
$queryUser = mysqli_query($koneksi, "SELECT * FROM user WHERE id_user='$id_user'");
$dataUser = mysqli_fetch_assoc($queryUser);

$namaUser = $dataUser['nama_user'] ?? 'Petugas';
$fotoUser = $dataUser['foto'] ?? 'default.png';
?>

<aside class="main-sidebar sidebar-dark-primary elevation-4">
  <a href="dashboard.php?hal=dashboardpetugas" class="brand-link text-center">
    <span class="brand-text font-weight-bold">Bantuan Anak Yatim</span>
  </a>

  <div class="sidebar">

    <!-- Panel User -->
    <div class="user-panel mt-3 pb-3 mb-3 d-flex">
      <div class="image">
        <img src="<?= BASE_URL ?>uploads/user/<?= htmlspecialchars($fotoUser) ?>" 
             class="img-circle elevation-2" alt="User Image">
      </div>
      <div class="info">
        <a href="#" class="d-block"><?= htmlspecialchars($namaUser) ?> (Petugas)</a>
      </div>
    </div>

    <!-- MENU -->
    <nav class="mt-2">
      <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview">

        <!-- Dashboard -->
        <li class="nav-item">
          <a href="dashboard.php?hal=dashboardpetugas" class="nav-link">
            <i class="nav-icon fas fa-home"></i>
            <p>Dashboard</p>
          </a>
        </li>

        <!-- Bantuan -->
        <li class="nav-item">
          <a href="dashboard.php?hal=bantuan/daftarbantuan" class="nav-link">
            <i class="nav-icon fas fa-hand-holding-heart"></i>
            <p>Kelola Bantuan</p>
          </a>
        </li>

        <!-- Penerima -->
        <li class="nav-item">
          <a href="dashboard.php?hal=penerima/daftarpenerima" class="nav-link">
            <i class="nav-icon fas fa-users"></i>
            <p>Kelola Penerima</p>
          </a>
        </li>

        <!-- Transaksi -->
        <li class="nav-item">
          <a href="dashboard.php?hal=transaksi/daftartransaksi" class="nav-link">
            <i class="nav-icon fas fa-exchange-alt"></i>
            <p>Transaksi Pembayaran</p>
          </a>
        </li>

        <!-- Laporan -->
        <li class="nav-item">
          <a href="dashboard.php?hal=laporan/daftarlaporan" class="nav-link">
            <i class="nav-icon fas fa-file-alt"></i>
            <p>Laporan</p>
          </a>
        </li>

      </ul>
    </nav>

  </div>
</aside>

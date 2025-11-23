<?php
// =======================================
// File: dashboard.php - Routing Backend Bantuan Anak Yatim
// =======================================

require_once __DIR__ . '/includes/path.php';
require_once INCLUDES_PATH . 'konfig.php';
require_once INCLUDES_PATH . 'koneksi.php';
require_once INCLUDES_PATH . 'fungsivalidasi.php';

session_start();

// =======================================
// 1️⃣ Tentukan Role & Folder View
// =======================================
$role = $_SESSION['role'] ?? '';

switch ($role) {
    case 'petugas':
        $viewFolder = 'views/petugas';
        $defaultPage = 'dashboardpetugas';
        break;

    case 'penerima':
        $viewFolder = 'views/penerima';
        $defaultPage = 'dashboardpenerima';
        break;

    default: // admin
        $viewFolder = 'views/admin';
        $defaultPage = 'dashboardadmin';
        break;
}

// =======================================
// 2️⃣ Ambil halaman yg diminta
// =======================================
$hal = $_GET['hal'] ?? $defaultPage;
$halPath = explode('/', $hal);

// =======================================
// 3️⃣ Build real path berdasarkan struktur folder
// =======================================
if (count($halPath) > 1) {
    // contoh: ?hal=bantuan/daftarbantuan
    $module = $halPath[0]; 
    $page   = $halPath[1];
    $file = BASE_PATH . "/{$viewFolder}/{$module}/{$page}.php";

} else {
    // contoh: ?hal=dashboardadmin
    $file = BASE_PATH . "/{$viewFolder}/{$hal}.php";
}

// =======================================
// 4️⃣ Fallback jika file tidak ditemukan
// =======================================
if (!file_exists($file)) {

    // fallback modul utama berdasarkan ERD
    $fallbacks = [
        'user'      => 'user/daftaruser',
        'admin'     => 'admin/daftaradmin',
        'bantuan'   => 'bantuan/daftarbantuan',
        'penerima'  => 'penerima/daftarpenerima',
        'transaksi' => 'transaksi/daftartransaksi',
        'laporan'   => 'laporan/daftarlaporan'
    ];

    $parent = $halPath[0] ?? '';

    if (isset($fallbacks[$parent])) {
        $file = BASE_PATH . "/{$viewFolder}/" . $fallbacks[$parent] . ".php";
    } else {
        // fallback default dashboard
        $file = BASE_PATH . "/{$viewFolder}/{$defaultPage}.php";
    }
}

// =======================================
// 5️⃣ Load file view
// =======================================
include $file;

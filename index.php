<?php
// =======================================================
// File: index.php (root)
<<<<<<< HEAD
// Deskripsi: Routing utama tampilan publik peminjamanalatrpl
// =======================================================

// Load config, koneksi, path
=======
// Routing utama Aplikasi Bantuan Anak Yatim UNA2
// =======================================================

// Debug (matikan saat production)
error_reporting(E_ALL);
ini_set('display_errors', 1);

// Load path, config, koneksi
>>>>>>> 28924cc2c2fede24d1e338ee57a7af3c314455d0
require_once __DIR__ . '/includes/path.php';
require_once INCLUDES_PATH . 'konfig.php';
require_once INCLUDES_PATH . 'koneksi.php';

// Mulai session
session_start();

// =======================================================
<<<<<<< HEAD
// AUTO REDIRECT JIKA SUDAH LOGIN (FIX LOGOUT)
// =======================================================
// Perbaikan:
// - HANYA redirect jika login === true
// - Role saja tidak cukup, agar logout tidak kembali ke dashboard
// =======================================================
if (isset($_SESSION['login']) && $_SESSION['login'] === true) {

    if (isset($_SESSION['role'])) {
        switch ($_SESSION['role']) {

        

            case 'petugas':
                header("Location: " . BASE_URL . "dashboard.php?hal=dashboardpetugas");
                exit;

            case 'peminjam':
                header("Location: " . BASE_URL . "dashboard.php?hal=dashboardpeminjam");
                exit;
        }
    }
}

// Ambil parameter ?hal (default = home)
$halaman = isset($_GET['hal']) ? trim($_GET['hal']) : 'home';

// Sanitasi agar tidak bisa traversal file
$halaman = basename(str_replace('.php', '', $halaman));


// =======================================================
//                  ROUTING LANDING
// =======================================================
switch ($halaman) {

    case '':
    case 'home':
        $file_view = VIEWS_PATH . 'landing/home.php';
        break;

    case 'kategori':
        $file_view = VIEWS_PATH . 'landing/kategori.php';
        break;

    case 'detilbantuan':
        $file_view = VIEWS_PATH . 'landing/detilbantuan.php';
        break;

    case 'tentang':
        $file_view = VIEWS_PATH . 'landing/tentang.php';
        break;

    case 'kontak':
        $file_view = VIEWS_PATH . 'landing/kontak.php';
        break;

    case 'hashbycrypt':
        $file_view = VIEWS_PATH . 'landing/hashbycrypt.php';
        break;

    // LOGIN USER
    case 'loginuser':
        $file_view = VIEWS_PATH . 'otentikasiuser/loginuser.php';
        break;

    case 'prosesloginuser':
        $file_view = VIEWS_PATH . 'otentikasiuser/prosesloginuser.php';
        break;

    case 'logoutuser':
        $file_view = VIEWS_PATH . 'otentikasiuser/logoutuser.php';
        break;

    // LOGIN PEMINJAM
    case 'loginpeminjam':
        $file_view = VIEWS_PATH . 'otentikasipeminjam/loginpeminjam.php';
        break;

    case 'registerpeminjam':
        $file_view = VIEWS_PATH . 'otentikasipeminjam/registerpeminjam.php';
        break;

    case 'prosesregisterpeminjam':
        $file_view = VIEWS_PATH . 'otentikasipeminjam/prosesregisterpeminjam.php';
        break;

    case 'prosesloginpeminjam':
        $file_view = VIEWS_PATH . 'otentikasipeminjam/prosesloginpeminjam.php';
        break;

    case 'logoutpeminjam':
        $file_view = VIEWS_PATH . 'otentikasipeminjam/logoutpeminjam.php';
        break;

    // Komentar publik
    case 'proseskomentar':
        $file_view = VIEWS_PATH . 'landing/proseskomentar.php';
        break;

=======
// Ambil parameter ?hal=
// =======================================================
$hal = isset($_GET['hal']) ? trim($_GET['hal']) : 'home';

// Sanitasi
$hal = strtolower(basename(str_replace('.php', '', $hal)));


// =======================================================
//                    ROUTING SYSTEM
//   (SAMA PERSIS DENGAN PEMINJAMNALATRPL, 
//    NAMUN DISINKRONKAN DENGAN FITUR APK INI)
// =======================================================

switch ($hal) {

    // ---------------------------------------------------
    // HALAMAN LANDING
    // ---------------------------------------------------
    case '':
    case 'home':
        $file_view = VIEWS_PATH . 'landing/home.php';
        break;

    case 'tentang':
        $file_view = VIEWS_PATH . 'landing/tentang.php';
        break;

    case 'kontak':
        $file_view = VIEWS_PATH . 'landing/kontak.php';
        break;

    case 'kategori':
        $file_view = VIEWS_PATH . 'landing/kategori.php';
        break;

    case 'detilbantuan':
        $file_view = VIEWS_PATH . 'landing/detilbantuan.php';
        break;

    case 'proseskomentar':
        $file_view = VIEWS_PATH . 'landing/proseskomentar.php';
        break;


    // ---------------------------------------------------
    // OTENTIKASI ADMIN/PETUGAS
    // ---------------------------------------------------
    case 'loginuser':
        $file_view = VIEWS_PATH . 'otentikasiuser/loginuser.php';
        break;

    case 'prosesloginuser':
        $file_view = VIEWS_PATH . 'otentikasiuser/prosesloginuser.php';
        break;

    case 'logoutuser':
        $file_view = VIEWS_PATH . 'otentikasiuser/logoutuser.php';
        break;

    case 'registeruser':
        $file_view = VIEWS_PATH . 'otentikasiuser/registeruser.php';
        break;


    // ---------------------------------------------------
    // OTENTIKASI PENERIMA
    // ---------------------------------------------------
    case 'loginpenerima':
        $file_view = VIEWS_PATH . 'otentikasipenerima/loginpenerima.php';
        break;

    case 'prosesloginpenerima':
        $file_view = VIEWS_PATH . 'otentikasipenerima/prosesloginpenerima.php';
        break;

    case 'registerpenerima':
        $file_view = VIEWS_PATH . 'otentikasipenerima/registerpenerima.php';
        break;

    case 'prosesregisterpenerima':
        $file_view = VIEWS_PATH . 'otentikasipenerima/prosesregisterpenerima.php';
        break;

    case 'logoutpenerima':
        $file_view = VIEWS_PATH . 'otentikasipenerima/logoutpenerima.php';
        break;


    // ---------------------------------------------------
    // DASHBOARD PENERIMA
    // ---------------------------------------------------
    case 'dashboardpenerima':
    case 'tambahpenerimaan':
    case 'riwayatpenerimaan':
    case 'prosespenerimaan':

        // wajib login
        if (!isset($_SESSION['id_penerima'])) {
            header("Location: ?hal=loginpenerima");
            exit;
        }

        // routing file dashboard penerima
        $file_view = VIEWS_PATH . 'penerima/' . $hal . '.php';

        // template khusus penerima
        include PAGES_PATH . 'penerima/header.php';
        include PAGES_PATH . 'penerima/navbar.php';

        if (file_exists($file_view)) {
            include $file_view;
        } else {
            include VIEWS_PATH . 'landing/404.php';
        }

        include PAGES_PATH . 'penerima/footer.php';
        exit;


    // ---------------------------------------------------
    // JIKA TIDAK ADA HALAMAN
    // ---------------------------------------------------
>>>>>>> 28924cc2c2fede24d1e338ee57a7af3c314455d0
    default:
        $file_view = VIEWS_PATH . 'landing/404.php';
        break;
}


// =======================================================
<<<<<<< HEAD
//        TEMPLATE LANDING (header → navbar → content)
// =======================================================
include PAGES_PATH . 'landing/header.php';
include PAGES_PATH . 'landing/navbar.php';

// Hero hanya muncul di home
if ($halaman === 'home') {
    include PAGES_PATH . 'landing/hero.php';
}

// Muat konten
=======
//   TEMPLATE LANDING (header → navbar → konten → footer)
// =======================================================

include PAGES_PATH . 'landing/header.php';
include PAGES_PATH . 'landing/navbar.php';

// Hero khusus di home
if ($hal === 'home') {
    include PAGES_PATH . 'landing/hero.php';
}

// Konten
>>>>>>> 28924cc2c2fede24d1e338ee57a7af3c314455d0
if (file_exists($file_view)) {
    include $file_view;
} else {
    include VIEWS_PATH . 'landing/404.php';
}
<<<<<<< HEAD

include PAGES_PATH . 'landing/footer.php';
=======

include PAGES_PATH . 'landing/footer.php';

>>>>>>> 28924cc2c2fede24d1e338ee57a7af3c314455d0

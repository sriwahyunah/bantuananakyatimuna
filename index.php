<?php
// =======================================================
// File: index.php (root)
// Routing utama Aplikasi Bantuan Anak Yatim UNA2
// =======================================================

// Debug (matikan saat production)
error_reporting(E_ALL);
ini_set('display_errors', 1);

// Load path, config, koneksi
require_once __DIR__ . '/includes/path.php';
require_once INCLUDES_PATH . 'konfig.php';
require_once INCLUDES_PATH . 'koneksi.php';

// Mulai session
session_start();

// =======================================================
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
    default:
        $file_view = VIEWS_PATH . 'landing/404.php';
        break;
}


// =======================================================
//   TEMPLATE LANDING (header → navbar → konten → footer)
// =======================================================

include PAGES_PATH . 'landing/header.php';
include PAGES_PATH . 'landing/navbar.php';

// Hero khusus di home
if ($hal === 'home') {
    include PAGES_PATH . 'landing/hero.php';
}

// Konten
if (file_exists($file_view)) {
    include $file_view;
} else {
    include VIEWS_PATH . 'landing/404.php';
}

include PAGES_PATH . 'landing/footer.php';


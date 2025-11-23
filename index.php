<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);
session_start();

// --- Load config, koneksi, path ---
require_once __DIR__ . '/includes/path.php';
require_once INCLUDES_PATH . 'konfig.php';
require_once INCLUDES_PATH . 'koneksi.php';

// --- Ambil parameter ?hal
$hal = strtolower(trim($_GET['hal'] ?? 'home'));
$hal = basename(str_replace('.php', '', $hal));

// --- Helper: pilih file view dari beberapa kandidat ---
function pick_view(array $paths)
{
    foreach ($paths as $p) {
        if (file_exists($p)) return $p;
    }
    return false;
}

// --- ROUTES BERSIH ---
$routes = [

    // LANDING PAGES
    'home'           => [VIEWS_PATH . 'landing/home.php'],
    'tentang'        => [VIEWS_PATH . 'landing/tentang.php'],
    'kontak'         => [VIEWS_PATH . 'landing/kontak.php'],
    'bantuan'        => [VIEWS_PATH . 'landing/bantuan.php'],
    'penerima'       => [VIEWS_PATH . 'landing/penerima.php'],
    'detailbantuan'  => [VIEWS_PATH . 'landing/detailbantuan.php'],
    'detailpenerima' => [VIEWS_PATH . 'landing/detailpenerima.php'],

    // OTENTIKASI USER (admin/petugas)
    'loginuser'       => [VIEWS_PATH . 'otentikasiuser/login.php'],
    'prosesloginuser' => [VIEWS_PATH . 'otentikasiuser/proseslogin.php'],
    'logoutuser'      => [VIEWS_PATH . 'otentikasiuser/logout.php'],

    // OTENTIKASI PENERIMA
    'loginpenerima'       => [VIEWS_PATH . 'otentikasipenerima/loginpenerima.php'],
    'prosesloginpenerima' => [VIEWS_PATH . 'otentikasipenerima/prosesloginpenerima.php'],
    'registerpenerima'    => [VIEWS_PATH . 'otentikasipenerima/registerpenerima.php'],
    'logoutpenerima'      => [VIEWS_PATH . 'otentikasipenerima/logoutpenerima.php'],

    // DASHBOARD PENERIMA
    'dashboardpenerima' => [PAGES_PATH . 'penerima/dashboardpenerima.php'],
];

// pilih file
$file_view = $routes[$hal] ?? false;
$file_view = pick_view($file_view ?: []);

// daftar halaman yang perlu login penerima
$halaman_penerima = ['dashboardpenerima'];

// ========== TEMPLATE: DASHBOARD PENERIMA ==========
if (in_array($hal, $halaman_penerima, true)) {

    if (!isset($_SESSION['id_penerima'])) {
        header("Location: ?hal=loginpenerima");
        exit;
    }

    include PAGES_PATH . "penerima/header.php";
    include PAGES_PATH . "penerima/navbar.php";

    include ($file_view ?: VIEWS_PATH . "landing/404.php");

    include PAGES_PATH . "penerima/footer.php";
    exit;
}

// ========== TEMPLATE: LANDING ==========
include PAGES_PATH . "landing/header.php";
include PAGES_PATH . "landing/navbar.php";

if ($hal === "home" && file_exists(PAGES_PATH . "landing/hero.php")) {
    include PAGES_PATH . "landing/hero.php";
}

include ($file_view ?: VIEWS_PATH . "landing/404.php");

include PAGES_PATH . "landing/footer.php";

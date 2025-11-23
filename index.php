<?php
// =======================================================
// File: index.php (root) — ROUTING UTAMA (versi final tolerant)
// =======================================================

/**
 * Perubahan utama:
 * - Router menerima view yang berada di either:
 *     a) VIEWS_PATH . 'otentikasipenerima/xxx.php'  OR
 *     b) VIEWS_PATH . 'xxx.php'
 *   sehingga tidak langsung memicu 404 bila file belum dipindah.
 * - Debug helper untuk melihat file yang dicari.
 * - Proteksi session untuk hal penerima.
 */

// --- DEBUG / ENV (aktifkan saat dev, matikan di production) ---
error_reporting(E_ALL);
ini_set('display_errors', 1);

// --- Load config, koneksi, path ---
require_once __DIR__ . '/includes/path.php';
require_once INCLUDES_PATH . 'konfig.php';
require_once INCLUDES_PATH . 'koneksi.php';

// --- Start session (harus sebelum output apapun) ---
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

// --- Ambil parameter ?hal dan sanitasi ---
$hal_raw = $_GET['hal'] ?? 'home';
$hal = trim($hal_raw);
$hal = strtolower($hal);
$hal = basename(str_replace('.php', '', $hal)); // hindari path traversal

// --- Helper: pilih file view dari beberapa kandidat ---
function pick_view(array $candidates) {
    foreach ($candidates as $c) {
        if (file_exists($c)) return $c;
    }
    return false;
}

// --- Helper: include view atau 404 ---
function include_view_or_404(string $file_view) {
    if ($file_view && file_exists($file_view)) {
        include $file_view;
    } else {
        include VIEWS_PATH . 'landing/404.php';
    }
}

// --- Routing map: setiap route berisi array kandidat path ---
$routes = [
    // landing
    'home'            => [ VIEWS_PATH . 'landing/home.php' ],
    'tentang'         => [ VIEWS_PATH . 'landing/tentang.php' ],
    'kontak'          => [ VIEWS_PATH . 'landing/kontak.php' ],
    'bantuan'         => [ VIEWS_PATH . 'landing/bantuan.php' ],
    'penerima'        => [ VIEWS_PATH . 'landing/penerima.php' ],
    'detailbantuan'   => [ VIEWS_PATH . 'landing/detailbantuan.php' ],
    'detailpenerima'  => [ VIEWS_PATH . 'landing/detailpenerima.php' ],

    // otentikasi admin/petugas
    'loginuser'       => [ VIEWS_PATH . 'otentikasi/login.php' ],
    'prosesloginuser' => [ VIEWS_PATH . 'otentikasi/proseslogin.php' ],
    'logoutuser'      => [ VIEWS_PATH . 'otentikasi/logout.php' ],

    // otentikasi penerima (dualisme paths: subfolder atau langsung di views/)
    'loginpenerima'       => [
        VIEWS_PATH . 'otentikasipenerima/loginpenerima.php',
        VIEWS_PATH . 'loginpenerima.php'
    ],
    'prosesloginpenerima' => [
        VIEWS_PATH . 'otentikasipenerima/prosesloginpenerima.php',
        VIEWS_PATH . 'prosesloginpenerima.php'
    ],
    'logoutpenerima'      => [
        VIEWS_PATH . 'otentikasipenerima/logoutpenerima.php',
        VIEWS_PATH . 'logoutpenerima.php'
    ],
    'registerpenerima'    => [
        VIEWS_PATH . 'otentikasipenerima/registerpenerima.php',
        VIEWS_PATH . 'registerpenerima.php'
    ],

    // dashboard penerima (pages folder)
    'dashboardpenerima'   => [ PAGES_PATH . 'penerima/dashboardpenerima.php' ],
];

// --- Tentukan file_view berdasarkan map (cari kandidat yang ada) ---
$file_view = false;
if (array_key_exists($hal, $routes)) {
    $file_view = pick_view($routes[$hal]);
} else {
    // default 404 view
    $file_view = VIEWS_PATH . 'landing/404.php';
}

// --- Daftar hal yang memakai template penerima (after-login) ---
$hal_penerima = [
    'dashboardpenerima',
    // tambah nama route lain yang perlu template penerima
];

// --- Jika hal penerima: proteksi session & include template penerima ---
if (in_array($hal, $hal_penerima, true)) {
    if (!isset($_SESSION['id_penerima'])) {
        header('Location: ?hal=loginpenerima');
        exit;
    }

    $header = PAGES_PATH . 'penerima/header.php';
    $navbar = PAGES_PATH . 'penerima/navbar.php';
    $footer = PAGES_PATH . 'penerima/footer.php';

    if (file_exists($header)) include $header;
    if (file_exists($navbar)) include $navbar;

    // include the page or 404
    include_view_or_404($file_view);

    if (file_exists($footer)) include $footer;
    exit;
}

// --- TEMPLATE LANDING (default) ---
$landing_header = PAGES_PATH . 'landing/header.php';
$landing_navbar = PAGES_PATH . 'landing/navbar.php';
$landing_footer = PAGES_PATH . 'landing/footer.php';
$landing_hero = PAGES_PATH . 'landing/hero.php';

if (file_exists($landing_header)) include $landing_header;
if (file_exists($landing_navbar)) include $landing_navbar;

if ($hal === 'home' && file_exists($landing_hero)) include $landing_hero;

// === DEBUG INFO SEMENTARA (non-production)
// Jika Anda masih mengalami 404, aktifkan blok berikut untuk melihat path yang dicek.
// echo "DEBUG: hal = $hal<br>";
// echo "DEBUG: file_view = " . ($file_view ? $file_view : 'none') . "<br>";
// echo "DEBUG: exists = " . ($file_view && file_exists($file_view) ? 'YES' : 'NO') . "<br>";
// exit;

include_view_or_404($file_view);

if (file_exists($landing_footer)) include $landing_footer;

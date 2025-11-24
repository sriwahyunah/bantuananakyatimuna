<?php
// =======================================
// File: dashboard.php - FIXED + ADMIN SUPPORT
// Routing Backend bantuananakyatimuna
// =======================================

require_once __DIR__ . '/includes/path.php';
require_once INCLUDES_PATH . 'konfig.php';
require_once INCLUDES_PATH . 'koneksi.php';
require_once INCLUDES_PATH . 'fungsivalidasi.php';

if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

// =======================================
// 0️⃣ Allow Logout Without Blocking
// =======================================
if (isset($_GET['hal'])) {
    if ($_GET['hal'] === 'logoutuser') {
        include VIEWS_PATH . 'otentikasiuser/logoutuser.php';
        exit;
    }

    if ($_GET['hal'] === 'logoutpenerima') {
        include VIEWS_PATH . 'otentikasipenerima/logoutpenerima.php';
        exit;
    }
}

// =======================================
// 1️⃣ Login Check
// =======================================
if (!isset($_SESSION['login']) || $_SESSION['login'] !== true) {

    if (isset($_SESSION['role']) && $_SESSION['role'] === 'penerima') {
        header("Location: " . BASE_URL . "?hal=loginpenerima");
        exit;
    }

    header("Location: " . BASE_URL . "?hal=loginuser");
    exit;
}

// =======================================
// 2️⃣ Detect Role
// =======================================
$role = $_SESSION['role'] ?? '';

switch ($role) {

    case 'admin':
        $viewFolder = 'views/admin';
        $defaultPage = 'dashboardadmin';
        break;

    case 'petugas':
        $viewFolder = 'views/user';
        $defaultPage = 'dashboardpetugas';
        break;

    case 'penerima':
        $viewFolder = 'views/penerima';
        $defaultPage = 'dashboardpenerima';
        break;

    default:
        include BASE_PATH . "/views/notfound.php";
        exit;
}

// =======================================
// 3️⃣ Read Requested Page
// =======================================
$hal = $_GET['hal'] ?? $defaultPage;
$halParts = explode('/', $hal);

// =======================================
// 4️⃣ ROLE PROTECTION
// =======================================

// ❌ PETUGAS tidak boleh buka menu tertentu
$petugasBlocked = ['user', 'bantuan', 'transaksi', 'penerima'];

if ($role === 'petugas') {
    $reqModule = $halParts[0] ?? '';
    if (in_array($reqModule, $petugasBlocked)) {
        include BASE_PATH . "/views/notfound.php";
        exit;
    }
}

// ❌ PENERIMA tidak boleh buka modul bersarang (FIX)
if ($role === 'penerima' && count($halParts) > 1) {
    include BASE_PATH . "/views/notfound.php";
    exit;
}

// =======================================
// 5️⃣ Build File Path
// =======================================

// --- PENERIMA: 1-level only ---
if ($role === 'penerima') {

    $page = $halParts[0]; // hanya 1 level
    $candidate = BASE_PATH . "/{$viewFolder}/{$page}.php";

    $file = file_exists($candidate)
        ? $candidate
        : BASE_PATH . "/views/notfound.php";

    include $file;
    exit;
}

// --- ADMIN & PETUGAS: MULTI LEVEL ---
if (count($halParts) === 2) {

    $module = $halParts[0];
    $page   = $halParts[1];

    $candidate = BASE_PATH . "/{$viewFolder}/{$module}/{$page}.php";

    if (file_exists($candidate)) {
        $file = $candidate;
    } else {
        // fallback ke halaman index modul
        $fallbackIndex = [
            'user'     => 'user/daftaruser',
            'bantuan'  => 'bantuan/daftarbantuan',
            'penerima' => 'penerima/daftarpenerima',
            'transaksi' => 'transaksi/daftartransaksi',
        ];

        $file = isset($fallbackIndex[$module])
            ? BASE_PATH . "/{$viewFolder}/" . $fallbackIndex[$module] . ".php"
            : BASE_PATH . "/views/notfound.php";
    }
}

else {
    // Single page (dashboardadmin, dashboardpetugas, dll)
    $candidate = BASE_PATH . "/{$viewFolder}/{$hal}.php";

    $file = file_exists($candidate)
        ? $candidate
        : BASE_PATH . "/views/notfound.php";
}

// =======================================
// 6️⃣ Load the Page
// =======================================
include $file;

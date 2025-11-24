<?php
<<<<<<< HEAD
// =============================================
// prosesloginuser.php - Versi Lengkap & Aman
// =============================================

require_once __DIR__ . '/../../includes/path.php';
require_once INCLUDES_PATH . 'konfig.php';
require_once INCLUDES_PATH . 'koneksi.php';
require_once INCLUDES_PATH . 'fungsivalidasi.php';

if (session_status() === PHP_SESSION_NONE) session_start();

// ---------------------------------------------
// Ambil input pengguna
// ---------------------------------------------
$username = bersihkan($_POST['username'] ?? '');
$password = $_POST['password'] ?? '';

// ---------------------------------------------
// Validasi input kosong
// ---------------------------------------------
if (empty($username) || empty($password)) {
    header('Location: ' . BASE_URL . '?hal=loginuser&pesan=' . urlencode('Isi semua kolom'));
    exit;
}

// ---------------------------------------------
// Query data user
// ---------------------------------------------
$stmt = $koneksi->prepare("
    SELECT id_user, nama_user, username, password, role, status, foto
    FROM user
    WHERE username = ?
    LIMIT 1
");

$stmt->bind_param('s', $username);
$stmt->execute();
$result = $stmt->get_result();

// ---------------------------------------------
// Jika user ditemukan
// ---------------------------------------------
if ($result && $result->num_rows === 1) {
    $user = $result->fetch_assoc();

    // Periksa apakah akun aktif
    if ($user['status'] !== 'aktif') {
        header('Location: ' . BASE_URL . '?hal=loginuser&pesan=' . urlencode('Akun tidak aktif'));
        exit;
    }

    // -----------------------------------------
    // Validasi password
    // -----------------------------------------
    if (password_verify($password, $user['password'])) {

        // Set session
        $_SESSION['login']      = true;
        $_SESSION['id_user']    = $user['id_user'];
        $_SESSION['nama_user']  = $user['nama_user'];
        $_SESSION['username']   = $user['username'];
        $_SESSION['role']       = $user['role'];
        $_SESSION['foto']       = $user['foto'] ?? '';

        // -----------------------------------------
        // Redirect berdasarkan role
        // -----------------------------------------
        switch ($user['role']) {
            case 'admin':
                $redirect = BASE_URL . '?hal=dashboardadmin';
                break;
            case 'petugas':
                $redirect = BASE_URL . '?hal=dashboardpetugas';
                break;
            case 'penerima':
                $redirect = BASE_URL . '?hal=dashboardpenerima';
                break;
            default:
                $redirect = BASE_URL;
                break;
        }

        header("Location: $redirect");
=======
// ==============================================
// File: views/otentikasiuser/prosesloginuser.php
// Proses backend login admin / petugas / editor
// ==============================================

// Session sudah dijalankan di index.php
$ROOT = realpath(__DIR__ . '/../../') . DIRECTORY_SEPARATOR;

require_once $ROOT . 'includes/konfig.php';
require_once $ROOT . 'includes/koneksi.php';
require_once $ROOT . 'includes/fungsivalidasi.php';

// Ambil & bersihkan input
$username = bersihkan($_POST['username'] ?? '');
$password = $_POST['password'] ?? '';

if (empty($username) || empty($password)) {
    header("Location: " . BASE_URL . "views/otentikasiuser/login.php?pesan=" . urlencode("Isi semua kolom"));
    exit;
}

// Query user berdasarkan struktur tabel baru
$stmt = $koneksi->prepare("SELECT * FROM user WHERE username = ? LIMIT 1");
$stmt->bind_param("s", $username);
$stmt->execute();
$result = $stmt->get_result();

// Cek apakah user ditemukan
if ($result->num_rows === 1) {

    $user = $result->fetch_assoc();

    // Cek status user (aktif / nonaktif)
    if ($user['status'] !== 'aktif') {
        header("Location: " . BASE_URL . "views/otentikasiuser/login.php?pesan=" . urlencode("Akun tidak aktif"));
        exit;
    }

    // Verifikasi password
    if (password_verify($password, $user['password'])) {

        // Set session sesuai struktur tabel
        $_SESSION['login']     = true;
        $_SESSION['id_user']   = $user['id_user'];
        $_SESSION['nama_user'] = $user['nama_user'];
        $_SESSION['username']  = $user['username'];
        $_SESSION['foto']      = $user['foto'] ?? '';
        $_SESSION['role']      = $user['role'];

        // Arahkan ke dashboard berdasarkan role
        switch ($user['role']) {
            case 'admin':
                $hal = 'dashboardadmin';
                break;
            case 'petugas':
                $hal = 'dashboardpetugas';
                break;
            case 'editor':
                $hal = 'dashboardeditor';
                break;
            default:
                $hal = 'dashboard';
        }

        header("Location: " . BASE_URL . "dashboard.php?hal={$hal}");
>>>>>>> 28924cc2c2fede24d1e338ee57a7af3c314455d0
        exit;
    }
}

<<<<<<< HEAD
// ---------------------------------------------
// Jika username atau password salah
// ---------------------------------------------
header('Location: ' . BASE_URL . '?hal=loginuser&pesan=' . urlencode('Username atau password salah'));
=======
// Jika gagal login
header("Location: " . BASE_URL . "views/otentikasiuser/login.php?pesan=" . urlencode("Username atau password salah"));
>>>>>>> 28924cc2c2fede24d1e338ee57a7af3c314455d0
exit;

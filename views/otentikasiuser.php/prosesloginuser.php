<?php
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
        exit;
    }
}

// Jika gagal login
header("Location: " . BASE_URL . "views/otentikasiuser/login.php?pesan=" . urlencode("Username atau password salah"));
exit;

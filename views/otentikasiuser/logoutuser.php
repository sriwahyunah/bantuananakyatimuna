<?php
<<<<<<< HEAD
session_start();
session_destroy();
header("Location: " . BASE_URL . "?hal=loginuser");
exit();
?>
```
=======
// =======================================
// File: views/otentikasiuser/logoutuser.php
// Deskripsi: Logout user & redirect ke halaman login
// =======================================

// Mulai session
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

// Load konfigurasi & path
require_once __DIR__ . '/../../includes/path.php';
require_once __DIR__ . '/../../includes/koneksi.php';

// Hapus semua session
$_SESSION = [];
session_destroy();

// Redirect ke halaman login user
header("Location: " . BASE_URL . "?hal=loginuser");
exit;
>>>>>>> 28924cc2c2fede24d1e338ee57a7af3c314455d0

<?php
// ===========================================================
// File: includes/path.php
// Deskripsi: Definisi path absolut dan BASE_URL aplikasi
// ===========================================================

// Gunakan realpath untuk mendukung Windows & Linux
$root_path = realpath(__DIR__ . '/..') . DIRECTORY_SEPARATOR;

// PATH absolut (filesystem)
define('BASE_PATH', $root_path);
define('INCLUDES_PATH', BASE_PATH . 'includes' . DIRECTORY_SEPARATOR);
define('PAGES_PATH', BASE_PATH . 'pages' . DIRECTORY_SEPARATOR);
define('VIEWS_PATH', BASE_PATH . 'views' . DIRECTORY_SEPARATOR);
define('UPLOADS_PATH', BASE_PATH . 'uploads' . DIRECTORY_SEPARATOR);

// BASE_URL — hanya didefinisikan jika belum ada
if (!defined('BASE_URL')) {
    define('BASE_URL', 'http://localhost/bantuananakyatimuna2/');
}

// Upload folder spesifik peminjaman
define('UPLOAD_BANTUAN', UPLOADS_PATH . 'bantuan' . DIRECTORY_SEPARATOR);

// Tambahan jika nanti ada foto user
define('UPLOAD_USER', UPLOADS_PATH . 'user' . DIRECTORY_SEPARATOR);

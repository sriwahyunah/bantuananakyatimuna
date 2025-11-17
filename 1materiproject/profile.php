<?php
// profile.php
ini_set('display_errors',1); error_reporting(E_ALL);
if (session_status() === PHP_SESSION_NONE) session_start();
include 'db/koneksi.php';

// cek login
if (!isset($_SESSION['user'])) {
    header('Location: login.php');
    exit;
}

$id_admin = $_SESSION['user']['id'] ?? null;

// ambil data admin
$admin = null;
if ($id_admin) {
    $id_safe = mysqli_real_escape_string($koneksi, $id_admin);
    $q = mysqli_query($koneksi, "SELECT * FROM admin WHERE id = '$id_safe' LIMIT 1");
    if ($q && mysqli_num_rows($q) > 0) {
        $admin = mysqli_fetch_assoc($q);
    }
}

// fallback kalau database kosong
if (!$admin) {
    $admin = [
      'namaadmin' => $_SESSION['user']['name'] ?? 'Admin',
      'email' => $_SESSION['user']['email'] ?? '-'
    ];
}

include 'pages/header.php';
?>
<div class="card">
  <div class="card-body">
    <h3>Profil Admin</h3>
    <p><strong>Nama:</strong> <?= htmlspecialchars($admin['namaadmin']) ?></p>
    <p><strong>Email:</strong> <?= htmlspecialchars($admin['email'] ?? '-') ?></p>
    <p><a class="btn btn-secondary" href="index.php">Kembali ke Dashboard</a></p>
  </div>
</div>
<?php include 'pages/footer.php'; ?>

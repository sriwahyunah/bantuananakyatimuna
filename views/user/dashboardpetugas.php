<?php
// ===============================
// Dashboard Petugas
// ===============================

if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

require_once __DIR__ . '/../../includes/koneksi.php';
require_once __DIR__ . '/../../includes/konfig.php';

// Cek hak akses
if (!isset($_SESSION['login']) || $_SESSION['role'] !== 'petugas') {
    header("Location: " . BASE_URL . "?hal=loginuser");
    exit();
}

$id_user = $_SESSION['id_user'];

// Ambil data user (petugas)
$stmt = $koneksi->prepare("
    SELECT id_user, nama_user, username, role, foto, status, created_at
    FROM user
    WHERE id_user = ?
");
$stmt->bind_param("i", $id_user);
$stmt->execute();
$user = $stmt->get_result()->fetch_assoc();


// ===============================
// Hitung Data yang Ditampilkan
// ===============================

// 1. Total Data Bantuan
$queryBantuan = $koneksi->query("SELECT COUNT(*) AS total_bantuan FROM bantuan");
$totalBantuan = $queryBantuan->fetch_assoc()['total_bantuan'] ?? 0;

// 2. Total Penerima Bantuan
$queryPenerima = $koneksi->query("SELECT COUNT(*) AS total_penerima FROM penerima");
$totalPenerima = $queryPenerima->fetch_assoc()['total_penerima'] ?? 0;

?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Dashboard Petugas</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">

    <style>
        body { background: #f1f5f9; }
        .card-info { border-radius: 15px; }
        .profile-img {
            width: 120px;
            height: 120px;
            border-radius: 50%;
            object-fit: cover;
        }
    </style>
</head>

<body>

<div class="container my-4">

    <h3 class="fw-bold mb-4">Dashboard Petugas</h3>

    <!-- Profil Petugas -->
    <div class="card shadow-sm p-4 card-info mb-4">
        <div class="row">
            <div class="col-md-3 text-center">
                <img src="<?= BASE_URL ?>uploads/<?= htmlspecialchars($user['foto']) ?>"
                     class="profile-img shadow-md" alt="Foto User">
            </div>
            <div class="col-md-9">
                <h4 class="fw-bold"><?= htmlspecialchars($user['nama_user']) ?></h4>
                <table class="table table-borderless mt-3">
                    <tr><th>Username</th><td><?= htmlspecialchars($user['username']) ?></td></tr>
                    <tr><th>Role</th><td><?= ucfirst($user['role']) ?></td></tr>
                    <tr><th>Status</th><td><?= ucfirst($user['status']) ?></td></tr>
                    <tr><th>Dibuat Pada</th>
                        <td><?= date('d-m-Y H:i:s', strtotime($user['created_at'])) ?></td></tr>
                </table>
            </div>
        </div>
    </div>

    <!-- Statistik -->
    <div class="row">

        <div class="col-md-6 mb-3">
            <div class="card shadow-sm p-4 card-info text-center">
                <h5>Total Data Bantuan</h5>
                <h2 class="text-primary fw-bold"><?= number_format($totalBantuan) ?></h2>
            </div>
        </div>

        <div class="col-md-6 mb-3">
            <div class="card shadow-sm p-4 card-info text-center">
                <h5>Total Penerima Bantuan</h5>
                <h2 class="text-success fw-bold"><?= number_format($totalPenerima) ?></h2>
            </div>
        </div>

    </div>
</div>

</body>
</html>

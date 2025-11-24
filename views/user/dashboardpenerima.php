<?php
// ===============================
// Dashboard Penerima Bantuan
// ===============================

if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

require_once __DIR__ . '/../../includes/koneksi.php';
require_once __DIR__ . '/../../includes/konfig.php';

if (!isset($_SESSION['login']) || $_SESSION['role'] !== 'penerima') {
    header("Location: " . BASE_URL . "?hal=loginpenerima");
    exit();
}

$id_penerima = $_SESSION['id_penerima'];

// ===============================
// Data Profil Penerima
// ===============================
$stmt = $koneksi->prepare("
    SELECT *
    FROM penerima
    WHERE id_penerima = ?
");
$stmt->bind_param("i", $id_penerima);
$stmt->execute();
$profil = $stmt->get_result()->fetch_assoc();

// ===============================
// Hitung Total Bantuan & Nominal
// ===============================
$stmt2 = $koneksi->prepare("
    SELECT COUNT(*) AS total_bantuan, SUM(nominal) AS total_nominal
    FROM transaksi
    WHERE id_penerima = ?
");
$stmt2->bind_param("i", $id_penerima);
$stmt2->execute();
$summary = $stmt2->get_result()->fetch_assoc();

$totalBantuan = $summary['total_bantuan'] ?? 0;
$totalNominal = $summary['total_nominal'] ?? 0;

// ===============================
// Riwayat Bantuan
// ===============================
$stmt3 = $koneksi->prepare("
    SELECT t.*, b.nama_bantuan, b.nominal AS nominal_bantuan
    FROM transaksi t
    JOIN bantuan b ON t.id_bantuan = b.id_bantuan
    WHERE t.id_penerima = ?
    ORDER BY t.tanggal_pembayaran DESC
");
$stmt3->bind_param("i", $id_penerima);
$stmt3->execute();
$transaksi = $stmt3->get_result();
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Dashboard Penerima</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">

    <style>
        body { background: #f0f4ff; }
        .card-info { border-radius: 15px; }
        .profile-img {
            width: 130px;
            height: 130px;
            border-radius: 50%;
            object-fit: cover;
        }
    </style>
</head>

<body>

<div class="container my-4">

    <h3 class="fw-bold mb-4">Dashboard Penerima</h3>

    <!-- Profil -->
    <div class="card p-4 shadow-sm card-info mb-4">
        <div class="row">
            <div class="col-md-3 text-center">
                <img src="<?= BASE_URL ?>uploads/<?= $profil['foto'] ?>"
                     class="profile-img shadow-md">
            </div>
            <div class="col-md-9">
                <h4 class="fw-bold"><?= $profil['nama_penerima'] ?></h4>

                <table class="table table-borderless mt-3">
                    <tr>
                        <th width="180">NISP</th>
                        <td><?= $profil['nisp'] ?></td>
                    </tr>
                    <tr>
                        <th>Kelas</th>
                        <td><?= $profil['kelas'] ?></td>
                    </tr>
                    <tr>
                        <th>Tanggal Lahir</th>
                        <td><?= date('d-m-Y', strtotime($profil['tanggal_lahir'])) ?></td>
                    </tr>
                    <tr>
                        <th>Alamat</th>
                        <td><?= $profil['alamat'] ?></td>
                    </tr>
                    <tr>
                        <th>Status</th>
                        <td><?= $profil['status'] ?></td>
                    </tr>
                    <tr>
                        <th>Pendapatan Orang Tua</th>
                        <td>Rp <?= number_format($profil['pendapatan_orang_tua'], 0, ',', '.') ?></td>
                    </tr>
                </table>

            </div>
        </div>
    </div>

    <!-- Statistik Bantuan -->
    <div class="row mb-4">
        <div class="col-md-6">
            <div class="card shadow-sm p-4 card-info text-center">
                <h5 class="text-muted">Total Bantuan Diterima</h5>
                <h2 class="fw-bold text-primary"><?= $totalBantuan ?></h2>
            </div>
        </div>
        <div class="col-md-6">
            <div class="card shadow-sm p-4 card-info text-center">
                <h5 class="text-muted">Total Nominal Bantuan</h5>
                <h2 class="fw-bold text-success">
                    Rp <?= number_format($totalNominal, 0, ',', '.') ?>
                </h2>
            </div>
        </div>
    </div>

    <!-- Riwayat Bantuan -->
    <div class="card p-4 shadow-sm card-info">
        <h5 class="fw-bold mb-3">Riwayat Bantuan</h5>

        <table class="table table-bordered table-striped">
            <thead class="table-primary">
                <tr>
                    <th>#</th>
                    <th>Nama Bantuan</th>
                    <th>Nominal</th>
                    <th>Tanggal Pembayaran</th>
                    <th>Bukti Pembayaran</th>
                </tr>
            </thead>
            <tbody>
                <?php $no = 1; while ($row = $transaksi->fetch_assoc()): ?>
                <tr>
                    <td><?= $no++ ?></td>
                    <td><?= $row['nama_bantuan'] ?></td>
                    <td>Rp <?= number_format($row['nominal'], 0, ',', '.') ?></td>
                    <td><?= date('d-m-Y', strtotime($row['tanggal_pembayaran'])) ?></td>
                    <td>
                        <?php if (!empty($row['fotobukitstruk'])): ?>
                            <a href="<?= BASE_URL ?>uploads/<?= $row['fotobukitstruk'] ?>" 
                               target="_blank" class="btn btn-sm btn-info text-white">
                               Lihat Bukti
                            </a>
                        <?php else: ?>
                            <span class="text-muted">Tidak ada</span>
                        <?php endif; ?>
                    </td>
                </tr>
                <?php endwhile; ?>
            </tbody>
        </table>

    </div>

</div>

</body>
</html>

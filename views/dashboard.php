<?php
include 'koneksi.php';

// --- Hitung Total Data ---
$totalAdmin = mysqli_fetch_array(mysqli_query($koneksi, "SELECT COUNT(*) as total FROM admin"))['total'];
$totalPenerima = mysqli_fetch_array(mysqli_query($koneksi, "SELECT COUNT(*) as total FROM penerima"))['total'];
$totalBantuan = mysqli_fetch_array(mysqli_query($koneksi, "SELECT COUNT(*) as total FROM bantuan"))['total'];
$totalTransaksi = mysqli_fetch_array(mysqli_query($koneksi, "SELECT COUNT(*) as total FROM transaksi"))['total'];

// --- Ambil Transaksi Terbaru ---
$transaksi = mysqli_query($koneksi, "
    SELECT t.id_transaksi, p.nama_penerima, b.nama_bantuan, t.nominal, 
           t.tanggal_pembayaran, t.fotobuktistruk
    FROM transaksi t
    JOIN penerima p ON t.id_penerima = p.id_penerima
    JOIN bantuan b ON t.id_bantuan = b.id_bantuan
    ORDER BY t.tanggal_pembayaran DESC LIMIT 8
");

// --- Ambil Data untuk Grafik ---
$chart = mysqli_query($koneksi, "
    SELECT MONTH(tanggal_pembayaran) AS bulan, COUNT(*) AS total
    FROM transaksi
    GROUP BY MONTH(tanggal_pembayaran)
    ORDER BY bulan
");

$bulan = [];
$jumlah = [];
while ($row = mysqli_fetch_assoc($chart)) {
    $bulan[] = date("F", mktime(0,0,0,$row['bulan'],1));
    $jumlah[] = $row['total'];
}
?>

<div class="container-fluid">

    <!-- ROW 1 –– DATA KOTAK -->
    <div class="row">

        <div class="col-lg-3 col-6">
            <div class="small-box bg-primary">
                <div class="inner">
                    <h3><?= $totalAdmin ?></h3>
                    <p>Total Admin</p>
                </div>
                <div class="icon"><i class="fas fa-user-cog"></i></div>
            </div>
        </div>

        <div class="col-lg-3 col-6">
            <div class="small-box bg-success">
                <div class="inner">
                    <h3><?= $totalPenerima ?></h3>
                    <p>Total Penerima</p>
                </div>
                <div class="icon"><i class="fas fa-users"></i></div>
            </div>
        </div>

        <div class="col-lg-3 col-6">
            <div class="small-box bg-warning">
                <div class="inner">
                    <h3><?= $totalBantuan ?></h3>
                    <p>Total Bantuan</p>
                </div>
                <div class="icon"><i class="fas fa-gift"></i></div>
            </div>
        </div>

        <div class="col-lg-3 col-6">
            <div class="small-box bg-danger">
                <div class="inner">
                    <h3><?= $totalTransaksi ?></h3>
                    <p>Total Transaksi</p>
                </div>
                <div class="icon"><i class="fas fa-money-check-alt"></i></div>
            </div>
        </div>

    </div>

    <!-- ROW 2 –– GRAFIK -->
    <div class="card">
        <div class="card-header bg-dark">
            <h3 class="card-title">Grafik Transaksi Bantuan per Bulan</h3>
        </div>
        <div class="card-body">
            <canvas id="chartTransaksi"></canvas>
        </div>
    </div>

    <!-- ROW 3 –– TRANSAKSI TERBARU -->
    <div class="card mt-4">
        <div class="card-header bg-primary">
            <h3 class="card-title">Transaksi Terbaru</h3>
        </div>

        <div class="card-body table-responsive">
            <table class="table table-bordered table-striped">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Penerima</th>
                        <th>Bantuan</th>
                        <th>Nominal</th>
                        <th>Tanggal</th>
                        <th>Struk</th>
                    </tr>
                </thead>
                <tbody>
                    <?php while ($row = mysqli_fetch_assoc($transaksi)) : ?>
                    <tr>
                        <td><?= $row['id_transaksi'] ?></td>
                        <td><?= $row['nama_penerima'] ?></td>
                        <td><?= $row['nama_bantuan'] ?></td>
                        <td>Rp <?= number_format($row['nominal'], 0, ",", ".") ?></td>
                        <td><?= $row['tanggal_pembayaran'] ?></td>
                        <td>
                            <?php if ($row['fotobuktistruk']) : ?>
                                <img src="uploads/<?= $row['fotobuktistruk'] ?>" width="50">
                            <?php else : ?>
                                <span class="text-muted">-</span>
                            <?php endif; ?>
                        </td>
                    </tr>
                    <?php endwhile; ?>
                </tbody>
            </table>
        </div>
    </div>

</div>

<!-- SCRIPT GRAFIK -->
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
const ctx = document.getElementById('chartTransaksi').getContext('2d');
new Chart(ctx, {
    type: 'line',
    data: {
        labels: <?= json_encode($bulan) ?>,
        datasets: [{
            label: 'Total Transaksi',
            data: <?= json_encode($jumlah) ?>,
            borderWidth: 3
        }]
    }
});
</script>

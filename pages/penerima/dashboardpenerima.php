<?php
// =======================================
// Dashboard Petugas - Sistem Bantuan Anak Yatim
// =======================================

// STATISTIK
$totalBantuan   = mysqli_fetch_assoc(mysqli_query($koneksi,"SELECT COUNT(*) AS jumlah FROM bantuanananakyatimuna2_bantuan"))['jumlah'];
$totalPenerima  = mysqli_fetch_assoc(mysqli_query($koneksi,"SELECT COUNT(*) AS jumlah FROM bantuanananakyatimuna2_penerima"))['jumlah'];
$totalTransaksi = mysqli_fetch_assoc(mysqli_query($koneksi,"SELECT COUNT(*) AS jumlah FROM bantuanananakyatimuna2_transaksi"))['jumlah'];

// GRAFIK TRANSAKSI PER BANTUAN
$hasilBantuan = mysqli_query($koneksi, "
    SELECT b.nama_bantuan, COUNT(t.id_transaksi) AS jumlah
    FROM bantuanananakyatimuna2_bantuan b
    LEFT JOIN bantuanananakyatimuna2_transaksi t
        ON t.id_bantuan = b.id_bantuan
    GROUP BY b.id_bantuan
");
$labelBantuan = [];
$jumlahTrans  = [];

while ($row = mysqli_fetch_assoc($hasilBantuan)) {
    $labelBantuan[] = $row['nama_bantuan'];
    $jumlahTrans[]  = $row['jumlah'];
}

// TRANSAKSI TERBARU
$transaksiTerbaru = mysqli_query($koneksi, "
    SELECT 
        t.id_transaksi,
        p.nama_penerima,
        b.nama_bantuan,
        t.nominal,
        t.tanggal_pembayaran
    FROM bantuanananakyatimuna2_transaksi t
    LEFT JOIN bantuanananakyatimuna2_penerima p ON p.id_penerima = t.id_penerima
    LEFT JOIN bantuanananakyatimuna2_bantuan b ON b.id_bantuan = t.id_bantuan
    ORDER BY t.tanggal_pembayaran DESC
    LIMIT 5
");

// INCLUDE LAYOUT
include PAGES_PATH . 'user/header.php';
include PAGES_PATH . 'user/navbar.php';
include PAGES_PATH . 'user/sidebarpetugas.php';
?>

<!-- KONTEN -->
<div class="content p-3">
<section class="content">
<div class="container-fluid">

    <!-- STATISTIK -->
    <div class="row">
        <?php
        $statistik = [
            ['warna'=>'info','jumlah'=>$totalBantuan,  'label'=>'Total Bantuan',   'ikon'=>'gift'],
            ['warna'=>'success','jumlah'=>$totalPenerima,'label'=>'Total Penerima','ikon'=>'users'],
            ['warna'=>'danger','jumlah'=>$totalTransaksi,'label'=>'Total Transaksi','ikon'=>'exchange-alt'],
        ];
        foreach($statistik as $item){ ?>
          <div class="col-xl-4 col-md-6 col-sm-12 mb-3">
            <div class="small-box bg-<?= $item['warna'] ?> text-white p-3 shadow-sm">
              <div class="inner">
                <h3><?= $item['jumlah'] ?></h3>
                <p><?= $item['label'] ?></p>
              </div>
              <div class="icon"><i class="fas fa-<?= $item['ikon'] ?> fa-2x"></i></div>
            </div>
          </div>
        <?php } ?>
    </div>

    <!-- GRAFIK + TABEL -->
    <div class="row">

        <!-- GRAFIK -->
        <div class="col-lg-6 col-12 mb-3">
          <div class="card shadow-sm">
            <div class="card-header bg-primary text-white"><h6 class="m-0">Transaksi per Bantuan</h6></div>
            <div class="card-body"><canvas id="grafikBantuan" height="180"></canvas></div>
          </div>
        </div>

        <!-- TABEL TRANSAKSI TERBARU -->
        <div class="col-lg-6 col-12">
          <div class="card shadow-sm mb-3">
            <div class="card-header bg-success text-white"><h6 class="m-0">Transaksi Terbaru</h6></div>
            <div class="card-body p-2">
              <table class="table table-sm table-striped mb-0">
                <thead>
                    <tr>
                        <th>Penerima</th>
                        <th>Bantuan</th>
                        <th>Nominal</th>
                        <th>Tanggal</th>
                    </tr>
                </thead>
                <tbody>
                <?php while($t = mysqli_fetch_assoc($transaksiTerbaru)){ ?>
                  <tr>
                    <td><?= htmlspecialchars($t['nama_penerima']) ?></td>
                    <td><?= htmlspecialchars($t['nama_bantuan']) ?></td>
                    <td>Rp <?= number_format($t['nominal'],0,',','.') ?></td>
                    <td><?= date('d/m/Y',strtotime($t['tanggal_pembayaran'])) ?></td>
                  </tr>
                <?php } ?>
                </tbody>
              </table>
            </div>
          </div>
        </div>

    </div>

</div>
</section>
</div>

<?php include PAGES_PATH . 'user/footer.php'; ?>

<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
const ctx = document.getElementById('grafikBantuan').getContext('2d');

new Chart(ctx,{
  type:'bar',
  data:{
    labels:<?= json_encode($labelBantuan) ?>,
    datasets:[{
      label:'Jumlah Transaksi',
      data:<?= json_encode($jumlahTrans) ?>,
      backgroundColor:'rgba(54,162,235,0.6)',
      borderColor:'rgba(54,162,235,1)',
      borderWidth:1
    }]
  },
  options:{
    responsive:true,
    maintainAspectRatio:false,
    scales:{ y:{ beginAtZero:true } }
  }
});
</script>

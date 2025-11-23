<?php
include "koneksi.php";
?>

<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Aplikasi Bantuan Anak Yatim</title>

  <!-- AdminLTE & Bootstrap -->
  <link rel="stylesheet" href="plugins/fontawesome-free/css/all.min.css">
  <link rel="stylesheet" href="dist/css/adminlte.min.css">

  <style>
    body { background-color: #f4f6f9; }
    .hero {
      position: relative;
      background: url('foto/header.jpg') no-repeat center center/cover;
      height: 300px; color: white;
      display: flex; align-items: center; justify-content: center;
      text-align: center;
    }
    .hero::after {
      content: ""; position: absolute;
      top: 0; left: 0; width:100%; height:100%;
      background: rgba(0,0,0,0.4);
    }
    .hero-content { position: relative; z-index: 1; }
    .navbar-custom { background-color:#1e3a8a; }
    .navbar-custom .nav-link { color:#fff !important; }
    .btn-login { border-radius: 30px; font-weight: bold; }
    .card-bantuan img { height:180px; object-fit:cover; }
    footer {
      background-color:#1e3a8a; color:white;
      padding:15px 0; text-align:center; margin-top:30px;
    }
  </style>
</head>

<body>

<!-- Navbar -->
<nav class="navbar navbar-expand-lg navbar-custom">
  <div class="container">
    <a class="navbar-brand text-white font-weight-bold" href="#">Bantuan Anak Yatim</a>

    <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNav">
      <span class="navbar-toggler-icon text-white"></span>
    </button>

    <div class="collapse navbar-collapse" id="navbarNav">
      <ul class="navbar-nav ml-auto">
        <li class="nav-item"><a href="#" class="nav-link">Home</a></li>
        <li class="nav-item"><a href="#" class="nav-link">Tentang</a></li>
        <li class="nav-item"><a href="#" class="nav-link">Kontak</a></li>

        <!-- Login Admin -->
        <li class="nav-item">
          <a href="views/admin/loginadmin.php" class="btn btn-light btn-sm mx-2 btn-login">
            <i class="fas fa-user-shield"></i> Login Admin
          </a>
        </li>

        <!-- Login User -->
        <li class="nav-item">
          <a href="views/user/loginuser.php" class="btn btn-warning btn-sm btn-login">
            <i class="fas fa-user"></i> Login User
          </a>
        </li>
      </ul>
    </div>
  </div>
</nav>

<!-- Hero Section -->
<div class="hero">
  <div class="hero-content">
    <h1>Program Bantuan Untuk Anak Yatim</h1>
    <p>Mari Bantu Mereka dengan Donasi dan Dukungan Kita</p>
    <a href="#bantuan" class="btn btn-primary btn-lg mt-2">Lihat Jenis Bantuan</a>
  </div>
</div>

<!-- Daftar Bantuan -->
<section id="bantuan" class="container mt-5">
  <div class="text-center mb-4">
    <h2><b>Jenis Bantuan</b></h2>
    <p class="text-muted">Berbagai bantuan yang tersedia untuk disalurkan</p>
  </div>

  <div class="row">

    <?php
    $query = mysqli_query($koneksi, "SELECT * FROM bantuan");
    while ($data = mysqli_fetch_assoc($query)) {
    ?>
      <div class="col-md-4 mb-4">
        <div class="card card-bantuan h-100">
          <img src="foto/<?php echo $data['foto'] ?? 'nofoto.jpg'; ?>" class="card-img-top">

          <div class="card-body">
            <h5 class="card-title text-center"><?php echo $data['nama_bantuan']; ?></h5>
            <p>
              <b>Nominal:</b> Rp <?php echo number_format($data['nominal'], 0, ',', '.'); ?><br>
              <b>Keterangan:</b><br><?php echo nl2br($data['keterangan']); ?>
            </p>
          </div>

          <div class="card-footer text-center">
            <a href="detail_bantuan.php?id=<?php echo $data['id_bantuan']; ?>" class="btn btn-primary btn-sm">Lihat Selengkapnya</a>
          </div>
        </div>
      </div>
    <?php } ?>

  </div>
</section>

<!-- Daftar Penerima -->
<section id="penerima" class="container mt-5">
  <div class="text-center mb-4">
    <h2><b>Data Penerima Bantuan</b></h2>
    <p class="text-muted">Siswa yang menerima program bantuan</p>
  </div>

  <table class="table table-bordered table-striped">
    <thead class="bg-primary text-white">
      <tr>
        <th>NISP</th>
        <th>Nama</th>
        <th>Kelas</th>
        <th>Pendapatan Orang Tua</th>
      </tr>
    </thead>
    <tbody>

      <?php
      $sql = mysqli_query($koneksi, "SELECT * FROM penerima");
      while ($p = mysqli_fetch_assoc($sql)) {
      ?>
        <tr>
          <td><?php echo $p['nisp']; ?></td>
          <td><?php echo $p['nama_penerima']; ?></td>
          <td><?php echo $p['kelas']; ?></td>
          <td>Rp <?php echo number_format($p['pendapatan_orang_tua'], 0, ',', '.'); ?></td>
        </tr>
      <?php } ?>

    </tbody>
  </table>
</section>

<!-- Footer -->
<footer>
  <p>© <?php echo date("Y"); ?> Aplikasi Bantuan Anak Yatim - SMKN 1 Karang Baru</p>
</footer>

<script src="plugins/jquery/jquery.min.js"></script>
<script src="plugins/bootstrap/js/bootstrap.bundle.min.js"></script>
<script src="dist/js/adminlte.min.js"></script>

</body>
</html>

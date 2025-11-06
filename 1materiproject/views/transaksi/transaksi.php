<?php
include "koneksi.php";
$no = 1;
$query = mysqli_query($koneksi, "SELECT * FROM transaksi 
    JOIN admin ON transaksi.id_admin = admin.id_admin
    JOIN penerima ON transaksi.id_penerima = penerima.id_penerima
    ORDER BY transaksi.id_transaksi DESC");
?>

<div class="card">
  <div class="card-header bg-primary text-white">
    <h3 class="card-title">Data Transaksi</h3>
  </div>
  <div class="card-body">
    <a href="views/transaksi/tambahtransaksi.php" class="btn btn-success mb-3">+ Tambah Transaksi</a>

    <table class="table table-bordered table-striped">
      <thead>
        <tr class="text-center">
          <th>No</th>
          <th>Admin</th>
          <th>Penerima</th>
          <th>Kelas</th>
          <th>Status</th>
          <th>Tanggal Bantuan Keluar</th>
          <th>Tanggal Pengambilan Bantuan</th>
          <th>Foto Bukti Struk</th>
          <th>Aksi</th>
        </tr>
      </thead>
      <tbody>
        <?php while ($data = mysqli_fetch_assoc($query)) { ?>
          <tr>
            <td class="text-center"><?= $no++ ?></td>
            <td><?= $data['nama_admin'] ?></td>
            <td><?= $data['nama_penerima'] ?></td>
            <td><?= $data['kelas'] ?></td>
            <td><?= $data['status'] ?></td>
            <td><?= $data['tanggal_bantuan_keluar'] ?></td>
            <td><?= $data['tanggal_pengambilan_bantuan'] ?></td>
            <td class="text-center">
              <?php if ($data['fotobuktistruk'] != '') { ?>
                <img src="../../uploads/<?= $data['fotobuktistruk'] ?>" width="80">
              <?php } else { ?>
                <span class="text-muted">Tidak ada</span>
              <?php } ?>
            </td>
            <td class="text-center">
              <a href="views/transaksi/edittransaksi.php?id_transaksi=<?= $data['id_transaksi'] ?>" class="btn btn-warning btn-sm">Edit</a>
              <a href="../../db/dbtransaksi.php?proses=hapus&id_transaksi=<?= $data['id_transaksi'] ?>" class="btn btn-danger btn-sm" onclick="return confirm('Yakin ingin menghapus?')">Hapus</a>
            </td>
          </tr>
        <?php } ?>
      </tbody>
    </table>
  </div>
</div>

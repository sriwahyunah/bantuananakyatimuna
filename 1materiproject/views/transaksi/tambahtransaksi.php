<?php
include "../../koneksi.php";
?>

<div class="card card-success">
  <div class="card-header bg-success text-white">
    <h3 class="card-title">Tambah Transaksi</h3>
  </div>

  <div class="card-body">
    <form action="../../db/dbtransaksi.php?proses=tambah" method="POST" enctype="multipart/form-data">

      <div class="form-group">
        <label>Admin</label>
        <select name="id_admin" class="form-control" required>
          <option value="">-- Pilih Admin --</option>
          <?php
          $admin = mysqli_query($koneksi, "SELECT * FROM admin");
          while ($a = mysqli_fetch_assoc($admin)) {
            echo "<option value='{$a['id_admin']}'>{$a['nama_admin']}</option>";
          }
          ?>
        </select>
      </div>

      <div class="form-group">
        <label>Penerima</label>
        <select name="id_penerima" class="form-control" required>
          <option value="">-- Pilih Penerima --</option>
          <?php
          $penerima = mysqli_query($koneksi, "SELECT * FROM penerima");
          while ($p = mysqli_fetch_assoc($penerima)) {
            echo "<option value='{$p['id_penerima']}'>{$p['nama_penerima']}</option>";
          }
          ?>
        </select>
      </div>

      <div class="form-group">
        <label>Kelas</label>
        <input type="text" name="kelas" class="form-control" placeholder="Masukkan kelas penerima bantuan" required>
      </div>

      <div class="form-group">
        <label>Status</label>
        <input type="text" name="status" class="form-control" placeholder="Contoh: Selesai / Menunggu / Proses">
      </div>

      <div class="form-group">
        <label>Tanggal Bantuan Keluar</label>
        <input type="date" name="tanggal_bantuan_keluar" class="form-control" required>
      </div>

      <div class="form-group">
        <label>Tanggal Pengambilan Bantuan</label>
        <input type="date" name="tanggal_pengambilan_bantuan" class="form-control">
      </div>

      <div class="form-group">
        <label>Foto Bukti Struk</label>
        <input type="file" name="fotobuktistruk" class="form-control">
      </div>

      <button type="submit" class="btn btn-success">Simpan</button>
      <a href="transaksi.php" class="btn btn-secondary">Kembali</a>
    </form>
  </div>
</div>

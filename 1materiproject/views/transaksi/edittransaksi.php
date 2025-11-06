<?php
include "koneksi.php";

$id_transaksi = $_GET['id_transaksi'];

// Query untuk ambil data transaksi dan relasi admin + penerima
$sql = mysqli_query($koneksi, "
    SELECT t.*, a.nama_admin, p.nama_penerima 
    FROM transaksi t 
    LEFT JOIN admin a ON t.id_admin = a.id_admin
    LEFT JOIN penerima p ON t.id_penerima = p.id_penerima
    WHERE t.id_transaksi='$id_transaksi'
");

$data = mysqli_fetch_assoc($sql);
if (!$data) {
    echo "<div class='alert alert-danger'>Data transaksi tidak ditemukan!</div>";
    exit();
}

$foto_sekarang = !empty($data['fotobuktistruk']) ? '../../uploads/' . $data['fotobuktistruk'] : '../../dist/img/default-150x150.png';
?>

<section class="content">
  <div class="card">
    <div class="card-header bg-gradient-warning">
      <h3 class="card-title text-white">Edit Data Transaksi: <?php echo $data['id_transaksi']; ?></h3>
    </div>

    <div class="card-body">
      <form action="../../db/dbtransaksi.php?proses=edit" method="POST" enctype="multipart/form-data">
        <input type="hidden" name="id_transaksi" value="<?php echo $data['id_transaksi']; ?>">

        <div class="form-group">
          <label>Nama Admin</label>
          <select name="id_admin" class="form-control" required>
            <option value="<?php echo $data['id_admin']; ?>"><?php echo $data['nama_admin']; ?></option>
            <?php
            $qadmin = mysqli_query($koneksi, "SELECT * FROM admin");
            while ($a = mysqli_fetch_assoc($qadmin)) {
              echo "<option value='$a[id_admin]'>$a[nama_admin]</option>";
            }
            ?>
          </select>
        </div>

        <div class="form-group">
          <label>Nama Penerima</label>
          <select name="id_penerima" class="form-control" required>
            <option value="<?php echo $data['id_penerima']; ?>"><?php echo $data['nama_penerima']; ?></option>
            <?php
            $qp = mysqli_query($koneksi, "SELECT * FROM penerima");
            while ($p = mysqli_fetch_assoc($qp)) {
              echo "<option value='$p[id_penerima]'>$p[nama_penerima]</option>";
            }
            ?>
          </select>
        </div>

        <div class="form-group">
          <label>Kelas</label>
          <input type="text" class="form-control" name="kelas" value="<?php echo $data['kelas']; ?>" placeholder="Masukkan kelas penerima" required>
        </div>

        <div class="form-group">
          <label>Status</label>
          <input type="text" class="form-control" name="status" value="<?php echo $data['status']; ?>" placeholder="Masukkan status bantuan" required>
        </div>

        <div class="form-group">
          <label>Tanggal Bantuan Keluar</label>
          <input type="date" class="form-control" name="tanggal_bantuan_keluar" value="<?php echo $data['tanggal_bantuan_keluar']; ?>" required>
        </div>

        <div class="form-group">
          <label>Tanggal Pengambilan Bantuan</label>
          <input type="date" class="form-control" name="tanggal_pengambilan_bantuan" value="<?php echo $data['tanggal_pengambilan_bantuan']; ?>" required>
        </div>

        <div class="form-group">
          <label>Foto Bukti Struk</label><br>
          <small class="text-muted">Foto saat ini:</small><br>
          <img src="<?php echo $foto_sekarang; ?>" alt="Foto Bukti" class="img-thumbnail mb-2" style="width: 100px;">
          <div class="custom-file">
            <input type="file" class="custom-file-input" id="fotobuktistruk" name="fotobuktistruk" accept="image/*">
            <label class="custom-file-label" for="fotobuktistruk">Pilih file baru</label>
          </div>
          <small class="text-muted">Format file: JPG, PNG. Foto lama akan diganti.</small>
        </div>

        <div class="card-footer">
          <a href="../../index.php?halaman=transaksi" class="btn btn-secondary">Kembali</a>
          <button type="submit" class="btn btn-warning float-right"><i class="fa fa-save"></i> Simpan Perubahan</button>
        </div>

      </form>
    </div>
  </div>
</section>

<script>
document.getElementById('fotobuktistruk').addEventListener('change', function(e) {
  var fileName = e.target.files[0].name;
  e.target.nextElementSibling.innerText = fileName;
});
</script>

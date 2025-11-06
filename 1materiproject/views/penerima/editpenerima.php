<?php
include "koneksi.php";

// Ambil ID penerima dari parameter URL
$id = isset($_GET['id_penerima']) ? intval($_GET['id_penerima']) : 0;

// Ambil data penerima berdasarkan ID
$query = mysqli_query($koneksi, "SELECT * FROM penerima WHERE id_penerima='$id'");
$data = mysqli_fetch_assoc($query);

if (!$data) {
    echo "<script>alert('Data tidak ditemukan!'); window.location.href='penerima.php';</script>";
    exit();
}
?>

<section class="content">
  <div class="card card-warning">
    <div class="card-header bg-warning text-white">
      <h3 class="card-title">Edit Data Penerima Bantuan</h3>
    </div>

    <div class="card-body">
      <form action="../../db/dbbantuan.php?proses=edit" method="POST" enctype="multipart/form-data">

        <input type="hidden" name="id_penerima" value="<?= $data['id_penerima'] ?>">

        <div class="form-group">
          <label for="nisp">NISP</label>
          <input type="text" name="nisp" id="nisp" class="form-control" 
                 value="<?= $data['nisp'] ?>" required>
        </div>

        <div class="form-group">
          <label for="nama_penerima">Nama Penerima</label>
          <input type="text" name="nama_penerima" id="nama_penerima" class="form-control" 
                 value="<?= $data['nama_penerima'] ?>" required>
        </div>

        <div class="form-group">
          <label for="status">Status</label>
          <select name="status" id="status" class="form-control" required>
            <option value="Yatim" <?= ($data['status'] == 'Yatim') ? 'selected' : '' ?>>Yatim</option>
            <option value="Piatu" <?= ($data['status'] == 'Piatu') ? 'selected' : '' ?>>Piatu</option>
            <option value="Yatim Piatu" <?= ($data['status'] == 'Yatim Piatu') ? 'selected' : '' ?>>Yatim Piatu</option>
          </select>
        </div>

        <div class="form-group">
          <label for="kelas">Kelas</label>
          <input type="text" name="kelas" id="kelas" class="form-control" 
                 value="<?= $data['kelas'] ?>" required>
        </div>

        <div class="form-group">
          <label for="tanggal_lahir">Tanggal Lahir</label>
          <input type="date" name="tanggal_lahir" id="tanggal_lahir" class="form-control"
                 value="<?= $data['tanggal_lahir'] ?>" required>
        </div>

        <div class="form-group">
          <label for="alamat">Alamat</label>
          <textarea name="alamat" id="alamat" class="form-control" rows="3" required><?= $data['alamat'] ?></textarea>
        </div>

        <div class="form-group">
          <label for="pendapatanorangtua">Pendapatan Orang Tua</label>
          <input type="number" name="pendapatanorangtua" id="pendapatanorangtua" 
                 class="form-control" value="<?= $data['pendapatanorangtua'] ?>" required>
        </div>

        <div class="form-group">
          <label for="foto">Foto</label><br>
          <?php if (!empty($data['foto'])): ?>
            <img src="../../uploads/<?= $data['foto'] ?>" alt="Foto" width="100" class="mb-2 rounded"><br>
          <?php endif; ?>
          <input type="file" name="foto" id="foto" class="form-control-file">
          <small class="text-muted">Kosongkan jika tidak ingin mengganti foto.</small>
        </div>

        <button type="submit" class="btn btn-success">Simpan Perubahan</button>
        <a href="penerima.php" class="btn btn-secondary">Batal</a>

      </form>
    </div>
  </div>
</section>

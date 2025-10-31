<?php
// ===============================================
// Pastikan koneksi.php berada di lokasi yang benar
// ===============================================
include "koneksi.php";
?>
<section class="content">
  <div class="card text-sm">
    <div class="card-header bg-gradient-primary">
      <h2 class="card-title text-white">
        Edit Data Penerima: <?php echo htmlspecialchars($dataEdit['nama_penerima']); ?>
      </h2>
    </div>

    <div class="card-body">
      <div class="card card-primary">
        <form action="db/dbpenerima.php?proses=edit" method="POST" enctype="multipart/form-data">
          <div class="card-body-sm ml-2">

            <input type="hidden" name="id_penerima" value="<?php echo $dataEdit['id_penerima']; ?>">

            <div class="form-group">
              <label for="nisp">NISP</label>
              <input type="text" class="form-control" id="nisp" name="nisp">

            </div>

            <div class="form-group">
              <label for="nama_penerima">Nama Penerima</label>
              <input type="text" class="form-control" id="nama_penerima" name="nama_penerima">
            </div>

            <div class="form-group">
              <label>Status</label>
              <select name="status" class="form-control" required>
                <option value="">-- Pilih Status --</option>
                <option value="Yatim" <?= ($dataEdit['status'] == 'Yatim') ? 'selected' : ''; ?>>Yatim</option>
                <option value="Piatu" <?= ($dataEdit['status'] == 'Piatu') ? 'selected' : ''; ?>>Piatu</option>
                <option value="Yatim Piatu" <?= ($dataEdit['status'] == 'Yatim Piatu') ? 'selected' : ''; ?>>Yatim Piatu</option>
                <option value="Tidak" <?= ($dataEdit['status'] == 'Tidak') ? 'selected' : ''; ?>>Tidak</option>
              </select>
            </div>

            <div class="form-group">
              <label>Kelas</label>
              <select name="kelas" class="form-control" required>
                <option value="">-- Pilih Kelas --</option>
                <option value="X RPL 1" <?= ($dataEdit['kelas'] == 'X RPL 1') ? 'selected' : ''; ?>>X RPL 1</option>
                <option value="XI RPL 1" <?= ($dataEdit['kelas'] == 'XI RPL 1') ? 'selected' : ''; ?>>XI RPL 1</option>
                <option value="6A" <?= ($dataEdit['kelas'] == '6A') ? 'selected' : ''; ?>>6A</option>
              </select>
            </div>

            <div class="form-group">
              <label for="tanggal_lahir">Tanggal Lahir</label>
              <input type="date" class="form-control" id="tanggal_lahir" name="tanggal_lahir"
                required value="<?php echo $dataEdit['tanggal_lahir']; ?>">
            </div>

            <div class="form-group">
              <label for="alamat">Alamat</label>
              <textarea class="form-control" id="alamat" name="alamat" rows="3">
                              </textarea>
            </div>

            <div class="form-group">
              <label for="pendapatanorangtua">Pendapatan Orang Tua</label>
              <input type="number" class="form-control" id="pendapatanorangtua" name="pendapatanorangtua">
            </div>

            <div class="form-group">
              <label for="foto">Foto Penerima</label>
              <input type="file" class="form-control" id="foto" name="foto" accept="image/*">
              <?php if (!empty($dataEdit['foto'])) { ?>
                <div class="mt-2">
                  <small class="text-muted d-block">Foto saat ini:</small>
                  <img src="uploads/<?php echo $dataEdit['foto']; ?>" width="100" class="rounded border">
                </div>
              <?php } ?>
            </div>

          </div>

          <div class="card-footer">
            <button type="submit" class="btn btn-primary float-right ml-3">
              <i class="fa fa-save"></i> Update Data
            </button>
            <a href="index.php?halaman=penerima" class="btn btn-secondary float-right">
              <i class="fa fa-arrow-left"></i> Batal
            </a>
          </div>
        </form>
      </div>
    </div>
  </div>

  <div class="card-footer text-sm text-muted">
    Formulir untuk memperbarui data penerima.
  </div>
</section>
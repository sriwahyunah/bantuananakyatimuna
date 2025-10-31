<section class="content">
  <div class="card card-warning">
    <div class="card-header bg-primary text-white">
      <h3 class="card-title">Tambah Data Penerima</h3>
    </div>

    <form action="db/dbpenerima.php?proses=tambah" method="POST" enctype="multipart/form-data">
      <div class="card-body">
        <div class="form-group">
          <label>NISP</label>
          <input type="text" name="nisp" class="form-control" required>
        </div>

        <div class="form-group">
          <label>Nama Penerima</label>
          <input type="text" name="nama_penerima" class="form-control" required>
        </div>

        <div class="form-group">
          <label>Status</label>
          <select name="status" class="form-control" required>
            <option value="">-- Pilih Status --</option>
            <option value="Yatim">Yatim</option>
            <option value="Piatu">Piatu</option>
            <option value="Yatim Piatu">Yatim Piatu</option>
            <option value="Tidak">Tidak</option>
          </select>
        </div>

        <div class="form-group">
          <label>Kelas</label>
          <input type="text" name="kelas" class="form-control" required>
        </div>

        <div class="form-group">
          <label>Tanggal Lahir</label>
          <input type="date" name="tanggal_lahir" class="form-control" required>
        </div>

        <div class="form-group">
          <label>Alamat</label>
          <textarea name="alamat" class="form-control" rows="2" required></textarea>
        </div>

        <div class="form-group">
          <label>Pendapatan Orang Tua/Bulan</label>
          <input type="number" name="pendapatanorangtua" class="form-control" required>
        </div>

        <div class="form-group">
          <label>Foto</label>
          <input type="file" name="foto" class="form-control" accept="image/*" onchange="previewImage(event)" required>
          <br>
          <img id="preview" style="max-width:120px; display:none; border:1px solid #ccc;">
        </div>
      </div>

      <div class="card-footer">
        <button type="submit" class="btn btn-success"><i class="fa fa-save"></i> Simpan</button>
        <a href="index.php?halaman=penerima" class="btn btn-secondary">Batal</a>
      </div>
    </form>
  </div>
</section>

<script>
  function previewImage(event) {
    const reader = new FileReader();
    reader.onload = function () {
      const preview = document.getElementById('preview');
      preview.src = reader.result;
      preview.style.display = 'block';
    }
    reader.readAsDataURL(event.target.files[0]);
  }
</script>

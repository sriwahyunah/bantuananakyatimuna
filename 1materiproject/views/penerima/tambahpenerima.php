

<section class="content">
  <div class="card card-primary">
    <div class="card-header bg-primary text-white">
      <h3 class="card-title">Tambah Data Penerima Bantuan</h3>
    </div>

    <div class="card-body">
      <form action="../db/dbbantuan.php?proses=tambah" method="POST" enctype="multipart/form-data">
        
        <div class="form-group">
          <label for="nisp">NISP</label>
          <input type="text" name="nisp" id="nisp" class="form-control" required>
        </div>

        <div class="form-group">
          <label for="nama_penerima">Nama Penerima</label>
          <input type="text" name="nama_penerima" id="nama_penerima" class="form-control" required>
        </div>

        <div class="form-group">
          <label for="status">Status</label>
          <select name="status" id="status" class="form-control" required>
            <option value="">-- Pilih Status --</option>
            <option value="Yatim">Yatim</option>
            <option value="Piatu">Piatu</option>
            <option value="Yatim Piatu">Yatim Piatu</option>
          </select>
        </div>

        <div class="form-group">
          <label for="kelas">Kelas</label>
          <input type="text" name="kelas" id="kelas" class="form-control" required>
        </div>

        <div class="form-group">
          <label for="tanggal_lahir">Tanggal Lahir</label>
          <input type="date" name="tanggal_lahir" id="tanggal_lahir" class="form-control" required>
        </div>

        <div class="form-group">
          <label for="alamat">Alamat</label>
          <textarea name="alamat" id="alamat" class="form-control" rows="3" required></textarea>
        </div>

        <div class="form-group">
          <label for="pendapatanorangtua">Pendapatan Orang Tua</label>
          <input type="number" name="pendapatanorangtua" id="pendapatanorangtua" class="form-control" required>
        </div>

        <div class="form-group">
          <label for="foto">Foto</label>
          <input type="file" name="foto" id="foto" class="form-control-file">
        </div>

        <button type="submit" class="btn btn-success">Simpan</button>
        <a href="../views/penerima/penerima.php" class="btn btn-secondary">Batal</a>
      </form>
    </div>
  </div>
</section>

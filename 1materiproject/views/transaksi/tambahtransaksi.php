<div class="card card-primary">
    <div class="card-header">
        <h3 class="card-title">Tambah Transaksi</h3>
    </div>

    <form action="db/dbtransaksi.php?proses=tambah" method="POST">
        <div class="card-body">
            <div class="form-group">
                <label for="tanggal_transaksi">Tanggal Transaksi</label>
                <input type="date" name="tanggal_transaksi" class="form-control" required>
            </div>

            <div class="form-group">
                <label for="id_admin">ID Admin</label>
                <input type="number" name="id_admin" class="form-control" placeholder="Masukkan ID Admin" required>
            </div>

            <div class="form-group">
                <label for="id_penerima">ID Penerima</label>
                <input type="number" name="id_penerima" class="form-control" placeholder="Masukkan ID Penerima" required>
            </div>
        </div>

        <div class="card-footer">
            <button type="submit" class="btn btn-success">Simpan</button>
            <a href="index.php?halaman=transaksi" class="btn btn-secondary">Batal</a>
        </div>
    </form>
</div>

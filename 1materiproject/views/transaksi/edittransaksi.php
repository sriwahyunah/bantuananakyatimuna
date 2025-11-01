<?php
// Aktifkan error agar tidak blank
error_reporting(E_ALL);
ini_set('display_errors', 1);

include "koneksi.php";

// Cek apakah ada parameter id_transaksi
if (!isset($_GET['id_transaksi'])) {
    die("<div class='alert alert-danger'>ID Transaksi tidak ditemukan!</div>");
}

$id_transaksi = $_GET['id_transaksi'];
$query = mysqli_query($koneksi, "SELECT * FROM transaksi WHERE id_transaksi='$id_transaksi'");
$data = mysqli_fetch_assoc($query);

if (!$data) {
    die("<div class='alert alert-danger'>Data transaksi dengan ID tersebut tidak ditemukan!</div>");
}
?>

<div class="card card-warning">
    <div class="card-header bg-primary text-white">
        <h3 class="card-title">Edit Transaksi</h3>
    </div>

    <form action="db/dbtransaksi.php?proses=edit" method="POST" enctype="multipart/form-data">
        <input type="hidden" name="id_transaksi" value="<?= $data['id_transaksi']; ?>">

        <div class="card-body">
            <!-- Tanggal Transaksi -->
            <div class="form-group">
                <label for="id_transaksi">id Transaksi</label>
                <input type="date" name="id_transaksi" class="form-control"
                    value="<?= $data['id_transaksi']; ?>" required>
            </div>

            <!-- ID Admin -->
            <div class="form-group">
                <label for="id_admin">ID Admin</label>
                <input type="number" name="id_admin" class="form-control"
                    value="<?= $data['id_admin']; ?>" required>
            </div>

            <!-- ID Penerima -->
            <div class="form-group">
                <label for="id_penerima">ID Penerima</label>
                <input type="number" name="id_penerima" class="form-control"
                    value="<?= $data['id_penerima']; ?>" required>
            </div>

            <!-- Kelas -->
            <div class="form-group">
                <label for="kelas">Kelas</label>
                <input type="text" name="kelas" class="form-control"
                    value="<?= isset($data['kelas']) ? $data['kelas'] : ''; ?>" placeholder="Contoh: SD/MI, SMP/MTs, SMA/SMK">
            </div>

            <!-- Status -->
            <div class="form-group">
                <label for="status">Status</label>
                <select name="status" class="form-control" required>
                    <option value="">-- Pilih Status --</option>
                    <option value="Diproses" <?= ($data['status'] == 'Diproses') ? 'selected' : ''; ?>>Diproses</option>
                    <option value="Selesai" <?= ($data['status'] == 'Selesai') ? 'selected' : ''; ?>>Selesai</option>
                    <option value="Batal" <?= ($data['status'] == 'Batal') ? 'selected' : ''; ?>>Batal</option>
                </select>
            </div>

            <!-- Tanggal Bantuan Keluar -->
            <div class="form-group">
                <label for="tanggal_bantuan_keluar">Tanggal Bantuan Keluar</label>
                <input type="date" name="tanggal_bantuan_keluar" class="form-control"
                    value="<?= isset($data['tanggal_bantuan_keluar']) ? $data['tanggal_bantuan_keluar'] : ''; ?>">
            </div>

            <!-- Tanggal Pengambilan Bantuan -->
            <div class="form-group">
                <label for="tanggal_pengambilan_bantuan">Tanggal Pengambilan Bantuan</label>
                <input type="date" name="tanggal_pengambilan_bantuan" class="form-control"
                    value="<?= isset($data['tanggal_pengambilan_bantuan']) ? $data['tanggal_pengambilan_bantuan'] : ''; ?>">
            </div>

            <!-- Foto Bukti Struk -->
            <div class="form-group">
                <label for="foto_bukti_struk">Foto Bukti Struk</label><br>
                <?php if (!empty($data['foto_bukti_struk'])) { ?>
                    <img src="uploads/<?= $data['foto_bukti_struk']; ?>" alt="Bukti Struk" width="120" class="mb-2 rounded">
                    <br>
                <?php } ?>
                <input type="file" name="foto_bukti_struk" class="form-control-file">
                <small class="text-muted">Kosongkan jika tidak ingin mengganti foto</small>
            </div>
        </div>

        <div class="card-footer">
            <button type="submit" class="btn btn-warning">Update</button>
            <a href="index.php?halaman=transaksi" class="btn btn-secondary">Batal</a>
        </div>
    </form>
</div>

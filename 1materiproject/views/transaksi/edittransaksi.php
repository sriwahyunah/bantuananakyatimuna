<?php
include "koneksi.php";
$id_transaksi = $_GET['id_transaksi'];
$query = mysqli_query($koneksi, "SELECT * FROM transaksi WHERE id_transaksi='$id_transaksi'");
$data = mysqli_fetch_assoc($query);
?>

<div class="card card-warning">
    <div class="card-header">
        <h3 class="card-title">Edit Transaksi</h3>
    </div>

    <form action="db/dbtransaksi.php?proses=edit" method="POST">
        <input type="hidden" name="id_transaksi" value="<?= $data['id_transaksi']; ?>">

        <div class="card-body">
            <div class="form-group">
                <label for="tanggal_transaksi">Tanggal Transaksi</label>
                <input type="date" name="tanggal_transaksi" class="form-control" value="<?= $data['tanggal_transaksi']; ?>" required>
            </div>

            <div class="form-group">
                <label for="id_admin">ID Admin</label>
                <input type="number" name="id_admin" class="form-control" value="<?= $data['id_admin']; ?>" required>
            </div>

            <div class="form-group">
                <label for="id_penerima">ID Penerima</label>
                <input type="number" name="id_penerima" class="form-control" value="<?= $data['id_penerima']; ?>" required>
            </div>
        </div>

        <div class="card-footer">
            <button type="submit" class="btn btn-warning">Update</button>
            <a href="index.php?halaman=transaksi" class="btn btn-secondary">Batal</a>
        </div>
    </form>
</div>

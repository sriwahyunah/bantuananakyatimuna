<?php
include "koneksi.php";
$query = mysqli_query($koneksi, "SELECT * FROM transaksi");
?>

<div class="card card-solid">
    <div class="col">
        <a href="index.php?halaman=tambahtransaksi" class="btn btn-primary float-right btn-sm mt-3">
            <i class="fas fa-plus"></i> Tambah Transaksi
        </a>
    </div>

    <div class="card-body pb-0">
        <div class="table-responsive">
            <table class="table table-bordered table-striped text-center">
                <thead>
                    <tr>
                        <th>No</th>
                        <th>ID Transaksi</th>
                        <th>id penerima</th>
                        <th>ID Admin</th>
                        <th>kelas</th>
                        <th>status</th>
                        <th>tanggal bantuan keluar</th>
                        <th>tanggal pengambilan bantuan</th>
                        <th>foto bukti struk</th>
                        <th>aksi</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    $no = 1;
                    while ($data = mysqli_fetch_assoc($query)) {
                    ?>
                        <tr>
                            <td><?= $no++; ?></td>
                            <td><?= htmlspecialchars($data['id_transaksi']); ?></td>
                            <td><?= htmlspecialchars($data['id_penerima']); ?></td>
                            <td><?= htmlspecialchars($data['id_admin']); ?></td>
                            <td><?= htmlspecialchars($data['kelas']); ?></td>
                            <td><?= htmlspecialchars($data['status']); ?></td>
                            <td><?= htmlspecialchars($data['tanggal_bantuan_keluar']); ?></td>
                            <td><?= htmlspecialchars($data['tanggal_pengambilan_bantuan']); ?></td>
                            <td><?= htmlspecialchars($data['fotobuktistruk']); ?></td>
                            <td>
                                <a href="index.php?halaman=edittransaksi&id_transaksi=<?= $data['id_transaksi']; ?>" class="btn btn-warning btn-sm">Edit</a>
                                <a href="db/dbtransaksi.php?proses=hapus&id_transaksi=<?= $data['id_transaksi']; ?>" class="btn btn-danger btn-sm" onclick="return confirm('Yakin ingin hapus data ini?')">Hapus</a>
                            </td>
                        </tr>
                    <?php } ?>
                </tbody>
            </table>
        </div>
    </div>
</div>

<?php
include "koneksi.php";

// Ambil data bantuan dari tabel
$query = mysqli_query($koneksi, "SELECT * FROM bantuan ORDER BY id_bantuan DESC");
$no = 1;
?>

<div class="card card-solid">
    <div class="card-header">
        <h3 class="card-title">Daftar Bantuan</h3>
        <a href="index.php?halaman=tambahbantuan" class="btn btn-primary float-right btn-sm">
            <i class="fas fa-plus"></i> Tambah Bantuan
        </a>
    </div>

    <div class="card-body">
        <div class="table-responsive">
            <table class="table table-bordered table-striped text-center">
                <thead class="thead-dark">
                    <tr>
                        <th width="5%">No</th>
                        <th>Nama Bantuan</th>
                        <th>ID Kategori</th>
                        <th>Keterangan</th>
                        <th>Status</th>
                        <th width="15%">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    <?php while ($data = mysqli_fetch_assoc($query)) { ?>
                        <tr>
                            <td><?= $no++; ?></td>
                            <td><?= htmlspecialchars($data['nama_bantuan']); ?></td>
                            <td>
                                <?php if (!empty($data['id_kategori'])) { ?>
                                    <?= htmlspecialchars($data['id_kategori']); ?>
                                <?php } else { ?>
                                    <span class="badge bg-secondary">Tidak Diketahui</span>
                                <?php } ?>
                            </td>
                            <td><?= htmlspecialchars($data['keterangan']); ?></td>
                            <td>
                                <?php if (!empty($data['status'])) { ?>
                                    <span class="badge bg-success"><?= htmlspecialchars($data['status']); ?></span>
                                <?php } else { ?>
                                    <span class="badge bg-secondary">Tidak Diketahui</span>
                                <?php } ?>
                            </td>
                            <td>
                                <!-- Tombol Edit -->
                                <a href="index.php?halaman=editbantuan&id_bantuan=<?= $data['id_bantuan']; ?>"
                                    class="btn btn-warning btn-sm" title="Edit">
                                    <i class="fas fa-edit"></i>
                                </a>

                                <!-- Tombol Hapus -->
                                <a href="db/dbbantuan.php?proses=hapus&id_bantuan=<?= $data['id_bantuan']; ?>"
                                    onclick="return confirm('Yakin ingin menghapus data ini?')"
                                    class="btn btn-danger btn-sm" title="Hapus">
                                    <i class="fas fa-trash"></i>
                                </a>
                            </td>
                        </tr>
                    <?php } ?>
                </tbody>
            </table>
        </div>
    </div>
</div>

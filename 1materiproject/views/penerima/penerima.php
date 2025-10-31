<?php
// Contoh: Jika koneksi.php ada di folder ROOT dan penerima.php ada di views/penerima/
include "koneksi.php"; 
// Jika ini masih error, coba cek lagi lokasi koneksi.php Anda.

// --- 1. Query Data ---
// Pastikan $koneksi terdefinisi dari include di atas
$query = mysqli_query($koneksi, "SELECT * FROM penerima");

// --- 2. Cek pesan setelah proses edit/tambah/hapus ---
$pesan_notifikasi = '';
if (isset($_GET['pesan'])) {
    if ($_GET['pesan'] == 'berhasil_edit') {
        $pesan_notifikasi = '<div class="alert alert-success alert-dismissible"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>Data berhasil diupdate!</div>';
    } elseif ($_GET['pesan'] == 'berhasil_tambah') {
        $pesan_notifikasi = '<div class="alert alert-success alert-dismissible"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>Data berhasil ditambahkan!</div>';
    } elseif ($_GET['pesan'] == 'berhasil_hapus') {
        $pesan_notifikasi = '<div class="alert alert-info alert-dismissible"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>Data berhasil dihapus!</div>';
    }
}
?>

<div class="card card-solid">
    <div class="card-header">
        <div class="col-sm-12">
            <a href="index.php?halaman=tambahpenerima" class="btn btn-primary float-right btn-sm">
                <i class="fas fa-user-plus"></i> Tambah Penerima
            </a>
        </div>
    </div>
    
    <div class="col-12 mt-2">
        <?php echo $pesan_notifikasi; ?>
    </div>

    <div class="card-body pb-0">
        <div class="table-responsive">
            <table class="table table-bordered table-striped text-center">
                <thead>
                    <tr>
                        <th>No</th>
                        <th>NISP</th>
                        <th>Nama Penerima</th>
                        <th>Kelas</th>
                        <th>Tanggal Lahir</th>
                        <th>Alamat</th>
                        <th>Foto</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    $no = 1;
                    // PERHATIAN: Memastikan $query tidak NULL sebelum di loop
                    if ($query && mysqli_num_rows($query) > 0) {
                        while ($data = mysqli_fetch_assoc($query)) {
                        ?>
                            <tr>
                                <td><?= $no++; ?></td>
                                <td><?= htmlspecialchars($data['nisp']); ?></td>
                                <td><?= htmlspecialchars($data['nama_penerima']); ?></td>
                                <td><?= htmlspecialchars($data['kelas']); ?></td> 
                                <td><?= htmlspecialchars($data['tanggal_lahir']); ?></td>
                                <td><?= htmlspecialchars($data['alamat']); ?></td>
                                <td>
                                    <?php 
                                    // PERBAIKAN: Menggunakan path yang benar untuk foto
                                    if (!empty($data['foto'])) { ?>
                                        <img src="uploads/<?php echo htmlspecialchars($data['foto']); ?>" width="60" height="60" style="object-fit:cover; border-radius:8px;">
                                    <?php } else { ?>
                                        <span class="text-muted">Tidak ada foto</span>
                                    <?php } ?>
                                </td>
                                <td>
                                    <a href="index.php?halaman=editpenerima&id_penerima=<?= $data['id_penerima']; ?>" class="btn btn-warning btn-sm">Edit</a>
                                    <a href="db/dbpenerima.php?proses=hapus&id_penerima=<?= $data['id_penerima']; ?>" class="btn btn-danger btn-sm" onclick="return confirm('Yakin ingin hapus data ini?')">Hapus</a>
                                </td>
                            </tr>
                        <?php 
                        }
                    } else {
                        // Tampilkan pesan jika data kosong atau query gagal (setelah perbaikan koneksi)
                        echo '<tr><td colspan="8" class="text-center">Tidak ada data penerima tersedia.</td></tr>';
                    }
                    ?>
                </tbody>
            </table>
        </div>
    </div>
</div>
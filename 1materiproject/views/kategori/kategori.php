<?php
// views/kategori/tambahkategori.php

// Cek jika ada pesan error dari proses sebelumnya
$pesan_error = '';
if (isset($_GET['pesan']) && $_GET['pesan'] == 'gagal') {
     $pesan_error = "<div class='alert alert-danger'>Gagal menyimpan data kategori: " . htmlspecialchars($_GET['error'] ?? 'Terjadi kesalahan.') . "</div>";
}
?>

<section class="content">

    <div class="card text-sm shadow-sm border-0">
        <div class="card-header bg-gradient-success text-white">
            <h5 class="m-0"><i class="fas fa-tags me-1"></i> Tambah Kategori Bantuan</h5>
        </div>

        <div class="card-body">
            
            <?php echo $pesan_error; ?>
            
            <div class="card card-success">

                <form action="db/dbkategori.php?proses=tambah" method="POST">
                    <div class="card-body-sm ml-2">
                        <div class="form-group">
                            <label for="nama_kategori">Nama Kategori</label>
                            <input type="text" class="form-control" id="nama_kategori" name="nama_kategori" 
                                placeholder="Contoh: Tunai, Sembako, Pendidikan" required>
                            <small class="text-muted">Masukkan nama kategori bantuan baru.</small>
                        </div>
                    </div>
                    <div class="card-footer-sm float-right">
                        <a href="index.php?halaman=kategori" class="btn-sm btn-secondary"><i class="fa fa-undo"></i> Batal</a>
                        <button type="submit" class="btn-sm btn-success"><i class="fa fa-save"></i> Simpan Data</button>
                    </div>
                </form>
            </div>
            </div>
        <div class="card-footer text-muted text-sm">
            Formulir untuk menambahkan kategori bantuan baru.
        </div>

    </div>
    </section>

<?php
// views/kategori/kategori.php

// PENTING: ASUMSI $koneksi SUDAH TERSEDIA dari index.php
// Jika Anda masih mengalami layar abu-abu, pastikan include "koneksi.php" ada di index.php
if (!isset($koneksi) || $koneksi === false) {
    // Jalur ini hanya untuk debugging/fallback jika index.php gagal
    // Halaman ini harusnya dimuat setelah koneksi berhasil di index.php
    echo "<div class='alert alert-danger'>Koneksi database belum dimuat.</div>";
    exit();
}

$no = 1;

// Query: Mengambil semua data kategori
$sql = mysqli_query($koneksi, "
    SELECT 
        * FROM 
        kategori
    ORDER BY 
        nama_kategori ASC
");
?>

<section class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1>Data Kategori Bantuan</h1>
            </div>
        </div>
    </div>
</section>

<section class="content">
    <div class="card shadow-sm border-0">

        <div class="card-header bg-gradient-success text-white">
            <div class="d-flex justify-content-between align-items-center">
                <h5 class="m-0"><i class="fas fa-tags me-2"></i> Daftar Kategori</h5>
                <a href="index.php?halaman=tambahkategori" class="btn btn-light btn-sm">
                    <i class="fas fa-plus"></i> Tambah Kategori
                </a>
            </div>
        </div>

        <div class="card-body">
            <div class="table-responsive">
                <table id="example1" class="table table-bordered table-striped table-hover text-sm align-middle mb-0">
                    <thead class="table-success text-center">
                        <tr>
                            <th style="width: 40px;">No</th>
                            <th>Nama Kategori</th>
                            <th style="width: 100px;">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        if (!$sql) {
                            // Penanganan error jika query gagal dieksekusi
                            echo "<tr><td colspan='3' class='text-center text-danger'>Query Error: " . mysqli_error($koneksi) . "</td></tr>";
                        } else {
                            $dataDitemukan = false;
                            while ($data = mysqli_fetch_array($sql)) {
                                $dataDitemukan = true;
                                echo "
                                <tr>
                                    <td class='text-center'>$no</td>
                                    <td>" . htmlspecialchars($data['nama_kategori']) . "</td>
                                    <td class='text-center'>
                                        <a href='index.php?halaman=editkategori&id_kategori={$data['id_kategori']}' class='btn btn-sm btn-warning'>
                                            <i class='fa fa-edit'></i>
                                        </a>
                                        
                                        <a href='db/dbkategori.php?proses=hapus&id_kategori={$data['id_kategori']}' class='btn btn-sm btn-danger' onclick=\"return confirm('Yakin ingin menghapus kategori: " . htmlspecialchars($data['nama_kategori']) . "?');\">
                                            <i class='fa fa-trash'></i>
                                        </a>
                                    </td>
                                </tr>";
                                $no++;
                            }
                            
                            // Jika tidak ada data yang ditemukan
                            if (!$dataDitemukan) {
                                 echo "<tr><td colspan='3' class='text-center'>Tidak ada data kategori yang ditemukan.</td></tr>";
                            }
                        }
                        ?>
                    </tbody>
                </table>
            </div>
        </div>

        <div class="card-footer text-muted text-sm">
            <i class="fas fa-info-circle me-1"></i> Menampilkan data master kategori bantuan.
        </div>
    </div>
</section>
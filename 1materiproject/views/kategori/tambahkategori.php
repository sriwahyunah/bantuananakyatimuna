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
<?php
// views/kategori/editkategori.php

// Pastikan koneksi.php sudah di-include
include "koneksi.php";

// Ambil ID Kategori dari URL
$id_kategori = $_GET['id_kategori'];

// Query untuk mengambil data kategori yang akan diedit
$sql = mysqli_query($koneksi, "SELECT * FROM kategori WHERE id_kategori='$id_kategori'");
$data = mysqli_fetch_array($sql);

// Memastikan data ditemukan
if (!$data) {
    echo "<div class='alert alert-danger'>Data Kategori tidak ditemukan!</div>";
    exit();
}

// Cek jika ada pesan error dari proses sebelumnya
$pesan_error = '';
if (isset($_GET['pesan']) && $_GET['pesan'] == 'gagal') {
     $pesan_error = "<div class='alert alert-danger'>Gagal memperbarui data: " . htmlspecialchars($_GET['error'] ?? 'Terjadi kesalahan.') . "</div>";
}
?>

<section class="content">

    <div class="card shadow-sm border-0">
        <div class="card-header bg-gradient-warning text-white">
            <div class="d-flex justify-content-between align-items-center">
                <h5 class="m-0"><i class="fas fa-edit"></i> Edit Data Kategori</h5>
                <a href="index.php?halaman=tambahkategori" class="btn btn-light float-right btn-sm">
                    <i class="fas fa-plus-circle"></i> Tambah Kategori
                </a>
            </div>
        </div>

        <div class="card-body">
            
            <?php echo $pesan_error; ?>
            
            <div class="card text-sm">
                
                <form action="db/dbkategori.php?proses=edit" method="POST">
                    
                    <input type="hidden" value="<?= htmlspecialchars($data['id_kategori']) ?>" name="id_kategori" id="id_kategori">

                    <div class="card-body-sm ml-2">
                        <div class="form-group">
                            <label for="nama_kategori">Nama Kategori</label>
                            <input type="text" class="form-control" id="nama_kategori" name="nama_kategori"
                                placeholder="Masukkan nama kategori"
                                value="<?= htmlspecialchars($data['nama_kategori']) ?>" required>
                        </div>
                    </div>
                    <div class="card-footer float-right">
                        <a href="index.php?halaman=kategori" class="btn-sm btn-secondary"><i class="fa fa-undo"></i> Batal</a>
                        <button type="submit" class="btn-sm btn-warning"><i class="fa fa-edit"></i> Update</button>
                    </div>
                </form>
            </div>
            </div>
        <div class="card-footer text-muted text-sm">
            Formulir untuk memperbarui nama kategori.
        </div>
        </div>
    </section>
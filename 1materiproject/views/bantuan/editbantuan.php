<?php
// Pastikan koneksi.php berada di lokasi yang benar
include "koneksi.php"; 

// ===============================================
// 1. PERBAIKAN KEAMANAN & PENGAMBILAN DATA
// ===============================================

// Cek apakah ID ada dan tidak kosong
if (!isset($_GET['id_bantuan']) || empty($_GET['id_bantuan'])) {
    echo "<div class='alert alert-danger'>ID Bantuan tidak valid!</div>";
    exit();
}

// AMANKAN INPUT DARI SQL INJECTION: Bersihkan ID Bantuan
$id_bantuan = mysqli_real_escape_string($koneksi, $_GET['id_bantuan']);

// Query untuk mengambil data bantuan yang akan diedit
$sqlEdit = mysqli_query($koneksi, "SELECT * FROM bantuan WHERE id_bantuan='$id_bantuan'");
$dataEdit = mysqli_fetch_array($sqlEdit);

// Memastikan data ditemukan
if (!$dataEdit) {
    echo "<div class='alert alert-danger'>Data Bantuan dengan ID: {$id_bantuan} tidak ditemukan! Mengalihkan...</div>";
    // Redirect ke halaman daftar jika data tidak ada
    echo "<script>window.location='index.php?halaman=bantuan';</script>"; 
    exit();
}

// Catatan: Logika HAPUS telah dihapus dari sini. 
// Sebaiknya, tombol hapus memanggil fungsi JAVASCRIPT untuk konfirmasi, 
// kemudian mengarahkan ke dbbantuan.php?proses=hapus&id_bantuan=X.
?>

<section class="content">

    <div class="card text-sm">
        <div class="card-header bg-gradient-warning">
            <h2 class="card-title text-white">Edit Data Bantuan: <?php echo $dataEdit['nama_bantuan']; ?></h2>
        </div>

        <div class="card-body">
            <div class="card card-warning">
                <form action="db/dbbantuan.php?proses=edit" method="POST">
                    <div class="card-body-sm ml-2">

                        <input type="hidden" name="id_bantuan" value="<?php echo $dataEdit['id_bantuan']; ?>">

                        <div class="form-group">
                            <label for="nama_bantuan">Nama Bantuan</label>
                            <input type="text" class="form-control" id="nama_bantuan" name="nama_bantuan"
                                placeholder="Masukkan nama bantuan" required
                                value="<?php echo $dataEdit['nama_bantuan']; ?>">
                        </div>

                        <?php
                        // Query untuk mengambil semua data kategori
                        $sqlkategori = mysqli_query($koneksi, "SELECT * FROM kategori ORDER BY nama_kategori ASC");

                        echo "
                        <div class='form-group'>
                            <label>Kategori Bantuan</label>
                            <select class='form-control' name='id_kategori' required>
                                <option value='' disabled>-- Pilih Kategori --</option>";

                        while ($datakategori = mysqli_fetch_array($sqlkategori)) {
                            // Cek opsi yang sudah terpilih
                            $selected = ($datakategori['id_kategori'] == $dataEdit['id_kategori']) ? 'selected' : '';
                            echo "<option value='{$datakategori['id_kategori']}' {$selected}>{$datakategori['nama_kategori']}</option>";
                        }
                        echo "
                            </select>
                            <small class='text-muted'>Pilih kategori yang sesuai untuk bantuan ini.</small>
                        </div>";
                        ?>

                        <div class="form-group">
                            <label for="keterangan">Keterangan / Deskripsi Bantuan</label>
                            <textarea class="form-control" id="keterangan" name="keterangan" rows="3"
                                placeholder="Deskripsikan secara singkat mengenai bantuan ini."><?php echo $dataEdit['keterangan']; ?></textarea>
                        </div>

                        <div class="form-group">
                            <label>Status</label>
                            <select name="status" class="form-control" required>
                                <option value="">-- pilih status --</option>
                                <option value="Yatim" <?= ($dataEdit['status'] == 'Yatim') ? 'selected' : ''; ?>>Yatim</option>
                                <option value="Piatu" <?= ($dataEdit['status'] == 'Piatu') ? 'selected' : ''; ?>>Piatu</option>
                                <option value="Yatim Piatu" <?= ($dataEdit['status'] == 'Yatim Piatu') ? 'selected' : ''; ?>>Yatim Piatu</option>
                                <option value="Tidak" <?= ($dataEdit['status'] == 'Tidak') ? 'selected' : ''; ?>>Tidak</option>
                            </select>
                        </div>


                    </div>
                    <div class="card-footer">
                        <button type="submit" class="btn btn-warning float-right ml-3"><i class="fa fa-edit"></i> Update Data</button>
                        <a href="index.php?halaman=bantuan" class="btn btn-secondary float-right"> Batal</a>
                    </div>

                </form> 
                </div>
        </div>
        
    </div>
    <div class="card-footer text-sm text-muted">
        Formulir untuk memperbarui data bantuan.
    </div>
    </div>
</section>
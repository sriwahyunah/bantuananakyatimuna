<?php
// views/admin/editadmin.php

include "koneksi.php"; // Pastikan koneksi.php sudah di-include
$id_admin = $_GET['id_admin'];

// Query untuk mengambil data admin yang akan diedit
$sqlEdit = mysqli_query($koneksi, "SELECT * FROM admin WHERE id_admin='$id_admin'");
$dataEdit = mysqli_fetch_array($sqlEdit);

// Memastikan data ditemukan
if (!$dataEdit) {
    echo "<div class='alert alert-danger'>Data Admin tidak ditemukan!</div>";
    exit();
}

// Menentukan path foto yang ada
$foto_sekarang = !empty($dataEdit['foto']) ? 'foto/' . $dataEdit['foto'] : 'dist/img/user2-160x160.jpg';

// Pesan notifikasi error
$pesan_error = '';
if (isset($_GET['pesan']) && $_GET['pesan'] == 'gagalupload') {
    $pesan_error = "<div class='alert alert-danger'>Gagal upload foto. Silakan coba lagi.</div>";
} elseif (isset($_GET['pesan']) && $_GET['pesan'] == 'gagal') {
    $pesan_error = "<div class='alert alert-danger'>Gagal memperbarui data: " . htmlspecialchars($_GET['error'] ?? 'Terjadi kesalahan database.') . "</div>";
}
?>

<section class="content">

    <div class="card text-sm">
        <div class="card-header bg-gradient-warning">
            <h2 class="card-title text-white">Edit Data Admin: <?php echo $dataEdit['nama_admin']; ?></h2>
        </div>

        <div class="card-body">
            <div class="card card-warning">

                <?php echo $pesan_error; ?>

                <form action="db/dbadmin.php?proses=edit" method="POST" enctype="multipart/form-data">
                    <div class="card-body-sm ml-2">

                        <input type="hidden" name="id_admin" value="<?php echo $dataEdit['id_admin']; ?>">

                        <div class="form-group">
                            <label for="nama_admin">Nama Lengkap Admin</label>
                            <input type="text" class="form-control" id="nama_admin" name="nama_admin"
                                placeholder="Masukkan nama lengkap" required
                                value="<?php echo htmlspecialchars($dataEdit['nama_admin']); ?>">
                        </div>

                        <div class="form-group">
                            <label for="username">Username (Login)</label>
                            <input type="text" class="form-control" id="username" name="username"
                                placeholder="Masukkan username unik" required
                                value="<?php echo htmlspecialchars($dataEdit['username']); ?>">
                        </div>

                        <div class="form-group">
                            <label for="password">Ganti Password</label>
                            <input type="password" class="form-control" id="password" name="password"
                                placeholder="Kosongkan jika tidak ingin mengubah password">
                            <small class="text-muted">Kosongkan kolom ini jika password tidak ingin diubah.</small>
                        </div>

                        <div class="form-group">
                            <label for="foto">Ubah Foto Admin</label>

                            <div class="mb-2">
                                <small class="text-muted">Foto saat ini:</small>
                                <img src="<?php echo $foto_sekarang; ?>" alt="Foto Admin" class="img-circle elevation-2" style="width: 50px; height: 50px;">
                            </div>

                            <input type="hidden" name="fotoLama" value="<?php echo $dataEdit['foto']; ?>">

                            <div class="input-group">
                                <div class="custom-file">
                                    <input type="file" class="custom-file-input" id="foto" name="foto" accept="image/*">
                                    <label class="custom-file-label" for="foto">Pilih file foto baru</label>
                                </div>
                            </div>
                            <small class="text-muted">Format: JPG, PNG. Foto lama akan diganti.</small>
                        </div>

                        <div class="card-footer">
                            <button type="submit" class="btn btn-warning float-right ml-3"><i class="fa fa-edit"></i> Update Data</button>
                            <a href="index.php?halaman=admin" class="btn btn-secondary float-right"> Batal</a>
                        </div>

                    </div>
                </form>
            </div>
        </div>
        <div class="card-footer text-sm text-muted">
            Formulir untuk memperbarui data administrator sistem.
        </div>
    </div>
</section>

<script>
    document.getElementById('foto').addEventListener('change', function(e) {
        var fileName = e.target.files[0].name;
        var nextSibling = e.target.nextElementSibling;
        nextSibling.innerText = fileName;
    });
</script>
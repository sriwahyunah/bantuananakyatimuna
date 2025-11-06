
<!-- ====== TAMBAH ADMIN ====== -->
<section class="content">

  <div class="container-fluid">
    <div class="card card-warning shadow-sm">
      <div class="card-header bg-gradient-warning">
        <h5 class="card-title text-white m-0">
          <i class="fas fa-user-plus"></i> Tambah Admin
        </h5>
      </div>

      <form action="../../db/dbadmin.php?proses=tambah" method="POST" enctype="multipart/form-data">
        <div class="card-body">

          <!-- Nama Admin -->
          <div class="form-group">
            <label for="namaadmin">Nama Admin</label>
            <input type="text" class="form-control" id="namaadmin" name="namaadmin"
              placeholder="Masukkan nama admin" required>
          </div>

          <!-- Username -->
          <div class="form-group">
            <label for="username">Username</label>
            <input type="text" class="form-control" id="username" name="username"
              placeholder="Masukkan username" required>
          </div>

          <!-- Password -->
          <div class="form-group">
            <label for="password">Password</label>
            <input type="password" class="form-control" id="password" name="password"
              placeholder="Masukkan password" required>
          </div>

          <!-- Foto -->
          <div class="form-group">
            <label for="foto">Foto</label>
            <input type="file" class="form-control-file border p-2 rounded bg-light" 
                   id="foto" name="foto" accept="image/*">
            <small class="form-text text-muted">Format file: JPG, PNG</small>
          </div>

        </div>

        <!-- Tombol -->
        <div class="card-footer text-right">
          <a href="index.php?halaman=admin" class="btn btn-secondary btn-sm">
            <i class="fa fa-arrow-left"></i> Kembali
          </a>
          <button type="reset" class="btn btn-warning btn-sm">
            <i class="fa fa-undo"></i> Reset
          </button>
          <button type="submit" class="btn btn-primary btn-sm">
            <i class="fa fa-save"></i> Simpan
          </button>
        </div>
      </form>
    </div>
  </div>

</section>

<!-- SweetAlert (opsional untuk notifikasi sukses/gagal) -->
<?php if (isset($_GET['status'])): ?>
  <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
  <script>
    <?php if ($_GET['status'] == 'sukses'): ?>
      Swal.fire({
        icon: 'success',
        title: 'Berhasil!',
        text: 'Data admin berhasil disimpan.',
        timer: 2000,
        showConfirmButton: false
      })
    <?php else: ?>
      Swal.fire({
        icon: 'error',
        title: 'Gagal!',
        text: 'Terjadi kesalahan saat menyimpan data.',
      })
    <?php endif; ?>
  </script>
<?php endif; ?>

<section class="content">

    <div class="card text-sm">
        <div class="card-header bg-gradient-primary">
            <h2 class="card-title text-white">Tambah Data Bantuan</h2>
        </div>

        <div class="card-body">
            <div class="card card-warning">
                <form action="db/dbbantuan.php?proses=tambah" method="POST">
                    <div class="card-body-sm ml-2">

                        <!-- Nama Bantuan -->
                        <div class="form-group">
                            <label for="nama_bantuan">Nama Bantuan</label>
                            <input type="text" class="form-control" id="nama_bantuan" name="nama_bantuan"
                                placeholder="Contoh: Bantuan Sembako, Dana Pendidikan" required>
                        </div>

                        <!-- Kategori Bantuan -->
                        <?php
                        include("koneksi.php");
                        $sqlkategori = mysqli_query($koneksi, "SELECT * FROM kategori ORDER BY nama_kategori ASC");
                        ?>
                        <div class="form-group">
                            <label for="id_kategori">Kategori Bantuan</label>
                            <select class="form-control" id="id_kategori" name="id_kategori" required>
                                <option value="" disabled selected>-- Pilih Kategori --</option>
                                <?php while ($datakategori = mysqli_fetch_array($sqlkategori)) { ?>
                                    <option value="<?= $datakategori['id_kategori']; ?>">
                                        <?= $datakategori['nama_kategori']; ?>
                                    </option>
                                <?php } ?>
                            </select>
                            <small class="text-muted">Pilih kategori yang sesuai untuk bantuan ini.</small>
                        </div>

                        <!-- Keterangan Bantuan -->
                        <div class="form-group">
                            <label for="keterangan">Keterangan / Deskripsi Bantuan</label>
                            <textarea class="form-control" id="keterangan" name="keterangan" rows="3"
                                placeholder="Deskripsikan secara singkat mengenai bantuan ini (misalnya target, bentuk, atau sumber dana)."></textarea>
                        </div>

                        <!-- Status Bantuan -->
                        <div class="form-group">
                            <label for="status">Status Bantuan</label>
                            <select class="form-control" name="status" id="status" required>
                                <option value="">-- Pilih Status --</option>
                                <option value="Yatim">Yatim</option>
                                <option value="Piatu">Piatu</option>
                                <option value="Yatim Piatu">Yatim Piatu</option>
                                <option value="Tidak Aktif">Tidak Aktif</option>
                            </select>
                            <small class="form-text text-muted">
                                Pilih apakah bantuan ini sedang aktif atau nonaktif.
                            </small>
                        </div>

                        <!-- Tombol Simpan dan Reset -->
                        <div class="form-group mt-4 text-right">
                            <button type="reset" class="btn btn-warning mr-2">
                                <i class="fas fa-undo"></i> Reset
                            </button>
                            <button type="submit" class="btn btn-primary">
                                <i class="fas fa-save"></i> Simpan
                            </button>
                        </div>

                    </div>
                </form>
            </div>
        </div>

        <div class="card-footer text-sm text-muted">
            Formulir pengisian data bantuan baru.
        </div>
    </div>

</section>

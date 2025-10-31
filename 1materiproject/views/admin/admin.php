<section class="content">

    <div class="card card-solid">
        <div class="col">
            <a href="index.php?halaman=tambahadmin" class="btn btn-primary float-right btn-sm mt-3">
                <i class="fas fa-user-plus"></i> Tambah Admin
            </a>
        </div>
        
        <div class="card-body pb-0">
            <div class="row">
                
                <?php
                // Diasumsikan koneksi.php sudah di-include sebelumnya
                
                // Query untuk mengambil semua data admin
                $sqladmin = mysqli_query($koneksi, "SELECT * FROM admin ORDER BY id_admin ASC");

                if (!$sqladmin) {
                    echo "<div class='col-12'><div class='alert alert-danger'>Query Error: " . mysqli_error($koneksi) . "</div></div>";
                } else if (mysqli_num_rows($sqladmin) == 0) {
                    echo "<div class='col-12'><div class='alert alert-info'>Tidak ada data Admin yang ditemukan.</div></div>";
                } else {
                    while ($data = mysqli_fetch_array($sqladmin)) {
                        
                        // Menentukan jalur foto
                        // Jika kolom 'foto' NULL atau kosong, gunakan placeholder default
                        $foto_file = $data['foto'];
                        if (empty($foto_file)) {
                            // Asumsi ada gambar placeholder default di folder 'dist/img/'
                            $foto_src = "../../dist/img/avatar5.png"; 
                        } else {
                            // Sesuaikan jalur 'foto/' sesuai dengan lokasi penyimpanan Anda
                            $foto_src = "foto/" . $foto_file; 
                        }
                        
                        // Membuat variabel untuk detail yang tidak ada di tabel 'admin' (meniru template)
                        // Karena tabel 'admin' hanya punya nama_admin, username, password, dan foto,
                        // Detail lain seperti alamat, telepon, dan title diambil dari nilai statis atau diisi berdasarkan data yang ada.
                        $admin_title = "Administrator Sistem"; // Bisa diganti sesuai peran
                        $admin_username = $data['username'];
                        $admin_password = $data['password']; // Catatan: Dalam praktek nyata, JANGAN TAMPILKAN password!

                ?>
                
                <div class="col-12 col-sm-6 col-md-4 d-flex align-items-stretch flex-column">
                    <div class="card bg-light d-flex flex-fill">
                        <div class="card-header text-muted border-bottom-0">
                            <?php echo $admin_title; ?>
                        </div>
                        <div class="card-body pt-0">
                            <div class="row">
                                <div class="col-7">
                                    <h2 class="lead"><b><?php echo $data['nama_admin']; ?></b></h2>
                                    <p class="text-muted text-sm">
                                        <b>Username: </b> <?php echo $admin_username; ?> <br>
                                        <b>Password: </b> ********
                                    </p>
                                    <ul class="ml-4 mb-0 fa-ul text-muted">
                                        <li class="small"><span class="fa-li"><i class="fas fa-lg fa-user-tag"></i></span> ID Admin: <?php echo $data['id_admin']; ?></li>
                                        <li class="small"><span class="fa-li"><i class="fas fa-lg fa-unlock-alt"></i></span> Pass (Hanya Dev): <?php echo $admin_password; ?></li> 
                                    </ul>
                                </div>
                                <div class="col-5 text-center">
                                    <img src="<?php echo $foto_src; ?>" alt="Foto Admin" class="img-circle img-fluid" style="width: 90px; height: 90px; object-fit: cover;">
                                </div>
                            </div>
                        </div>
                        <div class="card-footer">
                            <div class="text-right">
                                <a href='db/dbadmin.php?proses=hapus&id_admin=<?php echo $data['id_admin']; ?>' class="btn btn-sm btn-danger" onclick="return confirm('Yakin ingin menghapus Admin <?php echo $data['nama_admin']; ?>?');">
                                    <i class="fas fa-trash"></i> Hapus
                                </a>
                                <a href="index.php?halaman=editadmin&id_admin=<?php echo $data['id_admin']; ?>" class="btn btn-sm btn-warning">
                                    <i class="fas fa-edit"></i> Edit Admin
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
                <?php
                    } // end while
                } // end else
                ?>
                
            </div>
        </div>
    </div>
        <div class="card-footer">
            <nav aria-label="Contacts Page Navigation">
                <ul class="pagination justify-content-center m-0">
                    <li class="page-item active"><a class="page-link" href="#">1</a></li>
                    <li class="page-item"><a class="page-link" href="#">2</a></li>
                    </ul>
            </nav>
        </div>
        </div>
    </section>
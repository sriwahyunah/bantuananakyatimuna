<?php
// Pastikan user sudah login
if (!isset($_SESSION['admin'])) {
    header("Location: login.php");
    exit;
}

// ambil data admin dari session
$admin = $_SESSION['admin'];
?>

<section class="content">
    <div class="container-fluid">

        <!-- Header -->
        <div class="row mb-3">
            <div class="col-12">
                <h3 class="text-white">Profil Admin</h3>
            </div>
        </div>

        <div class="row">

            <!-- KIRI: FOTO + INFO SINGKAT -->
            <div class="col-md-3">
                <div class="card card-primary card-outline">
                    <div class="card-body box-profile text-center">

                        <!-- Foto Profile -->
                        <img class="profile-user-img img-fluid img-circle"
                             src="dist/img/user2-160x160.jpg"
                             alt="User profile picture">

                        <h3 class="profile-username text-center mt-2">
                            <?= htmlspecialchars($admin['nama_admin']); ?>
                        </h3>

                        <p class="text-muted text-center">Administrator Sistem</p>

                        <!-- List Info -->
                        <ul class="list-group list-group-unbordered mb-3">
                            <li class="list-group-item">
                                <b>Username</b>
                                <span class="float-right">
                                    <?= htmlspecialchars($admin['username']); ?>
                                </span>
                            </li>

                            <li class="list-group-item">
                                <b>Email</b>
                                <span class="float-right">
                                    <?= htmlspecialchars($admin['email']); ?>
                                </span>
                            </li>

                            <li class="list-group-item">
                                <b>Level</b>
                                <span class="float-right badge bg-primary">Admin</span>
                            </li>
                        </ul>

                        <a href="index.php?halaman=editadmin&id=<?= $admin['id_admin']; ?>" 
                           class="btn btn-primary btn-block">
                            <b>Edit Profil</b>
                        </a>

                    </div>
                </div>
            </div>

            <!-- KANAN: ABOUT ME -->
            <div class="col-md-9">
                <div class="card card-primary">
                    <div class="card-header">
                        <h3 class="card-title">Tentang Saya</h3>
                    </div>

                    <div class="card-body">
                        <strong><i class="fas fa-user mr-1"></i> Nama Lengkap</strong>
                        <p class="text-muted"><?= htmlspecialchars($admin['nama_admin']); ?></p>
                        <hr>

                        <strong><i class="fas fa-envelope mr-1"></i> Email</strong>
                        <p class="text-muted"><?= htmlspecialchars($admin['email']); ?></p>
                        <hr>

                        <strong><i class="fas fa-clock mr-1"></i> Login Terakhir</strong>
                        <p class="text-muted">
                            <?= date("d M Y H:i"); ?> WIB
                        </p>
                        <hr>

                        <strong><i class="fas fa-info-circle mr-1"></i> Keterangan</strong>
                        <p class="text-muted">
                            Ini adalah akun admin yang digunakan untuk mengelola sistem BantuYatim,
                            termasuk data penerima bantuan, donasi, dan transaksi.
                        </p>

                    </div>
                </div>
            </div>

        </div>
    </div>
</section>

<?php
session_start();
include "koneksi.php";

$error = "";

if (isset($_POST['login'])) {

    $username = mysqli_real_escape_string($koneksi, $_POST['username']);
    $password = mysqli_real_escape_string($koneksi, $_POST['password']);

    // Ambil akun admin dari database
    $query = mysqli_query($koneksi, "SELECT * FROM admin WHERE username='$username'");
    $data  = mysqli_fetch_assoc($query);

    if ($data) {
        // Cek password BCRYPT, MD5, dan Plaintext (Logika Anda Dibiarkan Utuh)
        if (
            password_verify($password, $data['password']) ||
            (md5($password) == $data['password']) ||
            ($password == $data['password'])
        ) {
            // Jika menggunakan MD5/Plaintext lama, langsung update ke BCRYPT
            if (!password_verify($password, $data['password'])) {
                $new_hash = password_hash($password, PASSWORD_DEFAULT);
                mysqli_query($koneksi, "UPDATE admin SET password='$new_hash' WHERE id_admin='{$data['id_admin']}'");
            }

            $_SESSION['admin'] = $data['nama_admin'];
            $_SESSION['id_admin'] = $data['id_admin'];

            header("Location: index.php?halaman=dashboard");
            exit;
        } else {
            $error = "Password salah!";
        }
    } else {
        $error = "Username tidak ditemukan!";
    }
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Login Admin | Bantuan Anak Yatim</title>

    <!-- Google Font: Source Sans Pro (Digunakan AdminLTE) -->
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">
    <!-- Font Awesome (Untuk ikon user/kunci) -->
    <link rel="stylesheet" href="plugins/fontawesome-free/css/all.min.css">
    <!-- CSS AdminLTE (Hanya digunakan untuk form-control dan btn) -->
    <link rel="stylesheet" href="dist/css/adminlte.min.css">

    <style>
        /* DEFINISI WARNA BARU UNTUK TEMA YATIM CARE */
        :root {
            --color-primary-yatim: #1ABC9C;
            /* Hijau Teal yang memberi kesan harapan dan amal */
            --color-dark-overlay: rgba(0, 0, 0, 0.55);
            --color-transparent-bg: rgba(255, 255, 255, 0.05);
            /* Transparansi sangat rendah */
            --color-border-translucent: rgba(255, 255, 255, 0.3);
        }

        /* CSS KUSTOM UNTUK EFEK GAMBAR BACKGROUND DAN TRANSPARAN */

        body {
            /* Ganti URL gambar ini dengan path ke gambar bertema anak yatim Anda */
            background: url('assets/images/bg-yatim.jpg') no-repeat center center fixed;
            background-size: cover;
            font-family: 'Source Sans Pro', sans-serif;
            display: flex;
            justify-content: center;
            align-items: center;
            min-height: 100vh;
            margin: 0;
            overflow: hidden;
        }

        /* Overlay Transparan Gelap */
        body::before {
            content: '';
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background-color: var(--color-dark-overlay);
            /* Overlay hitam lebih tegas */
        }

        .login-container {
            position: relative;
            z-index: 10;
            width: 380px;
            padding: 40px;
            /* Padding sedikit lebih besar */
            border-radius: 12px;

            /* Efek Glassmorphism Lebih Halus */
            background: var(--color-transparent-bg);
            backdrop-filter: blur(8px);
            /* Blur sedikit lebih kuat */
            box-shadow: 0 8px 32px 0 rgba(0, 0, 0, 0.37);
            /* Shadow lebih dramatis */
            border: 1px solid var(--color-border-translucent);
            text-align: center;
        }

        .login-container h2 {
            color: #fff;
            font-size: 32px;
            font-weight: 700;
            margin-bottom: 25px;
            border-bottom: 3px solid var(--color-primary-yatim);
            /* Garis tebal dengan warna baru */
            display: inline-block;
            padding-bottom: 5px;
            letter-spacing: 1px;
            text-shadow: 0 0 15px rgba(0, 0, 0, 0.8);
            /* Shadow pada teks */
        }

        .login-container p {
            color: rgba(255, 255, 255, 0.9);
            /* Sedikit lebih terang */
            margin-bottom: 30px;
            text-shadow: 0 0 5px rgba(0, 0, 0, 0.5);
        }

        /* Styling Input Field */
        .input-group input.form-control {
            background: var(--color-transparent-bg);
            border: 1px solid var(--color-border-translucent);
            color: #fff;
            height: 50px;
            /* Input lebih tinggi */
            border-radius: 8px;
            /* Sudut lebih membulat */
            transition: all 0.3s ease;
        }

        .input-group input.form-control:focus {
            background: rgba(255, 255, 255, 0.15);
            border-color: var(--color-primary-yatim);
            box-shadow: 0 0 10px var(--color-primary-yatim);
            /* Glow focus */
        }

        .input-group input::placeholder {
            color: rgba(255, 255, 255, 0.7);
        }

        /* Styling Ikon di Input Group */
        .input-group-text {
            background: var(--color-transparent-bg);
            border: 1px solid var(--color-border-translucent);
            border-left: none;
            color: var(--color-primary-yatim);
            /* Ikon berwarna baru */
            font-size: 1.1rem;
            border-radius: 0 8px 8px 0;
            /* Sesuaikan sudut */
        }

        /* Tombol Login */
        .btn-primary {
            background-color: var(--color-primary-yatim);
            border-color: var(--color-primary-yatim);
            font-weight: bold;
            letter-spacing: 1px;
            padding: 12px;
            border-radius: 8px;
            transition: all 0.3s ease;
            box-shadow: 0 4px 15px rgba(26, 188, 156, 0.4);
            /* Shadow pada tombol */
        }

        .btn-primary:hover,
        .btn-primary:focus {
            background-color: #16a085;
            /* Warna hover sedikit lebih gelap */
            border-color: #16a085;
            transform: translateY(-3px);
            /* Efek angkat (Hover Effect) */
            box-shadow: 0 8px 25px rgba(26, 188, 156, 0.8);
        }

        /* Pesan Error */
        .alert-danger {
            background-color: rgba(220, 53, 69, 0.8);
            border-color: rgba(220, 53, 69, 0.8);
            color: #fff;
            border-radius: 8px;
        }
    </style>
</head>

<body>

    <!-- Kontainer Login Transparan -->
    <div class="login-container">

        <!-- Bagian Judul -->
        <h2><i class="fas fa-hand-holding-heart"></i> Bantuan Anak Yatim</h2>


        <!-- Pesan Error -->
        <?php if ($error != "") { ?>
            <div class="alert alert-danger" role="alert">
                <?= $error ?>
            </div>
        <?php } ?>

        <form method="POST">
            <!-- Input Username -->
            <div class="input-group mb-3">
                <input type="text" class="form-control" name="username" placeholder="Masukkan Username" required>
                <div class="input-group-append">
                    <div class="input-group-text">
                        <span class="fas fa-user"></span>
                    </div>
                </div>
            </div>

            <!-- Input Password -->
            <div class="input-group mb-3">
                <input type="password" class="form-control" name="password" placeholder="Masukkan Password" required>
                <div class="input-group-append">
                    <div class="input-group-text">
                        <span class="fas fa-lock"></span>
                    </div>
                </div>
            </div>

            <!-- Tombol Login -->
            <div class="row">
                <div class="col-12">
                    <button type="submit" name="login" class="btn btn-primary btn-block">
                        <i class="fas fa-sign-in-alt"></i> MASUK SISTEM
                    </button>
                </div>
            </div>
        </form>
    </div>

    <!-- Script JS (Dipertahankan) -->
    <script src="plugins/jquery/jquery.min.js"></script>
    <script src="plugins/bootstrap/js/bootstrap.bundle.min.js"></script>
    <script src="dist/js/adminlte.min.js"></script>

</body>

</html>
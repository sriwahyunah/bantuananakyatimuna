<?php
// ============================================================
<<<<<<< HEAD
// File: views/otentikasiuser/loginuser.php (modernized)
// Login aplikasi bantuananakyatimuna2
// ============================================================

require_once __DIR__ . '/../../includes/path.php';
require_once INCLUDES_PATH . 'konfig.php';

=======
// File: views/otentikasipenerima/loginpenerima.php
// Login aplikasi bantuananakyatimuna2 untuk role penerima
// ============================================================

// Include path dan konfigurasi
require_once __DIR__ . '/../../includes/path.php';
require_once INCLUDES_PATH . 'konfig.php';

// Mulai session
>>>>>>> 28924cc2c2fede24d1e338ee57a7af3c314455d0
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

<<<<<<< HEAD
if (isset($_SESSION['role'])) {
    if ($_SESSION['role'] === 'admin') {
        header("Location: " . BASE_URL . "?hal=dashboardadmin");
        exit();
    } elseif ($_SESSION['role'] === 'petugas') {
        header("Location: " . BASE_URL . "?hal=dashboardpetugas");
        exit();
    } elseif ($_SESSION['role'] === 'penerima') {
        header("Location: " . BASE_URL . "?hal=dashboardpenerima");
        exit();
    }
}

$error = $_GET['pesan'] ?? '';
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login User</title>

    <!-- Bootstrap 5 CDN -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">

    <style>
        body {
            background: #f2f6ff;
        }
        .login-card {
            border-radius: 18px;
        }
        .brand-title {
            font-weight: 700;
            font-size: 1.4rem;
        }
        .toggle-password {
            position: absolute;
            right: 15px;
            top: 50%;
            transform: translateY(-50%);
            cursor: pointer;
            color: #6c757d;
        }
    </style>
</head>
<body>

<div class="container d-flex justify-content-center align-items-center" style="min-height:100vh;">
    <div class="col-md-5">
        <div class="card shadow-sm p-4 login-card">
            <h4 class="text-center mb-4 brand-title">Login User</h4>

            <?php if (!empty($error)): ?>
                <div class="alert alert-danger text-center"> <?= htmlspecialchars($error) ?> </div>
            <?php endif; ?>

            <form method="POST" action="?hal=prosesloginuser">
                <div class="mb-3">
                    <label for="username" class="form-label">Username</label>
                    <input type="text" name="username" id="username" class="form-control" required>
                </div>

                <div class="mb-3 position-relative">
                    <label for="password" class="form-label">Password</label>
                    <input type="password" name="password" id="password" class="form-control" required>
                    <span class="toggle-password" onclick="togglePassword()">👁️</span>
                </div>

                <button type="submit" class="btn btn-primary w-100 py-2">Login</button>
            </form>

            <div class="text-center mt-3">
                <a href="<?= BASE_URL ?>" class="text-decoration-none">← Kembali ke Beranda</a>
            </div>
        </div>
    </div>
</div>

<script>
function togglePassword() {
    const pass = document.getElementById('password');
    pass.type = pass.type === 'password' ? 'text' : 'password';
}
</script>

<!-- Bootstrap JS -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>

</body>
</html>
=======
// Jika sudah login, arahkan ke dashboard
if (isset($_SESSION['role']) && $_SESSION['role'] === 'penerima') {
    header("Location: " . BASE_URL . "?hal=dashboardpenerima");
    exit();
}

// Ambil pesan error jika ada
$error = $_GET['pesan'] ?? '';
?>

<style>
  .login-wrapper {
    min-height: calc(100vh - 100px);
    display: flex;
    justify-content: center;
    align-items: center;
  }

  .toggle-password {
    position: absolute;
    right: 15px;
    top: 38px;
    cursor: pointer;
    color: #777;
  }
</style>

<div class="login-wrapper">
  <div class="container">
    <div class="row justify-content-center">
      <div class="col-md-5">
        <div class="card shadow-lg border-0">

          <!-- HEADER -->
          <div class="card-header bg-primary text-center py-3">
            <h3 class="m-0 fw-bold">Login Penerima Bantuan</h3>
          </div>

          <div class="card-body p-4">

            <?php if (!empty($error)): ?>
              <div class="alert alert-danger"><?= htmlspecialchars($error) ?></div>
            <?php endif; ?>

            <form method="POST" action="?hal=prosesloginpenerima">
              <div class="mb-3">
                <label for="username" class="form-label">Username / NIS</label>
                <input type="text" name="username" id="username" class="form-control" required>
              </div>

              <div class="mb-3 position-relative">
                <label for="password" class="form-label">Password</label>
                <input type="password" name="password" id="password" class="form-control" required>
                <span class="toggle-password" onclick="togglePassword()">👁️</span>
              </div>

              <div class="d-flex justify-content-between mb-3">
                <a href="<?= BASE_URL ?>?hal=registerpenerima"
                  class="btn btn-warning px-4">
                  <b>Daftar Akun Baru</b>
                </a>
                <button type="submit" class="btn btn-primary px-4">Login</button>
              </div>
            </form>

            <div class="text-center mt-1">
              <a href="<?= BASE_URL ?>">← Kembali ke Beranda</a>
            </div>

          </div>

        </div>
      </div>
    </div>
  </div>
</div>

<script>
  function togglePassword() {
    const pass = document.getElementById('password');
    pass.type = pass.type === 'password' ? 'text' : 'password';
  }
</script>
>>>>>>> 28924cc2c2fede24d1e338ee57a7af3c314455d0

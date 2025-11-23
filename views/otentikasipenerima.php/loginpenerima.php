<?php
// views/otentikasipenerima/loginpenerima.php
if (session_status() === PHP_SESSION_NONE) session_start();
// Jika sudah login, redirect ke dashboard
if (isset($_SESSION['id_penerima'])) {
    header('Location: ?hal=dashboardpenerima');
    exit;
}
?>
<!doctype html>
<html>
<head>
  <meta charset="utf-8">
  <title>Login Penerima</title>
  <link rel="stylesheet" href="<?php echo BASE_URL; ?>assets/dist/css/bootstrap.min.css">
</head>
<body>
  <div class="container py-5">
    <h2>Login Penerima</h2>
    <?php if (!empty($_GET['pesan'])): ?>
      <div class="alert alert-warning"><?= htmlspecialchars($_GET['pesan']) ?></div>
    <?php endif; ?>
    <form action="?hal=prosesloginpenerima" method="post">
      <div class="mb-3">
        <label class="form-label">Username / NIS</label>
        <input name="username" class="form-control" required>
      </div>
      <div class="mb-3">
        <label class="form-label">Password</label>
        <input type="password" name="password" class="form-control" required>
      </div>
      <button class="btn btn-primary">Login</button>
      <a class="btn btn-link" href="?hal=registerpenerima">Daftar</a>
    </form>
  </div>
</body>
</html>

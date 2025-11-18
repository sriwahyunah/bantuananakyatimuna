<!DOCTYPE html>
<html lang="id">

<head>
  <meta charset="UTF-8">
  <title>Landing | Bantuan Anak Yatim</title>

  <!-- Google Fonts -->
  <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;600&family=Cairo:wght@600;700&display=swap" rel="stylesheet">

  <style>
    * {
      margin: 0;
      padding: 0;
      box-sizing: border-box;
      font-family: 'Poppins', sans-serif;
    }

    body {
      background: linear-gradient(135deg, #a6ffe0, #5edfa4);
      min-height: 100vh;
      text-align: center;
      color: #064c32;
      overflow-x: hidden;
      position: relative;
    }

    /* Ornamen islami */
    .pattern {
      position: absolute;
      top: -60px;
      left: -60px;
      width: 350px;
      opacity: 0.13;
    }

    .pattern2 {
      position: absolute;
      bottom: -60px;
      right: -60px;
      width: 350px;
      opacity: 0.13;
    }

    /* Cahaya */
    .glow {
      position: absolute;
      width: 600px;
      height: 600px;
      background: radial-gradient(circle, rgba(255, 255, 255, 0.5), transparent 70%);
      filter: blur(140px);
      top: -120px;
      left: -120px;
      z-index: 1;
    }

    /* Container utama */
    .container {
      position: relative;
      z-index: 10;
      margin-top: 130px;
      display: inline-block;
      background: rgba(255, 255, 255, 0.25);
      padding: 45px 60px;
      border-radius: 25px;
      backdrop-filter: blur(12px);
      box-shadow: 0 10px 35px rgba(0, 0, 0, 0.15);
      animation: fadeIn 1.4s ease;
    }

    @keyframes fadeIn {
      from {
        opacity: 0;
        transform: translateY(20px);
      }

      to {
        opacity: 1;
        transform: translateY(0);
      }
    }

    /* Logo */
    .logo {
      width: 130px;
      margin-bottom: 20px;
      animation: float 4s infinite ease-in-out;
    }

    @keyframes float {
      0%, 100% {
        transform: translateY(0);
      }
      50% {
        transform: translateY(-10px);
      }
    }

    /* Judul */
    h1 {
      font-size: 34px;
      font-family: 'Cairo', sans-serif;
      font-weight: 700;
      margin-bottom: 12px;
      color: #064c32;
    }

    p {
      font-size: 16px;
      margin-bottom: 25px;
    }

    /* Tombol */
    .btn {
      padding: 14px 35px;
      margin: 10px;
      border-radius: 10px;
      text-decoration: none;
      font-weight: 600;
      transition: 0.3s;
      display: inline-block;
      border: 2px solid #064c32;
      font-family: 'Cairo', sans-serif;
    }

    .btn-login {
      background: #064c32;
      color: white;
    }

    .btn-login:hover {
      background: #0b6e4b;
    }

    .btn-register {
      background: transparent;
      color: #064c32;
    }

    .btn-register:hover {
      background: #b4ffd8;
    }

    .btn-info {
      background: #ffffff;
      color: #064c32;
    }

    .btn-info:hover {
      background: #d0ffe9;
    }

    /* Responsif */
    @media (max-width: 600px) {
      .container {
        padding: 30px 20px;
        width: 90%;
      }

      h1 {
        font-size: 28px;
      }
    }
  </style>
</head>

<body>

  <!-- Ornamen -->
  <img src="assets/img/pattern-islamic.png" class="pattern">
  <img src="assets/img/pattern-islamic.png" class="pattern2">
  <div class="glow"></div>

  <div class="container">
    <img src="assets/img/logo.png" class="logo">

    <h1>BANTUAN ANAK YATIM</h1>
    <p>Platform untuk mengelola data anak yatim dan penyaluran bantuan secara amanah & terstruktur.</p>

    <a href="login.php" class="btn btn-login">LOGIN</a>
    <a href="register.php" class="btn btn-register">DAFTAR</a>
    <a href="informasi.php" class="btn btn-info">INFO</a>
  </div>

  <div style="position:fixed;bottom:10px;left:10px;font-size:14px;color:red;">
    FILE SEDANG DIBUKA: <?= __FILE__; ?>
  </div>

</body>

</html>

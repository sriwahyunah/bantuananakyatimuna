<?php
// =================================================================
// 1. KONFIGURASI DATABASE
// =================================================================
$servername = "localhost"; // Ganti dengan server Anda
$username = "username_anda"; // Ganti dengan username database Anda
$password = "password_anda"; // Ganti dengan password database Anda
$dbname = "nama_database_anda"; // Ganti dengan nama database Anda
$tableName = "detail_pembayaran"; // Nama tabel yang sesuai dengan kolom di gambar

// =================================================================
// 2. PROSES FORM SUBMISSION
// =================================================================
$message = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Ambil dan bersihkan data dari form
    // id_detail diasumsikan AUTO_INCREMENT di DB, jadi tidak diinput
    $id_transaksi = filter_input(INPUT_POST, 'id_transaksi', FILTER_SANITIZE_NUMBER_INT);
    $id_bantuan = filter_input(INPUT_POST, 'id_bantuan', FILTER_SANITIZE_NUMBER_INT);
    $jumlah = filter_input(INPUT_POST, 'jumlah', FILTER_SANITIZE_NUMBER_INT);
    $keterangan = filter_input(INPUT_POST, 'keterangan', FILTER_SANITIZE_STRING);

    // Validasi sederhana
    if (empty($id_transaksi) || empty($id_bantuan) || empty($jumlah)) {
        $message = "<div style='color: red;'>⚠️ Harap isi ID Transaksi, ID Bantuan, dan Jumlah.</div>";
    } else {
        // Buat koneksi ke database
        $conn = new mysqli($servername, $username, $password, $dbname);

        // Cek koneksi
        if ($conn->connect_error) {
            die("Koneksi gagal: " . $conn->connect_error);
        }

        // Siapkan pernyataan INSERT menggunakan Prepared Statements
        // Menggunakan '?' sebagai placeholder
        $sql = "INSERT INTO $tableName (id_transaksi, id_bantuan, jumlah, keterangan) VALUES (?, ?, ?, ?)";
        
        $stmt = $conn->prepare($sql);

        // Bind parameter ke placeholder
        // 'iiis' berarti: integer, integer, integer, string
        // Sesuaikan dengan tipe data kolom Anda di database (misalnya, jika 'jumlah' adalah DECIMAL/DOUBLE/VARCHAR, ganti 'i' yang ketiga)
        $stmt->bind_param("iiis", $id_transaksi, $id_bantuan, $jumlah, $keterangan);

        // Eksekusi pernyataan
        if ($stmt->execute()) {
            $message = "<div style='color: green;'>✅ Data pembayaran berhasil ditambahkan!</div>";
            // Kosongkan variabel setelah sukses
            $id_transaksi = $id_bantuan = $jumlah = $keterangan = '';
        } else {
            $message = "<div style='color: red;'>❌ Error: " . $stmt->error . "</div>";
        }

        // Tutup statement dan koneksi
        $stmt->close();
        $conn->close();
    }
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Input Detail Pembayaran</title>
    <style>
        body { font-family: Arial, sans-serif; }
        .container { max-width: 600px; margin: 50px auto; padding: 20px; border: 1px solid #ccc; border-radius: 5px; }
        label { display: block; margin-top: 10px; font-weight: bold; }
        input[type="text"], input[type="number"], textarea { width: 100%; padding: 8px; margin-top: 5px; border: 1px solid #ddd; border-radius: 4px; box-sizing: border-box; }
        button { background-color: #4CAF50; color: white; padding: 10px 15px; border: none; border-radius: 4px; cursor: pointer; margin-top: 20px; }
        button:hover { background-color: #45a049; }
    </style>
</head>
<body>

<div class="container">
    <h2>💳 Input Detail Pembayaran</h2>

    <?php echo $message; ?>

    <form method="POST" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>">
        <label for="id_transaksi">ID Transaksi:</label>
        <input type="number" id="id_transaksi" name="id_transaksi" required 
               value="<?php echo isset($id_transaksi) ? htmlspecialchars($id_transaksi) : ''; ?>">

        <label for="id_bantuan">ID Bantuan:</label>
        <input type="number" id="id_bantuan" name="id_bantuan" required 
               value="<?php echo isset($id_bantuan) ? htmlspecialchars($id_bantuan) : ''; ?>">

        <label for="jumlah">Jumlah:</label>
        <input type="number" id="jumlah" name="jumlah" required 
               value="<?php echo isset($jumlah) ? htmlspecialchars($jumlah) : ''; ?>">

        <label for="keterangan">Keterangan:</label>
        <textarea id="keterangan" name="keterangan"><?php echo isset($keterangan) ? htmlspecialchars($keterangan) : ''; ?></textarea>

        <button type="submit">Simpan Pembayaran</button>
    </form>
</div>

</body>
</html>
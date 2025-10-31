<?php
// Panggil file konfigurasi database
include 'dbpembayaran.php';

$message = "";
$error = false;
$id_transaksi = $id_bantuan = $jumlah = $keterangan = ''; // Inisialisasi variabel

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // 1. Ambil data mentah
    $id_transaksi = trim($_POST['id_transaksi']);
    $id_bantuan = trim($_POST['id_bantuan']);
    $jumlah = trim($_POST['jumlah']);
    $keterangan = trim($_POST['keterangan']);

    // 2. Validasi Ketat
    if (empty($id_transaksi) || empty($id_bantuan) || empty($jumlah)) {
        $message = "<div style='color: red;'>⚠️ ID Transaksi, ID Bantuan, dan Jumlah wajib diisi.</div>";
        $error = true;
    } 
    
    // Pastikan ID Transaksi adalah bilangan bulat positif
    if (!$error && (!filter_var($id_transaksi, FILTER_VALIDATE_INT) || $id_transaksi <= 0)) {
        $message = "<div style='color: red;'>⚠️ ID Transaksi harus berupa angka bulat positif.</div>";
        $error = true;
    }

    // Pastikan ID Bantuan adalah bilangan bulat positif
    if (!$error && (!filter_var($id_bantuan, FILTER_VALIDATE_INT) || $id_bantuan <= 0)) {
        $message = "<div style='color: red;'>⚠️ ID Bantuan harus berupa angka bulat positif.</div>";
        $error = true;
    }
    
    // Pastikan Jumlah adalah bilangan bulat non-negatif
    if (!$error && (!filter_var($jumlah, FILTER_VALIDATE_INT) || $jumlah < 0)) {
        $message = "<div style='color: red;'>⚠️ Jumlah harus berupa angka bulat non-negatif.</div>";
        $error = true;
    }


    // 3. Simpan data jika tidak ada error
    if (!$error) {
        // Sanitasi data yang lolos validasi
        $id_transaksi_safe = (int)$id_transaksi;
        $id_bantuan_safe = (int)$id_bantuan;
        $jumlah_safe = (int)$jumlah;
        $keterangan_safe = htmlspecialchars($keterangan, ENT_QUOTES, 'UTF-8');

        // Siapkan pernyataan INSERT menggunakan Prepared Statements
        $sql = "INSERT INTO $table_name (id_transaksi, id_bantuan, jumlah, keterangan) VALUES (?, ?, ?, ?)";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("iiis", $id_transaksi_safe, $id_bantuan_safe, $jumlah_safe, $keterangan_safe);

        if ($stmt->execute()) {
            $message = "<div style='color: green;'>✅ Data pembayaran berhasil ditambahkan!</div>";
            // Kosongkan form setelah sukses
            $id_transaksi = $id_bantuan = $jumlah = $keterangan = '';
        } else {
            $message = "<div style='color: red;'>❌ Error saat menyimpan: " . $stmt->error . "</div>";
        }
        $stmt->close();
    }
}
$conn->close();
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Tambah Pembayaran</title>
    </head>
<body>
    <h2>➕ Tambah Detail Pembayaran Baru</h2>
    <?php echo $message; ?>

    <form method="POST" action="tambahpembayaran.php">
        <label for="id_transaksi">ID Transaksi (Wajib):</label>
        <input type="number" id="id_transaksi" name="id_transaksi" required 
               value="<?php echo htmlspecialchars($id_transaksi); ?>"><br><br>

        <label for="id_bantuan">ID Bantuan (Wajib):</label>
        <input type="number" id="id_bantuan" name="id_bantuan" required 
               value="<?php echo htmlspecialchars($id_bantuan); ?>"><br><br>

        <label for="jumlah">Jumlah (Wajib):</label>
        <input type="number" id="jumlah" name="jumlah" required 
               value="<?php echo htmlspecialchars($jumlah); ?>"><br><br>

        <label for="keterangan">Keterangan:</label>
        <textarea id="keterangan" name="keterangan"><?php echo htmlspecialchars($keterangan); ?></textarea><br><br>

        <button type="submit">Simpan Data</button>
    </form>
</body>
</html>
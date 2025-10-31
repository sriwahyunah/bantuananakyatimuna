<?php
// Panggil file konfigurasi database
include 'dbpembayaran.php';

$message = "";

// Cek apakah ada ID Detail yang dikirim melalui URL
if (!isset($_GET['id']) || empty($_GET['id'])) {
    die("ID Detail tidak ditemukan.");
}

$id_detail_to_edit = filter_input(INPUT_GET, 'id', FILTER_SANITIZE_NUMBER_INT);

// =================================================================
// 1. PROSES UPDATE DATA (Jika form disubmit)
// =================================================================
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Ambil dan bersihkan data yang diupdate
    $id_transaksi = filter_input(INPUT_POST, 'id_transaksi', FILTER_SANITIZE_NUMBER_INT);
    $id_bantuan = filter_input(INPUT_POST, 'id_bantuan', FILTER_SANITIZE_NUMBER_INT);
    $jumlah = filter_input(INPUT_POST, 'jumlah', FILTER_SANITIZE_NUMBER_INT);
    $keterangan = filter_input(INPUT_POST, 'keterangan', FILTER_SANITIZE_STRING);

    // Siapkan query UPDATE
    $sql = "UPDATE $table_name SET id_transaksi=?, id_bantuan=?, jumlah=?, keterangan=? WHERE id_detail=?";
    $stmt = $conn->prepare($sql);

    // Bind parameter: i=integer, s=string
    $stmt->bind_param("iiisi", $id_transaksi, $id_bantuan, $jumlah, $keterangan, $id_detail_to_edit);

    if ($stmt->execute()) {
        $message = "<div style='color: green;'>✅ Data dengan ID **$id_detail_to_edit** berhasil diupdate!</div>";
        // Header('Location: daftar_pembayaran.php'); // Opsional: Redirect ke halaman daftar
    } else {
        $message = "<div style='color: red;'>❌ Error saat mengupdate: " . $stmt->error . "</div>";
    }

    $stmt->close();
}

// =================================================================
// 2. AMBIL DATA SAAT INI UNTUK DITAMPILKAN DI FORM
// =================================================================

// Siapkan query SELECT
$sql_select = "SELECT id_transaksi, id_bantuan, jumlah, keterangan FROM $table_name WHERE id_detail = ?";
$stmt_select = $conn->prepare($sql_select);
$stmt_select->bind_param("i", $id_detail_to_edit);
$stmt_select->execute();
$result = $stmt_select->get_result();

if ($result->num_rows === 0) {
    die("Data pembayaran tidak ditemukan.");
}

// Ambil data hasil query
$data = $result->fetch_assoc();
$stmt_select->close();
$conn->close();
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Edit Pembayaran</title>
    </head>
<body>
    <h2>✏️ Edit Detail Pembayaran (ID: <?php echo htmlspecialchars($id_detail_to_edit); ?>)</h2>
    <?php echo $message; ?>

    <form method="POST" action="editpembayaran.php?id=<?php echo htmlspecialchars($id_detail_to_edit); ?>">
        
        <label for="id_transaksi">ID Transaksi:</label>
        <input type="number" id="id_transaksi" name="id_transaksi" required 
               value="<?php echo htmlspecialchars($data['id_transaksi']); ?>"><br><br>

        <label for="id_bantuan">ID Bantuan:</label>
        <input type="number" id="id_bantuan" name="id_bantuan" required 
               value="<?php echo htmlspecialchars($data['id_bantuan']); ?>"><br><br>

        <label for="jumlah">Jumlah:</label>
        <input type="number" id="jumlah" name="jumlah" required 
               value="<?php echo htmlspecialchars($data['jumlah']); ?>"><br><br>

        <label for="keterangan">Keterangan:</label>
        <textarea id="keterangan" name="keterangan"><?php echo htmlspecialchars($data['keterangan']); ?></textarea><br><br>

        <button type="submit">Update Data</button>
    </form>
</body>
</html>
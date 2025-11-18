<?php
include "../koneksi.php";
session_start();

$proses = isset($_GET['proses']) ? $_GET['proses'] : '';

if ($proses == 'tambah') {
    // ambil data post aman
    $id_admin  = isset($_POST['id_admin']) ? (int)$_POST['id_admin'] : null;
    $id_bantuan = isset($_POST['id_bantuan']) ? (int)$_POST['id_bantuan'] : null; // kalau form ada
    $id_penerima = isset($_POST['id_penerima']) ? (int)$_POST['id_penerima'] : null;
    $nominal = isset($_POST['nominal']) ? $_POST['nominal'] : null;

    // tanggal_pembayaran di tabel transaksi - beberapa form mungkin mengirim nama berbeda
    $tanggal_pembayaran = null;
    if (!empty($_POST['tanggal_pembayaran'])) {
        $tanggal_pembayaran = $_POST['tanggal_pembayaran'];
    } elseif (!empty($_POST['tanggal_bantuan_keluar'])) {
        // fallback jika form menggunakan nama lama
        $tanggal_pembayaran = $_POST['tanggal_bantuan_keluar'];
    }

    // Upload foto struk
    $fotobuktistruk = null;
    if (!empty($_FILES['fotobuktistruk']['name'])) {
        $foto_name = time() . "_" . basename($_FILES['fotobuktistruk']['name']);
        $target = "../uploads/" . $foto_name;
        if (move_uploaded_file($_FILES['fotobuktistruk']['tmp_name'], $target)) {
            $fotobuktistruk = $foto_name;
        }
    }

    // Masukkan ke tabel transaksi (kolom sesuai DB: id_admin, id_bantuan, id_penerima, nominal, tanggal_pembayaran, fotobuktistruk)
    $sql = "INSERT INTO transaksi (id_admin, id_bantuan, id_penerima, nominal, tanggal_pembayaran, fotobuktistruk)
            VALUES (?, ?, ?, ?, ?, ?)";
    $stmt = $koneksi->prepare($sql);
    if (!$stmt) {
        die("Prepare failed: " . $koneksi->errno . " - " . $koneksi->error);
    }
    // tipe: i = integer, d = double, s = string
    $stmt->bind_param("iiidss",
        $id_admin,
        $id_bantuan,
        $id_penerima,
        $nominal,
        $tanggal_pembayaran,
        $fotobuktistruk
    );

    if ($stmt->execute()) {
        // Jika form juga mengirim kelas/status dan kamu ingin menyimpannya ke tabel penerima:
        if (!empty($_POST['kelas']) || !empty($_POST['status'])) {
            $kelas = isset($_POST['kelas']) ? $_POST['kelas'] : null;
            $status = isset($_POST['status']) ? $_POST['status'] : null;

            // Update penerima (hanya field yang dikirim)
            $updateParts = [];
            $params = [];
            $types = '';

            if ($kelas !== null) {
                $updateParts[] = "kelas = ?";
                $params[] = $kelas; $types .= 's';
            }
            if ($status !== null) {
                $updateParts[] = "status = ?";
                $params[] = $status; $types .= 's';
            }

            if (!empty($updateParts) && $id_penerima) {
                $sqlUp = "UPDATE penerima SET " . implode(", ", $updateParts) . " WHERE id_penerima = ?";
                $params[] = $id_penerima; $types .= 'i';
                $stmtUp = $koneksi->prepare($sqlUp);
                if ($stmtUp) {
                    // bind dinamis
                    $bind_names[] = $types;
                    for ($i = 0; $i < count($params); $i++) {
                        $bind_names[] = &$params[$i];
                    }
                    call_user_func_array(array($stmtUp, 'bind_param'), $bind_names);
                    $stmtUp->execute();
                    $stmtUp->close();
                }
            }
        }

        echo "<script>alert('Data transaksi berhasil ditambahkan');window.location='../views/transaksi/transaksi.php';</script>";
    } else {
        echo "Gagal menyimpan transaksi: " . $stmt->error;
    }
    $stmt->close();
}

// EDIT
if ($proses == 'edit') {
    $id_transaksi = isset($_POST['id_transaksi']) ? (int)$_POST['id_transaksi'] : 0;
    $id_admin = isset($_POST['id_admin']) ? (int)$_POST['id_admin'] : null;
    $id_bantuan = isset($_POST['id_bantuan']) ? (int)$_POST['id_bantuan'] : null;
    $id_penerima = isset($_POST['id_penerima']) ? (int)$_POST['id_penerima'] : null;
    $nominal = isset($_POST['nominal']) ? $_POST['nominal'] : null;
    $tanggal_pembayaran = $_POST['tanggal_pembayaran'] ?? $_POST['tanggal_bantuan_keluar'] ?? null;

    // ambil data lama foto
    $res = $koneksi->query("SELECT fotobuktistruk FROM transaksi WHERE id_transaksi=" . (int)$id_transaksi);
    $data_lama = $res ? $res->fetch_assoc() : null;
    $fotobuktistruk_lama = $data_lama['fotobuktistruk'] ?? null;

    // handle upload
    $fotobuktistruk = $fotobuktistruk_lama;
    if (!empty($_FILES['fotobuktistruk']['name'])) {
        $foto_name = time() . "_" . basename($_FILES['fotobuktistruk']['name']);
        $target_dir = "../uploads/";
        $target_file = $target_dir . $foto_name;
        if (move_uploaded_file($_FILES['fotobuktistruk']['tmp_name'], $target_file)) {
            if (!empty($fotobuktistruk_lama) && file_exists($target_dir . $fotobuktistruk_lama)) {
                @unlink($target_dir . $fotobuktistruk_lama);
            }
            $fotobuktistruk = $foto_name;
        }
    }

    // Update transaksi (kolom sesuai DB)
    $sql = "UPDATE transaksi SET id_admin=?, id_bantuan=?, id_penerima=?, nominal=?, tanggal_pembayaran=?, fotobuktistruk=? WHERE id_transaksi=?";
    $stmt = $koneksi->prepare($sql);
    if (!$stmt) {
        die("Prepare failed: " . $koneksi->error);
    }
    $stmt->bind_param("iiidssi",
        $id_admin,
        $id_bantuan,
        $id_penerima,
        $nominal,
        $tanggal_pembayaran,
        $fotobuktistruk,
        $id_transaksi
    );

    if ($stmt->execute()) {
        // update penerima jika ada field kelas/status dikirim
        if (!empty($_POST['kelas']) || !empty($_POST['status'])) {
            $kelas = $_POST['kelas'] ?? null;
            $status = $_POST['status'] ?? null;

            $updateParts = [];
            $params = [];
            $types = '';

            if ($kelas !== null) { $updateParts[] = "kelas = ?"; $params[] = $kelas; $types .= 's'; }
            if ($status !== null) { $updateParts[] = "status = ?"; $params[] = $status; $types .= 's'; }

            if (!empty($updateParts) && $id_penerima) {
                $sqlUp = "UPDATE penerima SET " . implode(", ", $updateParts) . " WHERE id_penerima = ?";
                $params[] = $id_penerima; $types .= 'i';
                $stmtUp = $koneksi->prepare($sqlUp);
                if ($stmtUp) {
                    $bind_names[] = $types;
                    for ($i = 0; $i < count($params); $i++) $bind_names[] = &$params[$i];
                    call_user_func_array(array($stmtUp, 'bind_param'), $bind_names);
                    $stmtUp->execute();
                    $stmtUp->close();
                }
            }
        }

        echo "<script>alert('✅ Data transaksi berhasil diperbarui!');window.location='../index.php?halaman=transaksi';</script>";
    } else {
        echo "<script>alert('❌ Gagal memperbarui data transaksi!');window.history.back();</script>";
    }
    $stmt->close();
}

$koneksi->close();

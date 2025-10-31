<?php
include "../koneksi.php";
session_start();

// =============================================================
// CEK KONEKSI DATABASE
// =============================================================
if (mysqli_connect_errno()) {
    echo "Gagal terhubung ke MySQL: " . mysqli_connect_error();
    exit();
}

// Ambil parameter proses
$proses = isset($_GET['proses']) ? $_GET['proses'] : '';


// =============================================================
// 1️⃣ PROSES TAMBAH DATA PENERIMA
// =============================================================
if ($proses == 'tambah') {

    $nisp        = mysqli_real_escape_string($koneksi, $_POST['nisp']);
    $nama        = mysqli_real_escape_string($koneksi, $_POST['nama_penerima']);
    $status      = mysqli_real_escape_string($koneksi, $_POST['status']);
    $kelas       = mysqli_real_escape_string($koneksi, $_POST['kelas']);
    $tanggal     = mysqli_real_escape_string($koneksi, $_POST['tanggal_lahir']);
    $alamat      = mysqli_real_escape_string($koneksi, $_POST['alamat']);
    $pendapatan  = mysqli_real_escape_string($koneksi, $_POST['pendapatanorangtua']);

    // === Upload Foto ===
    $foto = '';
    if (!empty($_FILES['foto']['name'])) {
        $nama_foto = time() . '_' . basename($_FILES['foto']['name']);
        $tmp = $_FILES['foto']['tmp_name'];
        $folder = "../uploads/";

        if (!is_dir($folder)) mkdir($folder, 0777, true);

        move_uploaded_file($tmp, $folder . $nama_foto);
        $foto = $nama_foto;
    }

    // === Simpan ke database ===
    $query = "INSERT INTO penerima (nisp, nama_penerima, status, kelas, tanggal_lahir, alamat, pendapatanorangtua, foto)
              VALUES ('$nisp', '$nama', '$status', '$kelas', '$tanggal', '$alamat', '$pendapatan', '$foto')";

    if (mysqli_query($koneksi, $query)) {
        header("Location: ../views/penerima/penerima.php?pesan=berhasil_tambah");
        exit();
    } else {
        echo "Gagal menambah data: " . mysqli_error($koneksi);
        exit();
    }
}



// =============================================================
// 2️⃣ PROSES EDIT / UPDATE DATA PENERIMA
// =============================================================
elseif ($proses == 'edit') {

    $id          = mysqli_real_escape_string($koneksi, $_POST['id_penerima']);
    $nisp        = mysqli_real_escape_string($koneksi, $_POST['nisp']);
    $nama        = mysqli_real_escape_string($koneksi, $_POST['nama_penerima']);
    $status      = mysqli_real_escape_string($koneksi, $_POST['status']);
    $kelas       = mysqli_real_escape_string($koneksi, $_POST['kelas']);
    $tanggal     = mysqli_real_escape_string($koneksi, $_POST['tanggal_lahir']);
    $alamat      = mysqli_real_escape_string($koneksi, $_POST['alamat']);
    $pendapatan  = mysqli_real_escape_string($koneksi, $_POST['pendapatanorangtua']);

    // Ambil foto lama
    $cek = mysqli_query($koneksi, "SELECT foto FROM penerima WHERE id_penerima='$id'");
    $data = mysqli_fetch_assoc($cek);
    $foto_lama = $data['foto'];

    // Cek upload foto baru
    if (!empty($_FILES['foto']['name'])) {
        $nama_foto = time() . '_' . $_FILES['foto']['name'];
        $tmp = $_FILES['foto']['tmp_name'];
        $folder = "../uploads/";

        // Hapus foto lama
        if (!empty($foto_lama) && file_exists($folder . $foto_lama)) {
            unlink($folder . $foto_lama);
        }

        move_uploaded_file($tmp, $folder . $nama_foto);
        $foto = $nama_foto;
    } else {
        $foto = $foto_lama;
    }

    // Update data penerima
    $update = mysqli_query($koneksi, "UPDATE penerima SET 
        nisp='$nisp',
        nama_penerima='$nama',
        status='$status',
        kelas='$kelas',
        tanggal_lahir='$tanggal',
        alamat='$alamat',
        pendapatanorangtua='$pendapatan',
        foto='$foto'
        WHERE id_penerima='$id'
    ");

    if ($update) {
        header("Location: ../views/penerima/penerima.php?pesan=berhasil_edit");
        exit();
    } else {
        echo "Gagal memperbarui data: " . mysqli_error($koneksi);
        exit();
    }
}



// =============================================================
// 3️⃣ PROSES HAPUS DATA PENERIMA
// =============================================================
elseif ($proses == 'hapus') {

    $id = isset($_GET['id_penerima']) ? intval($_GET['id_penerima']) : 0;

    // Ambil nama file foto
    $result = mysqli_query($koneksi, "SELECT foto FROM penerima WHERE id_penerima='$id'");
    $data = mysqli_fetch_assoc($result);

    // Hapus foto fisik di folder uploads
    if (!empty($data['foto']) && file_exists("../uploads/" . $data['foto'])) {
        unlink("../uploads/" . $data['foto']);
    }

    // Hapus semua transaksi terkait (jika ada foreign key)
    mysqli_query($koneksi, "DELETE FROM transaksi WHERE id_penerima='$id'");

    // Hapus data penerima
    $hapus = mysqli_query($koneksi, "DELETE FROM penerima WHERE id_penerima='$id'");

    if ($hapus) {
        header("Location: ../views/penerima/penerima.php?pesan=berhasil_hapus");
        exit();
    } else {
        echo "Gagal menghapus data: " . mysqli_error($koneksi);
        exit();
    }
}



// =============================================================
// 4️⃣ DEFAULT REDIRECT
// =============================================================
else {
    header("Location: ../views/penerima/penerima.php");
    exit();
}

?>

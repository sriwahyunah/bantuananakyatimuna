<?php
// ============================================================
// FILE: db/dbpenerima.php
// Fungsi: Mengelola proses tambah, edit, hapus data penerima
// ============================================================

include "../koneksi.php";
session_start();

// ------------------------------------------------------------
// CEK KONEKSI
// ------------------------------------------------------------
if (mysqli_connect_errno()) {
    echo "Gagal terhubung ke MySQL: " . mysqli_connect_error();
    exit();
}

// ------------------------------------------------------------
// TENTUKAN PROSES (tambah, edit, hapus)
// ------------------------------------------------------------
$proses = isset($_GET['proses']) ? $_GET['proses'] : '';


// ====================================================================
// 🟢 PROSES TAMBAH DATA
// ====================================================================
if ($proses == 'tambah') {

    // Sanitasi input
    $nisp        = mysqli_real_escape_string($koneksi, $_POST['nisp']);
    $nama        = mysqli_real_escape_string($koneksi, $_POST['nama_penerima']);
    $status      = mysqli_real_escape_string($koneksi, $_POST['status']);
    $kelas       = mysqli_real_escape_string($koneksi, $_POST['kelas']);
    $tanggal     = mysqli_real_escape_string($koneksi, $_POST['tanggal_lahir']);
    $alamat      = mysqli_real_escape_string($koneksi, $_POST['alamat']);
    $pendapatan  = mysqli_real_escape_string($koneksi, $_POST['pendapatanorangtua']);
    $foto        = '';

    // Upload foto jika ada
    if (!empty($_FILES['foto']['name'])) {
        $folder = "../uploads/";
        if (!file_exists($folder)) mkdir($folder, 0777, true);
        $foto = time() . "_" . basename($_FILES['foto']['name']);
        move_uploaded_file($_FILES['foto']['tmp_name'], $folder . $foto);
    }

    // Simpan ke database
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



// ====================================================================
// ✏️ PROSES EDIT / UPDATE DATA
// ====================================================================
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


    // Proses upload foto baru
    if (!empty($_FILES['foto']['name'])) {
        $folder = "../uploads/";
        if (!file_exists($folder)) mkdir($folder, 0777, true);

        // Hapus foto lama jika ada
        if (!empty($foto_lama) && file_exists($folder . $foto_lama)) {
            unlink($folder . $foto_lama);
        }

        $foto_baru = time() . "_" . basename($_FILES['foto']['name']);
        move_uploaded_file($_FILES['foto']['tmp_name'], $folder . $foto_baru);
        $foto = $foto_baru;
    } else {
        $foto = $foto_lama;
    }

    // Query update
    $query = "UPDATE penerima SET 
                nisp='$nisp',
                nama_penerima='$nama',
                status='$status',
                kelas='$kelas',
                tanggal_lahir='$tanggal',
                alamat='$alamat',
                pendapatanorangtua='$pendapatan',
                foto='$foto'
              WHERE id_penerima='$id'";

    if (mysqli_query($koneksi, $query)) {
        header("Location: ../views/penerima/penerima.php?pesan=berhasiledit");
        exit();
    } else {
        echo "Gagal memperbarui data: " . mysqli_error($koneksi);
        exit();
    }
}



// ====================================================================
// 🔴 PROSES HAPUS DATA
elseif ($proses == 'hapus') {
    $id = $_GET['id_penerima'];

    // Ambil foto lama
    $data = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT foto FROM penerima WHERE id_penerima='$id'"));
    if (!empty($data['foto']) && file_exists("../uploads/" . $data['foto'])) {
        unlink("../uploads/" . $data['foto']);
    }

    // Hapus data
    $hapus = mysqli_query($koneksi, "DELETE FROM penerima WHERE id_penerima='$id'");

    if ($hapus) {
        header("Location: ../index.php?halaman=penerima&pesan=berhasil_hapus");
        exit();
    } else {
        echo "Gagal menghapus data: " . mysqli_error($koneksi);
        exit();
    }
}



// ====================================================================
// 🚫 TIDAK ADA PROSES
// ====================================================================
else {
    echo "<div style='color:red; font-weight:bold;'>❌ Proses tidak dikenal.</div>";
    exit();
}

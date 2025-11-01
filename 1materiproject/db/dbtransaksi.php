<?php
include "../koneksi.php";

$proses = $_GET['proses'];

if ($proses == "tambah") {
    $id_admin = $_POST['id_admin'];
    $id_penerima = $_POST['id_penerima'];
    $kelas = $_POST['kelas'];
    $status = $_POST['status'];
    $tanggal_bantuan_keluar = $_POST['tanggal_bantuan_keluar'];
    $tanggal_pengambilan_bantuan = $_POST['tanggal_pengambilan_bantuan'];

    // Upload foto struk
    $foto_bukti = $_FILES['foto_bukti']['name'];
    $tmp = $_FILES['foto_bukti']['tmp_name'];

    if ($foto_bukti != "") {
        $path = "../uploads/" . $foto_bukti;
        move_uploaded_file($tmp, $path);
    } else {
        $foto_bukti = "";
    }

    $query = mysqli_query($koneksi, "INSERT INTO transaksi (
                id_admin, 
                id_penerima, 
                kelas, 
                status, 
                tanggal_bantuan_keluar, 
                tanggal_pengambilan_bantuan, 
                foto_bukti
            ) VALUES (
                '$id_admin', 
                '$id_penerima', 
                '$kelas', 
                '$status', 
                '$tanggal_bantuan_keluar', 
                '$tanggal_pengambilan_bantuan', 
                '$foto_bukti'
            )");

    if ($query) {
        echo "<script>alert('Transaksi berhasil ditambahkan');window.location='../index.php?halaman=transaksi';</script>";
    } else {
        echo "<script>alert('Gagal menambah transaksi!');window.history.back();</script>";
    }
}

elseif ($proses == "edit") {
    $id_transaksi = $_POST['id_transaksi'];
    $id_admin = $_POST['id_admin'];
    $id_penerima = $_POST['id_penerima'];
    $kelas = $_POST['kelas'];
    $status = $_POST['status'];
    $tanggal_bantuan_keluar = $_POST['tanggal_bantuan_keluar'];
    $tanggal_pengambilan_bantuan = $_POST['tanggal_pengambilan_bantuan'];

    // Ambil data lama
    $qLama = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT * FROM transaksi WHERE id_transaksi='$id_transaksi'"));
    $fotoLama = $qLama['foto_bukti'];

    // Cek jika ada file baru diupload
    $foto_bukti = $_FILES['foto_bukti']['name'];
    $tmp = $_FILES['foto_bukti']['tmp_name'];

    if ($foto_bukti != "") {
        $path = "../uploads/" . $foto_bukti;
        move_uploaded_file($tmp, $path);
    } else {
        $foto_bukti = $fotoLama; // tetap pakai yang lama
    }

    $query = mysqli_query($koneksi, "UPDATE transaksi SET 
                id_admin='$id_admin',
                id_penerima='$id_penerima',
                kelas='$kelas',
                status='$status',
                tanggal_bantuan_keluar='$tanggal_bantuan_keluar',
                tanggal_pengambilan_bantuan='$tanggal_pengambilan_bantuan',
                foto_bukti='$foto_bukti'
                WHERE id_transaksi='$id_transaksi'");

    if ($query) {
        echo "<script>alert('Transaksi berhasil diedit');window.location='../index.php?halaman=transaksi';</script>";
    } else {
        echo "<script>alert('Gagal mengedit transaksi!');window.history.back();</script>";
    }
}

elseif ($proses == "hapus") {
    $id = $_GET['id_transaksi'];

    // Hapus foto juga dari folder
    $data = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT foto_bukti FROM transaksi WHERE id_transaksi='$id'"));
    if (!empty($data['foto_bukti']) && file_exists("../uploads/" . $data['foto_bukti'])) {
        unlink("../uploads/" . $data['foto_bukti']);
    }

    $query = mysqli_query($koneksi, "DELETE FROM transaksi WHERE id_transaksi='$id'");

    if ($query) {
        echo "<script>alert('Transaksi berhasil dihapus');window.location='../index.php?halaman=transaksi';</script>";
    } else {
        echo "<script>alert('Gagal menghapus transaksi!');window.history.back();</script>";
    }
}
?>

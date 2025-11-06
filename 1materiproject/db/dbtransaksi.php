<?php
include "../koneksi.php";
session_start();

$proses = isset($_GET['proses']) ? $_GET['proses'] : '';

/* =====================================================
   🟩 TAMBAH DATA TRANSAKSI
===================================================== */
if ($proses == 'tambah') {

    $id_admin  = $_POST['id_admin'];
    $id_penerima = $_POST['id_penerima'];
    $kelas = $_POST['kelas'];
    $status = $_POST['status'];
    $tanggal_bantuan_keluar = $_POST['tanggal_bantuan_keluar'];
    $tanggal_pengambilan_bantuan = $_POST['tanggal_pengambilan_bantuan'];

    // Upload foto struk
    $fotobuktistruk = "";
    if (!empty($_FILES['fotobuktistruk']['name'])) {
        $foto_name = time() . "_" . $_FILES['fotobuktistruk']['name'];
        $target = "../uploads/" . $foto_name;
        move_uploaded_file($_FILES['fotobuktistruk']['tmp_name'], $target);
        $fotobuktistruk = $foto_name;
    }

    $query = "INSERT INTO transaksi (id_admin, id_penerima, kelas, status, tanggal_bantuan_keluar, tanggal_pengambilan_bantuan, fotobuktistruk)
              VALUES ('$id_admin', '$id_penerima', '$kelas', '$status', '$tanggal_bantuan_keluar', '$tanggal_pengambilan_bantuan', '$fotobuktistruk')";
    mysqli_query($koneksi, $query);

    echo "<script>alert('Data transaksi berhasil ditambahkan');window.location='../views/transaksi/transaksi.php';</script>";
}




$proses = isset($_GET['proses']) ? $_GET['proses'] : '';

if ($proses == 'edit') {
    $id_transaksi = $_POST['id_transaksi'];
    $id_admin = $_POST['id_admin'];
    $id_penerima = $_POST['id_penerima'];
    $kelas = $_POST['kelas'];
    $status = $_POST['status'];
    $tanggal_bantuan_keluar = $_POST['tanggal_bantuan_keluar'];
    $tanggal_pengambilan_bantuan = $_POST['tanggal_pengambilan_bantuan'];

    $data_lama = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT fotobuktistruk FROM transaksi WHERE id_transaksi='$id_transaksi'"));
    $fotobuktistruk_lama = $data_lama['fotobuktistruk'];

    if (!empty($_FILES['fotobuktistruk']['name'])) {
        $foto_name = time() . "_" . basename($_FILES['fotobuktistruk']['name']);
        $target_dir = "../uploads/";
        $target_file = $target_dir . $foto_name;

        if (move_uploaded_file($_FILES['fotobuktistruk']['tmp_name'], $target_file)) {
            if (!empty($fotobuktistruk_lama) && file_exists($target_dir . $fotobuktistruk_lama)) {
                unlink($target_dir . $fotobuktistruk_lama);
            }
            $fotobuktistruk = $foto_name;
        } else {
            $fotobuktistruk = $fotobuktistruk_lama;
        }
    } else {
        $fotobuktistruk = $fotobuktistruk_lama;
    }

    $query = "UPDATE transaksi SET 
                id_admin='$id_admin',
                id_penerima='$id_penerima',
                kelas='$kelas',
                status='$status',
                tanggal_bantuan_keluar='$tanggal_bantuan_keluar',
                tanggal_pengambilan_bantuan='$tanggal_pengambilan_bantuan',
                fotobuktistruk='$fotobuktistruk'
              WHERE id_transaksi='$id_transaksi'";

    if (mysqli_query($koneksi, $query)) {
        echo "<script>alert('✅ Data transaksi berhasil diperbarui!');window.location='../index.php?halaman=transaksi';</script>";
    } else {
        echo "<script>alert('❌ Gagal memperbarui data transaksi!');window.history.back();</script>";
    }
}

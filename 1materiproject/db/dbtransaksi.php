<?php
include "../koneksi.php";

$proses = $_GET['proses'];

if ($proses == "tambah") {
    $tanggal = $_POST['tanggal_transaksi'];
    $id_admin = $_POST['id_admin'];
    $id_penerima = $_POST['id_penerima'];

    $query = mysqli_query($koneksi, "INSERT INTO transaksi (tanggal_transaksi, id_admin, id_penerima) 
                                     VALUES ('$tanggal', '$id_admin', '$id_penerima')");
    if ($query) {
        header("Location: ../index.php?halaman=transaksi");
    } else {
        echo "Gagal menambah transaksi!";
    }
}

elseif ($proses == "edit") {
    $id = $_POST['id_transaksi'];
    $tanggal = $_POST['tanggal_transaksi'];
    $id_admin = $_POST['id_admin'];
    $id_penerima = $_POST['id_penerima'];

    $query = mysqli_query($koneksi, "UPDATE transaksi SET 
                tanggal_transaksi='$tanggal', 
                id_admin='$id_admin', 
                id_penerima='$id_penerima'
                WHERE id_transaksi='$id'");

    if ($query) {
        header("Location: ../index.php?halaman=transaksi");
    } else {
        echo "Gagal mengedit transaksi!";
    }
}

elseif ($proses == "hapus") {
    $id = $_GET['id_transaksi'];
    $query = mysqli_query($koneksi, "DELETE FROM transaksi WHERE id_transaksi='$id'");

    if ($query) {
        header("Location: ../index.php?halaman=transaksi");
    } else {
        echo "Gagal menghapus transaksi!";
    }
}
?>

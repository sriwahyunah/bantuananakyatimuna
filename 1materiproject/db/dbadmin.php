<?php
// Pastikan koneksi ke database di-include
include "../koneksi.php";

if (!$koneksi) {
    die("Koneksi database gagal: " . mysqli_connect_error());
}

// Pastikan parameter GET dan POST ada
$proses = isset($_GET['proses']) ? $_GET['proses'] : '';

if ($proses == 'tambah') {
    $username = $_POST['username'];
    $nama_admin = $_POST['nama_admin'];
    $password = $_POST['password'];
    $password_final = password_hash($password, PASSWORD_DEFAULT);

    $query = "INSERT INTO admin (username, nama_admin, password) 
              VALUES ('$username', '$nama_admin', '$password_final')";
    $result = mysqli_query($koneksi, $query);

    if ($result) {
        header("Location: ../index.php?halaman=admin&pesan=sukses_tambah");
    } else {
        echo "Gagal menambahkan admin: " . mysqli_error($koneksi);
    }
} elseif ($proses == 'edit') {
    $id_admin = $_POST['id_admin'];
    $username = $_POST['username'];
    $nama_admin = $_POST['nama_admin'];
    $password = $_POST['password'];

    // Cek apakah password diubah
    if (!empty($password)) {
        $password_final = password_hash($password, PASSWORD_DEFAULT);
        $query = "UPDATE admin SET 
                    username='$username',
                    nama_admin='$nama_admin',
                    password='$password_final'
                  WHERE id_admin='$id_admin'";
    } else {
        $query = "UPDATE admin SET 
                    username='$username',
                    nama_admin='$nama_admin'
                  WHERE id_admin='$id_admin'";
    }

    $result = mysqli_query($koneksi, $query);

    if ($result) {
        header("Location: ../index.php?halaman=admin&pesan=sukses_edit");
    } else {
        echo "Gagal mengedit admin: " . mysqli_error($koneksi);
    }
} elseif ($proses == 'hapus') {
    $id_admin = $_GET['id_admin'];

    $query = "DELETE FROM admin WHERE id_admin='$id_admin'";
    $result = mysqli_query($koneksi, $query);

    if ($result) {
        header("Location: ../index.php?halaman=admin&pesan=sukses_hapus");
    } else {
        echo "Gagal menghapus admin: " . mysqli_error($koneksi);
    }
} else {
    echo "Proses tidak dikenali.";
}

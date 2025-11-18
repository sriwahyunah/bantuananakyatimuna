<?php
$proses = isset($_GET['proses']) ? $_GET['proses'] : '';
include "../koneksi.php";
session_start();

$targetDir = "../views/admin/fotoadmin/";
if (!is_dir($targetDir)) mkdir($targetDir, 0755, true);

if ($proses == 'tambah') {

    $nama_admin = $_POST['nama_admin'];
    $username   = $_POST['username'];
    $password   = md5($_POST['password']); // model lama

    // Upload foto
    $foto       = $_FILES['foto']['name'];
    $tmp_foto   = $_FILES['foto']['tmp_name'];

    if (!empty($foto)) {
        $namafilebaru = date('YmdHis') . '_' . $foto;
        move_uploaded_file($tmp_foto, $targetDir . $namafilebaru);
    } else {
        $namafilebaru = '';
    }

    mysqli_query($koneksi, "INSERT INTO admin (nama_admin, username, password, foto)
                            VALUES ('$nama_admin', '$username', '$password', '$namafilebaru')");
} elseif ($proses == 'edit') {

    $id_admin   = $_POST['id_admin'];
    $nama_admin = $_POST['nama_admin'];
    $username   = $_POST['username'];
    $password   = $_POST['password']; // opsional

    // Foto
    $foto       = $_FILES['foto']['name'];
    $tmp_foto   = $_FILES['foto']['tmp_name'];

    // Ambil data lama
    $old = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT * FROM admin WHERE id_admin='$id_admin'"));

    // Proses upload foto
    if (!empty($foto)) {

        // hapus foto lama
        if (!empty($old['foto']) && file_exists($targetDir . $old['foto'])) {
            unlink($targetDir . $old['foto']);
        }

        $namafilebaru = date('YmdHis') . '_' . $foto;
        move_uploaded_file($tmp_foto, $targetDir . $namafilebaru);
    } else {
        $namafilebaru = $old['foto'];
    }

    // Jika password tidak kosong → update password
    if (!empty($password)) {

        $password_md5 = md5($password);

        mysqli_query($koneksi, "UPDATE admin SET
                                nama_admin='$nama_admin',
                                username='$username',
                                password='$password_md5',
                                foto='$namafilebaru'
                                WHERE id_admin='$id_admin'");
    } else {

        // Password tetap
        mysqli_query($koneksi, "UPDATE admin SET
                                nama_admin='$nama_admin',
                                username='$username',
                                foto='$namafilebaru'
                                WHERE id_admin='$id_admin'");
    }
} elseif ($proses == 'hapus') {

    $id_admin = $_GET['id_admin'];

    // Ambil foto lama
    $old = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT foto FROM admin WHERE id_admin='$id_admin'"));

    // Hapus foto
    if (!empty($old['foto']) && file_exists($targetDir . $old['foto'])) {
        unlink($targetDir . $old['foto']);
    }

    mysqli_query($koneksi, "DELETE FROM admin WHERE id_admin='$id_admin'");
}

// kembali
header("Location: ../index.php?halaman=admin");
exit;
?>
x
<?php
// Pastikan koneksi ke database di-include
include "../koneksi.php";

if (!$koneksi) {
    die("Koneksi database gagal: " . mysqli_connect_error());
}

$proses = isset($_GET['proses']) ? $_GET['proses'] : '';

if ($proses == 'tambah') {
    $namaadmin = $_POST['namaadmin'];
    $username  = $_POST['username'];
    $password  = $_POST['password'];

    $foto_name = "";
    if (!empty($_FILES['foto']['name'])) {
        $foto_name = time() . "_" . $_FILES['foto']['name'];
        move_uploaded_file($_FILES['foto']['tmp_name'], "../uploads/" . $foto_name);
    }

    $query = "INSERT INTO admin (namaadmin, username, password, foto)
              VALUES ('$namaadmin', '$username', '$password', '$foto_name')";

    if (mysqli_query($koneksi, $query)) {
        header("Location: ../index.php?halaman=tambahadmin&status=sukses");
    } else {
        header("Location: ../index.php?halaman=tambahadmin&status=gagal");
    }
    exit;
} 
elseif ($proses == 'edit') {
    $id_admin = $_POST['id_admin'];
    $username = $_POST['username'];
    $nama_admin = $_POST['nama_admin'];
    $password = $_POST['password'];
    $fotoLama = $_POST['fotoLama'] ?? ''; // pastikan tidak error jika tidak ada

    // Folder upload foto
    $folder = "../foto/";
    if (!is_dir($folder)) {
        mkdir($folder, 0777, true); // buat folder otomatis jika belum ada
    }

    $fotoBaru = $_FILES['foto']['name'];
    $tmp = $_FILES['foto']['tmp_name'];
    $fotoQuery = "";

    // Jika ada upload foto baru
    if (!empty($fotoBaru)) {
        $ext = strtolower(pathinfo($fotoBaru, PATHINFO_EXTENSION));
        $allowed = ['jpg', 'jpeg', 'png'];

        if (in_array($ext, $allowed)) {
            // Beri nama unik agar tidak bentrok
            $namaFileBaru = time() . "_" . preg_replace("/[^a-zA-Z0-9_\-\.]/", "", $fotoBaru);
            $pathFile = $folder . $namaFileBaru;

            if (move_uploaded_file($tmp, $pathFile)) {
                // Hapus foto lama jika ada dan tidak default
                if (!empty($fotoLama) && file_exists($folder . $fotoLama)) {
                    unlink($folder . $fotoLama);
                }
                $fotoQuery = ", foto='$namaFileBaru'";
            } else {
                header("Location: ../index.php?halaman=editadmin&id_admin=$id_admin&pesan=gagalupload");
                exit;
            }
        } else {
            header("Location: ../index.php?halaman=editadmin&id_admin=$id_admin&pesan=gagalupload");
            exit;
        }
    }

    // Jika password diubah
    if (!empty($password)) {
        $password_final = password_hash($password, PASSWORD_DEFAULT);
        $query = "UPDATE admin SET 
                    username='$username',
                    nama_admin='$nama_admin',
                    password='$password_final' 
                    $fotoQuery
                  WHERE id_admin='$id_admin'";
    } else {
        $query = "UPDATE admin SET 
                    username='$username',
                    nama_admin='$nama_admin'
                    $fotoQuery
                  WHERE id_admin='$id_admin'";
    }

    $result = mysqli_query($koneksi, $query);

    if ($result) {
        header("Location: ../index.php?halaman=admin&pesan=sukses_edit");
    } else {
        echo "Gagal mengedit admin: " . mysqli_error($koneksi);
    }
}

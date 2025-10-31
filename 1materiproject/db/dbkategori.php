<?php
// db/dbkategori.php - File Pemroses Data Kategori

// Ambil parameter proses dari URL
$proses = $_GET['proses'];

// Include file koneksi.php (Asumsi berada satu level di atas folder db/)
include "../koneksi.php";

// Mulai session (diperlukan jika Anda ingin mengaktifkan kembali blok login/session)
session_start();

// Blok yang di-comment out terkait login dapat diaktifkan kembali jika diperlukan
// include "../library/liblogin.php";
// if (ceklogin()) {

if ($proses == 'tambah') {
    // Ambil dan bersihkan data input
    // Asumsi: Form menggunakan input name="nama_kategori"
    $nama_kategori = mysqli_real_escape_string($koneksi, $_POST['nama_kategori']);

    $sql = "INSERT INTO kategori (nama_kategori) 
            VALUES ('$nama_kategori')";

    if (mysqli_query($koneksi, $sql)) {
        // Berhasil
        header("location:../index.php?halaman=kategori&pesan=tambahberhasil");
    } else {
        // Gagal
        header("location:../index.php?halaman=tambahkategori&pesan=gagal&error=" . mysqli_error($koneksi));
    }
    
} elseif ($proses == 'edit') {
    // Ambil dan bersihkan data input
    $nama_kategori = mysqli_real_escape_string($koneksi, $_POST['nama_kategori']);
    // Asumsi: Form menggunakan input hidden name="id_kategori"
    $id_kategori   = mysqli_real_escape_string($koneksi, $_POST['id_kategori']);

    $sql = "UPDATE kategori SET 
                nama_kategori='$nama_kategori' 
            WHERE id_kategori='$id_kategori'";

    if (mysqli_query($koneksi, $sql)) {
        // Berhasil
        header("location:../index.php?halaman=kategori&pesan=editberhasil");
    } else {
        // Gagal
        header("location:../index.php?halaman=editkategori&id_kategori=$id_kategori&pesan=gagal&error=" . mysqli_error($koneksi));
    }

} elseif ($proses == 'hapus') {
    // Ambil ID dari URL GET
    // Asumsi: Link hapus menggunakan id_kategori
    $id_kategori = mysqli_real_escape_string($koneksi, $_GET['id_kategori']);
    
    // Perhatian! Jika kategori memiliki relasi ke tabel 'bantuan', 
    // penghapusan langsung (DELETE) akan menyebabkan Foreign Key Error.
    // Jika itu terjadi, Anda harus menghapus data di tabel 'bantuan' yang terkait dulu,
    // atau menggunakan Soft Delete jika tabel kategori Anda memilikinya.

    $sql = "DELETE FROM kategori WHERE id_kategori='$id_kategori'";
    
    if (mysqli_query($koneksi, $sql)) {
        // Berhasil
        header("location:../index.php?halaman=kategori&pesan=hapusberhasil");
    } else {
        // Gagal (kemungkinan Foreign Key Constraint)
        header("location:../index.php?halaman=kategori&pesan=gagalhapus&error=" . mysqli_error($koneksi));
    }
}

// Redirect default jika tidak ada proses yang dieksekusi
header("location:../index.php?halaman=kategori");
// } else {
//     header("location: ../login.php");
// }
exit();
?>
<?php
$koneksi = mysqli_connect("localhost", "root", "", "bantuananakyatimuna");

if (!$koneksi) {
    die("Koneksi gagal: " . mysqli_connect_error());
}
?>

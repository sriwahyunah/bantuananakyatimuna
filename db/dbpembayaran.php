<?php
// =================================================================
// KONFIGURASI DATABASE
// GANTI NILAI DI BAWAH INI DENGAN KREDENSIAL DATABASE ANDA
// =================================================================
$host = "localhost"; // Host database Anda
$user = "root"; // Username database Anda
$pass = ""; // Password database Anda
$db_name = "bantuananakyatimuna"; // Nama database Anda
$table_name = "pembayaran"; // Nama tabel

// Membuat koneksi ke database
$conn = new mysqli($host, $user, $pass, $db_name);

// Cek koneksi
if ($conn->connect_error) {
    // Hentikan eksekusi script dan tampilkan error
    die("Koneksi gagal: " . $conn->connect_error);
}
?>
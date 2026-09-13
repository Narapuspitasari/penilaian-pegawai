<?php
session_start();
include 'auth.php';
include 'koneksi.php';

if (isset($_GET['id'])) {
    $id = $_GET['id'];

    // Hapus dari tabel penilaian terlebih dahulu jika ada relasi
    mysqli_query($conn, "DELETE FROM penilaian WHERE pegawai_id = $id");

    // Hapus pegawai
    mysqli_query($conn, "DELETE FROM pegawai WHERE id = $id");

    header('Location: dashboard.php');
    exit();
} else {
    echo "ID tidak ditemukan!";
}
?>

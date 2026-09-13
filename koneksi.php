<?php
$conn = mysqli_connect("localhost", "root", "", "db_penilaian");
if (!$conn) {
    die("Koneksi gagal: " . mysqli_connect_error());
}
?>

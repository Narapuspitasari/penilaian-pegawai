<?php
require 'config.php';

header('Content-Type: text/csv');
header('Content-Disposition: attachment; filename="penilaian.csv"');

$output = fopen("php://output", "w");

// Header
fputcsv($output, ['Nama', 'Teamwork', 'Disiplin', 'Tanggung Jawab', 'Produktivitas', 'Nilai Akhir', 'Kategori']);

$query = "SELECT pegawai.nama, penilaian.* FROM penilaian 
          JOIN pegawai ON penilaian.pegawai_id = pegawai.id";
$result = $conn->query($query);

// Isi
while ($row = $result->fetch_assoc()) {
    fputcsv($output, [
        $row['nama'],
        $row['teamwork'],
        $row['disiplin'],
        $row['tanggung_jawab'],
        $row['produktivitas'],
        $row['nilai_akhir'],
        $row['kategori']
    ]);
}

fclose($output);
exit();

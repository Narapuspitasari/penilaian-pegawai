<?php
require 'config.php';

header("Content-Type: application/vnd.ms-word");
header("Content-Disposition: attachment; filename=penilaian.doc");

$query = "SELECT pegawai.nama, penilaian.* FROM penilaian 
          JOIN pegawai ON penilaian.pegawai_id = pegawai.id";
$result = $conn->query($query);
?>

<html>
<head>
    <meta charset="UTF-8">
    <style>
        table, th, td { border:1px solid black; border-collapse: collapse; padding:8px; }
    </style>
</head>
<body>
    <h2>Data Penilaian Pegawai</h2>
    <table>
        <tr>
            <th>Nama</th>
            <th>Teamwork</th>
            <th>Disiplin</th>
            <th>Tanggung Jawab</th>
            <th>Produktivitas</th>
            <th>Nilai Akhir</th>
            <th>Kategori</th>
        </tr>
        <?php while ($row = $result->fetch_assoc()): ?>
        <tr>
            <td><?= $row['nama'] ?></td>
            <td><?= $row['teamwork'] ?></td>
            <td><?= $row['disiplin'] ?></td>
            <td><?= $row['tanggung_jawab'] ?></td>
            <td><?= $row['produktivitas'] ?></td>
            <td><?= $row['nilai_akhir'] ?></td>
            <td><?= $row['kategori'] ?></td>
        </tr>
        <?php endwhile; ?>
    </table>
</body>
</html>

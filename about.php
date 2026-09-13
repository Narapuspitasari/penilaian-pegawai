<?php
session_start();
if (!isset($_SESSION['admin_logged_in'])) {
  header('Location: index.php');
  exit();
}
?>

<!DOCTYPE html>
<html lang="id">

<head>
  <meta charset="UTF-8">
  <title>Tentang Aplikasi</title>
  <script src="https://cdn.tailwindcss.com"></script>
  <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;500;700&display=swap" rel="stylesheet">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">

  <style>
    body {
      font-family: 'Poppins', sans-serif;
      background: linear-gradient(to right top, #c9d6ff, #e2e2e2);
      min-height: 100vh;
      padding-left: 16rem;
      /* ruang untuk aside */
    }
  </style>
</head>

<body>

  <aside class="w-64 bg-white shadow-xl fixed top-0 left-0 h-screen flex flex-col justify-between z-50 p-6">
    <!-- Logo / Judul -->
    <div>
      <h2 class="text-2xl font-bold text-blue-600 mb-8 tracking-wide">🧾 Penilaian</h2>

      <!-- Menu Navigasi -->
      <nav class="space-y-2">
        <a href="dashboard.php"
          class="flex items-center px-4 py-2 rounded-lg text-gray-700 hover:bg-blue-100 hover:text-blue-600 transition">
          <i class="fas fa-home w-5"></i>
          <span class="ml-3">Dashboard</span>
        </a>

        <a href="tambah_pegawai.php"
          class="flex items-center px-4 py-2 rounded-lg text-gray-700 hover:bg-blue-100 hover:text-blue-600 transition">
          <i class="fas fa-user-plus w-5"></i>
          <span class="ml-3">Input Penilaian</span>
        </a>

        <a href="about.php"
          class="flex items-center px-4 py-2 rounded-lg text-gray-700 hover:bg-blue-100 hover:text-blue-600 transition">
          <i class="fas fa-info-circle w-5"></i>
          <span class="ml-3">About</span>
        </a>
      </nav>
    </div>

    <!-- Tombol Logout -->
    <div class="border-t pt-4">
      <a href="#" onclick="openModal()"
        class="flex items-center px-4 py-2 rounded-lg text-red-500 hover:bg-red-50 hover:text-red-600 transition">
        <i class="fas fa-sign-out-alt w-5"></i>
        <span class="ml-3">Logout</span>
      </a>
    </div>
  </aside>

  <!-- Konten Utama -->
  <main class="p-10 max-w-5xl mx-auto space-y-10">

    <!-- Tentang Aplikasi -->
    <div class="bg-white/30 backdrop-blur-lg p-8 rounded-xl shadow-lg border border-white/20 text-gray-800">
      <h1 class="text-3xl font-bold text-blue-700 mb-4">Tentang Aplikasi</h1>
      <p class="mb-4 text-gray-700 leading-relaxed">
        Aplikasi <strong>Penilaian Pegawai</strong> ini dirancang untuk membantu perusahaan dalam mengevaluasi kinerja pegawai secara efisien dan objektif.
      </p>
      <ul class="list-disc pl-6 text-gray-700 space-y-2">
        <li>Input dan pengolahan data penilaian pegawai</li>
        <li>Visualisasi grafik rata-rata indikator kinerja</li>
        <li>Identifikasi pegawai terbaik</li>
        <li>Export data ke Excel dan Word</li>
        <li>Antarmuka bergaya <strong>glassmorphism</strong></li>
      </ul>
      <p class="mt-6 text-sm text-gray-500">
        Dibuat oleh <strong>Tim Pengembang Teknik Informatika</strong><br>
        &copy; <?= date('Y') ?> - All rights reserved.
      </p>
    </div>

    <!-- Anggota Kelompok -->
    <div>
      <h2 class="text-2xl font-semibold text-gray-700 mb-6">Dibuat oleh Kelompok 3</h2>
      <div class="grid sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-5 gap-6">

        <!-- Card Anggota -->
        <?php
        $anggota = [
          ["foto" => "image.png", "nama" => "Nara Puspitasari", "job" => "Front-end Developer"],
          ["foto" => "img/sye.png", "nama" => "Shela Apriani M.", "job" => "UI/UX Designer"],
          ["foto" => "img/manda.png", "nama" => "Amanda Putri Z.", "job" => "Back-end Developer"],
          ["foto" => "img/lisa.png", "nama" => "Alissa", "job" => "Database Engineer"],
          ["foto" => "img/hans.png", "nama" => "Hans Sapan M", "job" => "Project Manager"],
        ];

        foreach ($anggota as $a):
        ?>
          <div class="bg-white/30 backdrop-blur-lg p-4 rounded-xl text-center shadow-md border border-white/10">
            <img src="<?= $a['foto'] ?>" alt="<?= $a['nama'] ?>" class="w-24 h-24 object-cover rounded-full mx-auto mb-3 border-2 border-white shadow">
            <h3 class="text-lg font-semibold text-gray-800"><?= $a['nama'] ?></h3>
            <p class="text-sm text-gray-600"><?= $a['job'] ?></p>
          </div>
        <?php endforeach; ?>
      </div>
    </div>

  </main>

</body>

</html>
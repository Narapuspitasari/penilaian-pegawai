<?php
include 'config.php';
include 'fuzzy_tsukamoto.php';
session_start();
if (!isset($_SESSION['admin_logged_in'])) {
    header('Location: index.php');
    exit();
}

$query = "SELECT pegawai.*, penilaian.* FROM pegawai JOIN penilaian ON pegawai.id = penilaian.pegawai_id";
$result = $conn->query($query);

$totalPegawai = $conn->query("SELECT COUNT(*) as total FROM pegawai")->fetch_assoc()['total'];
$rataNilai = $conn->query("SELECT AVG(nilai_akhir) as rata FROM penilaian")->fetch_assoc()['rata'];
$baik = $conn->query("SELECT COUNT(*) as jml FROM penilaian WHERE kategori='Sangat Baik'")->fetch_assoc()['jml'];
$top = $conn->query("SELECT p.nama, pn.nilai_akhir FROM penilaian pn JOIN pegawai p ON p.id = pn.pegawai_id ORDER BY pn.nilai_akhir DESC LIMIT 1")->fetch_assoc();
?>
<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <title>Dashboard Penilaian Pegawai</title>
  <script src="https://cdn.tailwindcss.com"></script>
  <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
  <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;600&display=swap" rel="stylesheet">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">

  <style>
    body {
      font-family: 'Poppins', sans-serif;
      background: #f7f9fc;
    }
  </style>
</head>

<body class="ml-64 p-6">
  <!-- Sidebar -->
  <aside class="w-64 bg-white shadow-xl fixed top-0 left-0 h-screen flex flex-col justify-between z-50 p-6">
  <!-- Logo / Judul -->
  <div>
    <h2 class="text-2xl font-bold text-blue-600 mb-8 tracking-wide">🧾 Penilaian</h2>

    <!-- Menu Navigasi -->
    <nav class="space-y-2">
      <a href="#"
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



  <!-- Main -->
  <main class="flex-1 p-8">
   <header class="flex flex-wrap justify-between items-center bg-white shadow-md p-4 rounded-lg mb-6">
  <!-- Kiri: Logo dan Sapaan -->
  <div class="flex items-center gap-4">
    <img src="image.png" alt="Logo" class="h-10 w-10 object-contain rounded-full">
    <div>
      <h1 class="text-lg sm:text-2xl font-semibold text-gray-800">Selamat Datang, Admin!</h1>
      <p class="text-sm text-gray-500">Welcome back 👋</p>
    </div>
  </div>

  <!-- Kanan: Modern Search Bar -->
  <form class="relative mt-4 sm:mt-0 w-full sm:w-auto">
    <input 
      type="text" 
      placeholder="Cari sesuatu..." 
      class="pl-10 pr-4 py-2 rounded-full bg-gray-100 text-sm text-gray-700 focus:outline-none focus:ring-2 focus:ring-blue-400 border border-gray-300 w-full sm:w-64 transition"
    >
    <!-- Icon search -->
    <svg class="absolute left-3 top-1/2 transform -translate-y-1/2 text-gray-500 w-5 h-5" fill="none" stroke="currentColor" stroke-width="2"
         viewBox="0 0 24 24" stroke-linecap="round" stroke-linejoin="round">
      <circle cx="11" cy="11" r="8" />
      <line x1="21" y1="21" x2="16.65" y2="16.65" />
    </svg>
  </form>
</header>



    <!-- Cards -->
    <section class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6 mb-6">
      <div class="bg-blue-100 p-4 rounded-lg shadow">
        <p class="text-sm text-gray-600">Total Pegawai</p>
        <p class="text-2xl font-bold text-blue-800"><?= $totalPegawai ?></p>
      </div>
      <div class="bg-green-100 p-4 rounded-lg shadow">
        <p class="text-sm text-gray-600">Rata-rata Nilai</p>
        <p class="text-2xl font-bold text-green-800"><?= number_format($rataNilai, 2) ?></p>
      </div>
      <div class="bg-pink-100 p-4 rounded-lg shadow">
        <p class="text-sm text-gray-600">Sangat Baik</p>
        <p class="text-2xl font-bold text-pink-800"><?= $baik ?></p>
      </div>
      <div class="bg-purple-100 p-4 rounded-lg shadow">
        <p class="text-sm text-gray-600">Tanggal</p>
        <p class="text-xl font-bold text-purple-800"><?= date('d M Y') ?></p>
      </div>
    </section>

    <!-- Chart + Pegawai Terbaik -->
    <section class="grid lg:grid-cols-3 gap-6 mb-6">
      <div class="bg-white p-4 rounded-lg shadow col-span-2 h-64">
  <h2 class="text-lg font-semibold text-gray-700 mb-4">Grafik Rata-rata Indikator</h2>
  <canvas id="chartPerformance" class="w-full h-full"></canvas>
</div>

      <div class="bg-white p-4 rounded-lg shadow flex flex-col justify-center text-center h-64">
  <img src="cup.png" class="mx-auto h-20 mb-2" alt="Piala">
  <p class="text-sm text-gray-600">Pegawai Terbaik Bulan Ini</p>
  <p class="text-lg font-bold text-yellow-600"><?= $top['nama'] ?> (<?= number_format($top['nilai_akhir'], 2) ?>)</p>
</div>

    </section>

    <!-- Tabel Penilaian -->
    <section class="bg-white p-6 rounded-lg shadow">
      <h2 class="text-lg font-semibold text-gray-700 mb-4">Tabel Penilaian Pegawai</h2>
      <div class="overflow-auto">
        <table class="min-w-full text-sm text-left">
          <thead class="bg-gray-100">
            <tr>
              <th class="px-4 py-2">Nama</th>
              <th class="px-4 py-2">Teamwork</th>
              <th class="px-4 py-2">Disiplin</th>
              <th class="px-4 py-2">Tanggung Jawab</th>
              <th class="px-4 py-2">Produktivitas</th>
              <th class="px-4 py-2">Nilai Akhir</th>
              <th class="px-4 py-2">Progress</th>
              <th class="px-4 py-2">Kategori</th>
              <th class="px-4 py-2">Aksi</th>
            </tr>
          </thead>
          <tbody>
            <?php while ($row = $result->fetch_assoc()): ?>
              <tr class="hover:bg-gray-50">
                <td class="px-4 py-2"><?= htmlspecialchars($row['nama']) ?></td>
                <td class="px-4 py-2"><?= $row['teamwork'] ?></td>
                <td class="px-4 py-2"><?= $row['disiplin'] ?></td>
                <td class="px-4 py-2"><?= $row['tanggung_jawab'] ?></td>
                <td class="px-4 py-2"><?= $row['produktivitas'] ?></td>
                <td class="px-4 py-2 font-semibold"><?= $row['nilai_akhir'] ?></td>
                <td class="px-4 py-2">
                  <div class="w-full bg-gray-200 rounded-full h-4">
                    <div class="h-4 rounded-full text-xs text-center text-white flex items-center justify-center <?php
                      $p = round($row['nilai_akhir']);
                      echo 'w-['.$p.'%] ';
                      echo $p >= 85 ? 'bg-green-500' : ($p >= 70 ? 'bg-yellow-500' : 'bg-red-500');
                    ?>" style="width:<?= $p ?>%">
                      <?= $p ?>%
                    </div>
                  </div>
                </td>
                <td class="px-4 py-2"><?= $row['kategori'] ?></td>
                <td class="px-4 py-2 space-x-1">
                  <a href="edit_nilai.php?id=<?= $row['pegawai_id'] ?>" class="text-blue-500 hover:underline">Edit</a>
                <a href="#" onclick="showDeleteModal(<?= $row['pegawai_id'] ?>)" class="text-red-500 hover:underline">Hapus</a>


                </td>
              </tr>
            <?php endwhile; ?>
          </tbody>
        </table>
      </div>

<div class="mt-6 flex justify-end gap-4">
    <a href="export_excel.php" 
       class="bg-green-500 hover:bg-green-600 text-white px-4 py-2 rounded shadow transition duration-200">
        📥 Export ke Excel
    </a>
    <a href="export_word.php" 
       class="bg-blue-500 hover:bg-blue-600 text-white px-4 py-2 rounded shadow transition duration-200">
        📄 Export ke Word
    </a>
</div>


    </section>
  </main>

  <script>
    const ctx = document.getElementById('chartPerformance');
    new Chart(ctx, {
      type: 'bar',
      data: {
        labels: ['Teamwork', 'Disiplin', 'Tanggung Jawab', 'Produktivitas'],
        datasets: [{
          label: 'Rata-rata',
          data: [
            <?= $conn->query("SELECT AVG(teamwork) as avg FROM penilaian")->fetch_assoc()['avg'] ?>,
            <?= $conn->query("SELECT AVG(disiplin) as avg FROM penilaian")->fetch_assoc()['avg'] ?>,
            <?= $conn->query("SELECT AVG(tanggung_jawab) as avg FROM penilaian")->fetch_assoc()['avg'] ?>,
            <?= $conn->query("SELECT AVG(produktivitas) as avg FROM penilaian")->fetch_assoc()['avg'] ?>
          ],
          backgroundColor: ['#3B82F6', '#10B981', '#F59E0B', '#EF4444'],
          borderRadius: 8
        }]
      },
      options: {
        maintainAspectRatio: false,
        responsive: true,
        scales: {
          y: {
            beginAtZero: true,
            ticks: { stepSize: 10 }
          }
        },
        plugins: {
          legend: { display: false }
        }
      }
    });
  </script>

  <!-- Logout Modal -->
<!-- Modal Logout -->
<div id="logoutModal" class="fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center z-50 hidden">
  <div id="modalBox" class="bg-white p-6 rounded-xl shadow-xl w-full max-w-sm transform scale-95 opacity-0 transition duration-300 ease-out">
    <div class="flex flex-col items-center text-center">
      <div class="text-red-500 mb-3">
        <!-- Heroicons Question Mark -->
        <svg xmlns="http://www.w3.org/2000/svg" class="h-12 w-12" fill="none" viewBox="0 0 24 24" stroke="currentColor">
          <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 10h.01M12 14v.01M12 10a4 4 0 11-8 0 4 4 0 018 0zm0 4h.01M12 18h.01" />
        </svg>
      </div>
      <h2 class="text-lg font-semibold text-gray-800 mb-1">Yakin ingin logout?</h2>
      <p class="text-sm text-gray-500 mb-4">Tindakan ini akan mengakhiri sesi Anda saat ini.</p>
      <div class="flex justify-center gap-4">
        <button onclick="closeModal()" class="px-4 py-2 bg-gray-200 text-gray-700 rounded hover:bg-gray-300 transition">Batal</button>
        <a href="logout.php" class="px-4 py-2 bg-red-500 text-white rounded hover:bg-red-600 transition">Logout</a>
      </div>
    </div>
  </div>
</div>


<script>
  function openModal() {
    const modal = document.getElementById('logoutModal');
    const box = document.getElementById('modalBox');
    modal.classList.remove('hidden');

    // Reset animasi
    setTimeout(() => {
      box.classList.remove('scale-95', 'opacity-0');
      box.classList.add('scale-100', 'opacity-100');
    }, 10);
  }

  function closeModal() {
    const modal = document.getElementById('logoutModal');
    const box = document.getElementById('modalBox');

    // Animasi keluar
    box.classList.remove('scale-100', 'opacity-100');
    box.classList.add('scale-95', 'opacity-0');

    setTimeout(() => {
      modal.classList.add('hidden');
    }, 300);
  }
</script>


<!-- Modal Konfirmasi Hapus -->
<div id="deleteModal" class="fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center z-50 hidden">
  <div id="deleteBox" class="bg-white p-6 rounded-xl shadow-xl w-full max-w-sm transform scale-95 opacity-0 transition duration-300 ease-out">
    <div class="flex flex-col items-center text-center">
      <!-- Icon Trash -->
      <div class="text-red-500 mb-3">
        <svg xmlns="http://www.w3.org/2000/svg" class="h-12 w-12" fill="none" viewBox="0 0 24 24" stroke="currentColor">
          <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7L5 7M6 7v12a2 2 0 002 2h8a2 2 0 002-2V7m-5 4v4m-4-4v4m1-10V4a1 1 0 011-1h2a1 1 0 011 1v2" />
        </svg>
      </div>
      <h2 class="text-lg font-semibold text-gray-800 mb-1">Yakin ingin menghapus?</h2>
      <p class="text-sm text-gray-500 mb-4">Tindakan ini tidak dapat dibatalkan.</p>
      <div class="flex justify-center gap-4">
        <button onclick="closeDeleteModal()" class="px-4 py-2 bg-gray-200 text-gray-700 rounded hover:bg-gray-300 transition">Batal</button>
        <a id="deleteConfirmLink" href="#" class="px-4 py-2 bg-red-500 text-white rounded hover:bg-red-600 transition">Hapus</a>
      </div>
    </div>
  </div>
</div>

<script>
  function showDeleteModal(id) {
    const modal = document.getElementById('deleteModal');
    const box = document.getElementById('deleteBox');
    const link = document.getElementById('deleteConfirmLink');

    // Set tautan hapus
    link.href = `hapus.php?id=${id}`;

    // Tampilkan modal
    modal.classList.remove('hidden');
    setTimeout(() => {
      box.classList.remove('scale-95', 'opacity-0');
      box.classList.add('scale-100', 'opacity-100');
    }, 10);
  }

  function closeDeleteModal() {
    const modal = document.getElementById('deleteModal');
    const box = document.getElementById('deleteBox');

    box.classList.remove('scale-100', 'opacity-100');
    box.classList.add('scale-95', 'opacity-0');

    setTimeout(() => {
      modal.classList.add('hidden');
    }, 300);
  }
</script>


</body>
</html>

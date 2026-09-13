<?php
include 'config.php';
include 'fuzzy_tsukamoto.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $nama = $_POST['nama'];
    $teamwork = $_POST['teamwork'];
    $disiplin = $_POST['disiplin'];
    $tanggung_jawab = $_POST['tanggung_jawab'];
    $produktivitas = $_POST['produktivitas'];

    $hasil = fuzzy_tsukamoto($teamwork, $disiplin, $tanggung_jawab, $produktivitas);
    $nilai_akhir = $hasil['nilai'];
    $kategori = $hasil['kategori'];

    $stmt1 = $conn->prepare("INSERT INTO pegawai (nama) VALUES (?)");
    $stmt1->bind_param("s", $nama);
    $stmt1->execute();
    $pegawai_id = $stmt1->insert_id;

    $stmt2 = $conn->prepare("INSERT INTO penilaian (pegawai_id, teamwork, disiplin, tanggung_jawab, produktivitas, nilai_akhir, kategori)
                             VALUES (?, ?, ?, ?, ?, ?, ?)");
    $stmt2->bind_param("iddddds", $pegawai_id, $teamwork, $disiplin, $tanggung_jawab, $produktivitas, $nilai_akhir, $kategori);
    $stmt2->execute();

    header("Location: dashboard.php");
    exit();
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <title>Tambah Pegawai</title>
  <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gradient-to-br from-blue-200 to-indigo-900 h-screen flex items-center justify-center">

  <form method="POST" class="bg-white/10 backdrop-blur-md p-8 rounded-xl shadow-lg w-[90%] max-w-md border border-white/20 text-white">
    <div class="flex justify-center mb-4">
      <div class="w-10 h-1 bg-white/30 rounded-full"></div>
    </div>

    <h2 class="text-center text-2xl font-semibold mb-6 tracking-wide">Tambah Pegawai</h2>

    <!-- Nama -->
    <div class="mb-4">
      <label class="sr-only" for="nama">Nama Pegawai</label>
      <div class="relative">
        <span class="absolute inset-y-0 left-0 flex items-center pl-3">👤</span>
        <input name="nama" type="text" placeholder="Nama Pegawai" required
          class="pl-10 pr-3 py-2 w-full rounded-md bg-white/20 text-white placeholder-white/70 focus:outline-none focus:ring-2 focus:ring-white/50 border border-white/30">
      </div>
    </div>

    <!-- Nilai Teamwork -->
    <div class="mb-4">
      <label class="sr-only" for="teamwork">Teamwork</label>
      <div class="relative">
        <span class="absolute inset-y-0 left-0 flex items-center pl-3">🤝</span>
        <input name="teamwork" type="number" min="0" max="100" placeholder="Teamwork (0 - 100)" required
          class="pl-10 pr-3 py-2 w-full rounded-md bg-white/20 text-white placeholder-white/70 border border-white/30 focus:outline-none focus:ring-2 focus:ring-white/50">
      </div>
    </div>

    <!-- Nilai Disiplin -->
    <div class="mb-4">
      <label class="sr-only" for="disiplin">Disiplin</label>
      <div class="relative">
        <span class="absolute inset-y-0 left-0 flex items-center pl-3">📅</span>
        <input name="disiplin" type="number" min="0" max="100" placeholder="Disiplin (0 - 100)" required
          class="pl-10 pr-3 py-2 w-full rounded-md bg-white/20 text-white placeholder-white/70 border border-white/30 focus:outline-none focus:ring-2 focus:ring-white/50">
      </div>
    </div>

    <!-- Nilai Tanggung Jawab -->
    <div class="mb-4">
      <label class="sr-only" for="tanggung_jawab">Tanggung Jawab</label>
      <div class="relative">
        <span class="absolute inset-y-0 left-0 flex items-center pl-3">📌</span>
        <input name="tanggung_jawab" type="number" min="0" max="100" placeholder="Tanggung Jawab (0 - 100)" required
          class="pl-10 pr-3 py-2 w-full rounded-md bg-white/20 text-white placeholder-white/70 border border-white/30 focus:outline-none focus:ring-2 focus:ring-white/50">
      </div>
    </div>

    <!-- Nilai Produktivitas -->
    <div class="mb-6">
      <label class="sr-only" for="produktivitas">Produktivitas</label>
      <div class="relative">
        <span class="absolute inset-y-0 left-0 flex items-center pl-3">⚙️</span>
        <input name="produktivitas" type="number" min="0" max="100" placeholder="Produktivitas (0 - 100)" required
          class="pl-10 pr-3 py-2 w-full rounded-md bg-white/20 text-white placeholder-white/70 border border-white/30 focus:outline-none focus:ring-2 focus:ring-white/50">
      </div>
    </div>

    <div class="flex justify-between items-center">
      <a href="dashboard.php"
        class="text-sm bg-transparent border border-white/30 text-white px-4 py-2 rounded-md hover:bg-white/10 transition">
        ← Kembali
      </a>
      <button type="submit"
        class="bg-gray-800 hover:bg-gray-900 transition text-white py-2 px-6 rounded-md shadow-md font-medium">
        Simpan
      </button>
    </div>
  </form>

</body>
</html>

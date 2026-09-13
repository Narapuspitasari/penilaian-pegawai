<?php
include 'config.php';
include 'fuzzy_tsukamoto.php';

$id = $_GET['id'];
if (!$id) { header("Location: dashboard.php"); exit(); }

$sql = "SELECT * FROM pegawai JOIN penilaian ON pegawai.id = penilaian.pegawai_id WHERE pegawai.id = $id";
$data = $conn->query($sql)->fetch_assoc();

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $teamwork = $_POST['teamwork'];
    $disiplin = $_POST['disiplin'];
    $tanggung_jawab = $_POST['tanggung_jawab'];
    $produktivitas = $_POST['produktivitas'];

    $hasil = fuzzy_tsukamoto($teamwork, $disiplin, $tanggung_jawab, $produktivitas);
    $nilai_akhir = $hasil['nilai'];
    $kategori = $hasil['kategori'];

    $stmt = $conn->prepare("UPDATE penilaian SET teamwork=?, disiplin=?, tanggung_jawab=?, produktivitas=?, nilai_akhir=?, kategori=? WHERE pegawai_id=?");
    $stmt->bind_param("dddddsi", $teamwork, $disiplin, $tanggung_jawab, $produktivitas, $nilai_akhir, $kategori, $id);
    $result = $stmt->execute();

    if ($result) {
        header("Location: edit_nilai.php?id=$id&success=1");
        exit;
    } else {
        echo "Gagal memperbarui data.";
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Edit Nilai Pegawai</title>
  <script src="https://cdn.tailwindcss.com"></script>
  <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
</head>
<body class="bg-gradient-to-br from-indigo-200 to-gray-900 min-h-screen flex items-center justify-center">

  <form method="POST" class="bg-white/10 backdrop-blur-md p-8 rounded-xl shadow-lg w-[90%] max-w-md border border-white/20 text-white">
    <div class="flex justify-center mb-4">
      <div class="w-10 h-1 bg-white/30 rounded-full"></div>
    </div>

    <h2 class="text-center text-2xl font-semibold mb-4 tracking-wide">Edit Nilai Pegawai</h2>
    <p class="text-center mb-6 font-medium text-white/80"><?= htmlspecialchars($data['nama']) ?></p>

    <div class="space-y-4">
      <div class="relative">
        <span class="absolute inset-y-0 left-0 flex items-center pl-3">🤝</span>
        <input name="teamwork" type="number" value="<?= $data['teamwork'] ?>" required min="0" max="100" placeholder="Teamwork"
          class="pl-10 pr-3 py-2 w-full rounded-md bg-white/20 text-white placeholder-white/70 focus:outline-none focus:ring-2 focus:ring-white/50 border border-white/30">
      </div>

      <div class="relative">
        <span class="absolute inset-y-0 left-0 flex items-center pl-3">📅</span>
        <input name="disiplin" type="number" value="<?= $data['disiplin'] ?>" required min="0" max="100" placeholder="Disiplin"
          class="pl-10 pr-3 py-2 w-full rounded-md bg-white/20 text-white placeholder-white/70 focus:outline-none focus:ring-2 focus:ring-white/50 border border-white/30">
      </div>

      <div class="relative">
        <span class="absolute inset-y-0 left-0 flex items-center pl-3">📌</span>
        <input name="tanggung_jawab" type="number" value="<?= $data['tanggung_jawab'] ?>" required min="0" max="100" placeholder="Tanggung Jawab"
          class="pl-10 pr-3 py-2 w-full rounded-md bg-white/20 text-white placeholder-white/70 focus:outline-none focus:ring-2 focus:ring-white/50 border border-white/30">
      </div>

      <div class="relative">
        <span class="absolute inset-y-0 left-0 flex items-center pl-3">⚙️</span>
        <input name="produktivitas" type="number" value="<?= $data['produktivitas'] ?>" required min="0" max="100" placeholder="Produktivitas"
          class="pl-10 pr-3 py-2 w-full rounded-md bg-white/20 text-white placeholder-white/70 focus:outline-none focus:ring-2 focus:ring-white/50 border border-white/30">
      </div>
    </div>

    <div class="flex justify-between items-center mt-6">
      <a href="dashboard.php" class="text-sm text-white hover:underline">← Kembali</a>
      <button type="submit"
        class="bg-gray-800 hover:bg-gray-900 transition text-white py-2 px-6 rounded-md shadow-md font-medium">
        Update
      </button>
    </div>
  </form>

  <?php if (isset($_GET['success'])): ?>
  <script>
    Swal.fire({
      toast: true,
      position: 'top-end',
      icon: 'success',
      title: 'Data berhasil diperbarui!',
      showConfirmButton: false,
      timer: 3000,
      timerProgressBar: true,
      background: '#ECFDF5',
      color: '#166534',
      iconColor: '#16A34A',
      customClass: {
        popup: 'rounded-lg shadow-lg border border-green-300'
      }
    });
  </script>
  <?php endif; ?>

</body>
</html>

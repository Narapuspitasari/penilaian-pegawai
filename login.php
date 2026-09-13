<?php
session_start();
$err = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $user = $_POST['username'];
    $pass = $_POST['password'];

    if ($user === 'admin' && $pass === 'admin123') {
        $_SESSION['admin_logged_in'] = true;
        header('Location: dashboard.php');
        exit();
    } else {
        $err = 'Username atau password salah!';
    }
}


?>

<!-- // login.php (setelah username dan password benar)
session_start();
$_SESSION['user_id'] = $user_id_dari_database; // Atau $_SESSION['username'] = $username;
// Opsional: $_SESSION['logged_in'] = true;
header("Location: dashboard.php");
exit(); -->


<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Login Admin</title>
  <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gradient-to-br from-green-200 to-gray-900 h-screen flex items-center justify-center">

  <form method="POST" class="bg-white/10 backdrop-blur-md p-8 rounded-xl shadow-lg w-80 border border-white/20 text-white">
    <div class="flex justify-center mb-4">
      <div class="w-10 h-1 bg-white/30 rounded-full"></div>
    </div>

    <h2 class="text-center text-2xl font-semibold mb-6 tracking-wide">LOGIN</h2>

    <?php if ($err): ?>
      <div class="text-red-300 text-sm mb-4 text-center"><?= $err ?></div>
    <?php endif; ?>

    <div class="mb-4">
      <label class="sr-only" for="username">Username</label>
      <div class="relative">
        <span class="absolute inset-y-0 left-0 flex items-center pl-3">
          🔓
        </span>
        <input name="username" type="text" placeholder="username" required
          class="pl-10 pr-3 py-2 w-full rounded-md bg-white/20 text-white placeholder-white/70 focus:outline-none focus:ring-2 focus:ring-white/50 border border-white/30">
      </div>
    </div>

    <div class="mb-6">
      <label class="sr-only" for="password">Password</label>
      <div class="relative">
        <span class="absolute inset-y-0 left-0 flex items-center pl-3">
          🔒
        </span>
        <input name="password" type="password" placeholder="•••••••" required
          class="pl-10 pr-3 py-2 w-full rounded-md bg-white/20 text-white placeholder-white/70 focus:outline-none focus:ring-2 focus:ring-white/50 border border-white/30">
      </div>
    </div>

    <button type="submit"
      class="w-full bg-gray-800 hover:bg-gray-900 transition text-white py-2 rounded-md shadow-md font-medium">
      Sign In
    </button>
  </form>

</body>
</html>

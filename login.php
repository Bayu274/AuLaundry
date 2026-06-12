<?php
session_start();
require 'config/database.php';

// Jika sudah login, redirect ke dashboard sesuai role
if (isset($_SESSION['logged_in']) && $_SESSION['logged_in'] === true) {
    switch ($_SESSION['role']) {
        case 'admin':
            header('Location: pages/admin/dashboard.php');
            exit;
        case 'karyawan':
            header('Location: pages/karyawan/dashboard.php');
            exit;
        case 'kurir':
            header('Location: pages/kurir/dashboard.php');
            exit;
        case 'pelanggan':
            header('Location: pages/pelanggan/dashboard.php');
            exit;
    }
}

// Ambil role dari query string jika ada
$defaultRole = isset($_GET['role']) ? $_GET['role'] : '';

$errors = [];
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = trim($_POST['username'] ?? '');
    $password = $_POST['password'] ?? '';
    $role = $_POST['role'] ?? '';

    // Validasi input
    if ($username === '') {
        $errors[] = 'Username wajib diisi.';
    }
    if ($password === '') {
        $errors[] = 'Password wajib diisi.';
    }
    if (!in_array($role, ['admin', 'karyawan', 'kurir', 'pelanggan'])) {
        $errors[] = 'Role tidak valid.';
    }

    if (empty($errors)) {
        // Tentukan tabel berdasarkan role
        $table = $role;

        // Query user berdasarkan username
        $stmt = $pdo->prepare("SELECT * FROM $table WHERE username = :username LIMIT 1");
        $stmt->execute(['username' => $username]);
        $user = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($user) {
            // Verifikasi password - cek apakah menggunakan password_hash atau md5
            $passwordValid = false;

            // Cek dengan password_verify (bcrypt)
            if (password_verify($password, $user['password'])) {
                $passwordValid = true;
            }
            // Cek dengan md5 (untuk kompatibilitas data lama)
            elseif (md5($password) === $user['password']) {
                $passwordValid = true;
            }

            if ($passwordValid) {
                // Set session universal
                $_SESSION['logged_in'] = true;
                $_SESSION['role'] = $role;

                // Set session spesifik berdasarkan role
                switch ($role) {
                    case 'admin':
                        $_SESSION['id_admin'] = $user['id_admin'];
                        $_SESSION['nama_admin'] = $user['nama_admin'];
                        $_SESSION['username'] = $user['username'];
                        $_SESSION['level'] = $user['level'];
                        $_SESSION['nama'] = $user['nama_admin'];
                        $_SESSION['id_user'] = $user['id_admin'];
                        header('Location: pages/admin/dashboard.php');
                        exit;

                    case 'karyawan':
                        $_SESSION['id_karyawan'] = $user['id_karyawan'];
                        $_SESSION['nama_karyawan'] = $user['nama_karyawan'];
                        $_SESSION['username'] = $user['username'];
                        $_SESSION['posisi'] = $user['posisi'];
                        $_SESSION['nama'] = $user['nama_karyawan'];
                        $_SESSION['id_user'] = $user['id_karyawan'];
                        header('Location: pages/karyawan/dashboard.php');
                        exit;

                    case 'kurir':
                        $_SESSION['id_kurir'] = $user['id_kurir'];
                        $_SESSION['nama_kurir'] = $user['nama_kurir'];
                        $_SESSION['username'] = $user['username'];
                        $_SESSION['nama'] = $user['nama_kurir'];
                        $_SESSION['id_user'] = $user['id_kurir'];
                        header('Location: pages/kurir/dashboard.php');
                        exit;

                    case 'pelanggan':
                        $_SESSION['id_pelanggan'] = $user['id_pelanggan'];
                        $_SESSION['nama_pelanggan'] = $user['nama_pelanggan'];
                        $_SESSION['username'] = $user['username'];
                        $_SESSION['nama'] = $user['nama_pelanggan'];
                        $_SESSION['id_user'] = $user['id_pelanggan'];
                        header('Location: pages/pelanggan/dashboard.php');
                        exit;
                }
            } else {
                $errors[] = 'Password salah.';
            }
        } else {
            $errors[] = 'Username tidak ditemukan untuk role yang dipilih.';
        }
    }
}
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <title>Login - Aulaundry</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet" />
    <style>
        body { background: #f8f9fa; }
        .login-container { max-width: 400px; margin: 80px auto; padding: 30px; background: white; border-radius: 8px; box-shadow: 0 0 10px rgba(0,0,0,0.1); }
    </style>
</head>
<body>
    <div class="login-container">
        <h3 class="mb-4 text-center">Login Aulaundry</h3>

        <?php if (!empty($errors)): ?>
            <div class="alert alert-danger">
                <ul class="mb-0">
                    <?php foreach ($errors as $error): ?>
                        <li><?= htmlspecialchars($error) ?></li>
                    <?php endforeach; ?>
                </ul>
            </div>
        <?php endif; ?>

        <form method="POST" novalidate>
            <div class="mb-3">
                <label for="username" class="form-label">Username</label>
                <input type="text" id="username" name="username" class="form-control" required value="<?= htmlspecialchars($_POST['username'] ?? '') ?>" />
            </div>
            <div class="mb-3">
                <label for="password" class="form-label">Password</label>
                <input type="password" id="password" name="password" class="form-control" required />
            </div>
            <div class="mb-3">
                <label for="role" class="form-label">Login sebagai</label>
                <select id="role" name="role" class="form-select" required>
                    <option value="">-- Pilih Role --</option>
                    <option value="admin" <?= ($defaultRole === 'admin' || ($_POST['role'] ?? '') === 'admin') ? 'selected' : '' ?>>Admin</option>
                    <option value="karyawan" <?= ($defaultRole === 'karyawan' || ($_POST['role'] ?? '') === 'karyawan') ? 'selected' : '' ?>>Karyawan</option>
                    <option value="kurir" <?= ($defaultRole === 'kurir' || ($_POST['role'] ?? '') === 'kurir') ? 'selected' : '' ?>>Kurir</option>
                    <option value="pelanggan" <?= ($defaultRole === 'pelanggan' || ($_POST['role'] ?? '') === 'pelanggan') ? 'selected' : '' ?>>Pelanggan</option>
                </select>
            </div>
            <button type="submit" class="btn btn-primary w-100">Login</button>
        </form>

        <div class="mt-3 text-center">
            <a href="index.php">Kembali ke Beranda</a>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>

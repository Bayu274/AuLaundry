<?php
session_start();
require_once __DIR__ . '/../../config/database.php';

// Cek apakah form login sudah di-submit
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = trim($_POST['username'] ?? '');
    $password = $_POST['password'] ?? '';
    $role     = strtolower(trim($_POST['role'] ?? ''));

    // Validasi input
    if (empty($username) || empty($password) || empty($role)) {
        $_SESSION['error'] = 'Username, Password, dan Role wajib diisi!';
        header('Location: ../../login.php');
        exit;
    }

    // Mapping role ke tabel
    $roles = [
        'admin'     => ['table' => 'admin',     'id' => 'id_admin'],
        'karyawan'  => ['table' => 'karyawan',  'id' => 'id_karyawan'],
        'kurir'     => ['table' => 'kurir',     'id' => 'id_kurir'],
        'pelanggan' => ['table' => 'pelanggan', 'id' => 'id_pelanggan']
    ];

    // Validasi role
    if (!array_key_exists($role, $roles)) {
        $_SESSION['error'] = 'Role tidak valid!';
        header('Location: ../../login.php');
        exit;
    }

    // Koneksi database menggunakan fungsi db()
    $pdo = db();

    $table   = $roles[$role]['table'];
    $idField = $roles[$role]['id'];

    // Query ke tabel sesuai role yang dipilih
    $stmt = $pdo->prepare("SELECT * FROM {$table} WHERE username = :username");
    $stmt->execute(['username' => $username]);
    $user = $stmt->fetch();

    if ($user && password_verify($password, $user['password'])) {
        // ✅ Set session lengkap
        $_SESSION['logged_in'] = true;
        $_SESSION['user_id']   = $user[$idField];
        $_SESSION['username']  = $user['username'];
        $_SESSION['nama']      = $user['nama'] ?? $user['username'];
        $_SESSION['role']      = $role; // simpan lowercase: admin, karyawan, kurir, pelanggan

        // Redirect ke dashboard sesuai role
        header("Location: ../../pages/{$role}/dashboard.php");
        exit;
    } else {
        $_SESSION['error'] = 'Username atau Password salah!';
        header('Location: ../../login.php');
        exit;
    }
} else {
    // Jika akses langsung tanpa POST
    header('Location: ../../login.php');
    exit;
}
?>

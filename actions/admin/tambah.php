<?php
session_start();
require_once __DIR__ . '/../../config/database.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $nama     = trim($_POST['nama_admin'] ?? '');
    $username = trim($_POST['username'] ?? '');
    $password = $_POST['password'] ?? '';
    $level    = $_POST['level'] ?? '';

    if (empty($nama) || empty($username) || empty($password) || empty($level)) {
        $_SESSION['flash'] = ['type' => 'danger', 'message' => 'Semua field wajib diisi.'];
        header('Location: /aulaundry/pages/admin/tambah_admin.php');
        exit;
    }

    // Cek username duplikat
    $stmt = db()->prepare("SELECT id_admin FROM admin WHERE username = ?");
    $stmt->execute([$username]);
    if ($stmt->fetch()) {
        $_SESSION['flash'] = ['type' => 'danger', 'message' => 'Username sudah digunakan.'];
        header('Location: /aulaundry/pages/admin/tambah_admin.php');
        exit;
    }

    $hashedPassword = password_hash($password, PASSWORD_DEFAULT);

    $stmt = db()->prepare("INSERT INTO admin (nama_admin, username, password, level, created_at, updated_at) VALUES (?, ?, ?, ?, NOW(), NOW())");
    $stmt->execute([$nama, $username, $hashedPassword, $level]);

    $_SESSION['flash'] = ['type' => 'success', 'message' => 'Admin berhasil ditambahkan.'];
    header('Location: /aulaundry/pages/admin/data_admin.php');
    exit;
}

header('Location: /aulaundry/pages/admin/data_admin.php');
exit;

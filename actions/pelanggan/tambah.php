<?php
session_start();
require_once __DIR__ . '/../../config/database.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $nama_pelanggan = trim($_POST['nama_pelanggan'] ?? '');
    $alamat        = trim($_POST['alamat'] ?? '');
    $no_hp         = trim($_POST['no_hp'] ?? '');
    $username      = trim($_POST['username'] ?? '');
    $password      = $_POST['password'] ?? '';

    if (empty($nama_pelanggan) || empty($alamat) || empty($no_hp) || empty($username) || empty($password)) {
        $_SESSION['flash'] = ['type' => 'danger', 'message' => 'Semua field wajib diisi.'];
        header('Location: /aulaundry/pages/admin/tambah_pelanggan.php');
        exit;
    }

    // Cek username sudah ada atau belum
    $stmt = db()->prepare("SELECT id_pelanggan FROM pelanggan WHERE username = ?");
    $stmt->execute([$username]);
    if ($stmt->fetch()) {
        $_SESSION['flash'] = ['type' => 'danger', 'message' => 'Username sudah digunakan.'];
        header('Location: /aulaundry/pages/admin/tambah_pelanggan.php');
        exit;
    }

    $hashedPassword = password_hash($password, PASSWORD_DEFAULT);

    $stmt = db()->prepare("INSERT INTO pelanggan (nama_pelanggan, alamat, no_hp, username, password, created_at, updated_at) VALUES (?, ?, ?, ?, ?, NOW(), NOW())");
    $stmt->execute([$nama_pelanggan, $alamat, $no_hp, $username, $hashedPassword]);

    $_SESSION['flash'] = ['type' => 'success', 'message' => 'Pelanggan berhasil ditambahkan.'];
    header('Location: /aulaundry/pages/admin/data_pelanggan.php');
    exit;
}

header('Location: /aulaundry/pages/admin/data_pelanggan.php');
exit;

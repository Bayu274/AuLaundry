<?php
session_start();
require_once __DIR__ . '/../../config/database.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $nama     = trim($_POST['nama_kurir'] ?? '');
    $no_hp    = trim($_POST['no_hp'] ?? '');
    $alamat   = trim($_POST['alamat'] ?? '');
    $username = trim($_POST['username'] ?? '');
    $password = $_POST['password'] ?? '';
    $status   = $_POST['status_aktif'] ?? 'Aktif';

    if (empty($nama) || empty($no_hp) || empty($username) || empty($password)) {
        $_SESSION['flash'] = ['type' => 'danger', 'message' => 'Semua field wajib diisi.'];
        header('Location: /aulaundry/pages/admin/tambah_kurir.php');
        exit;
    }

    $hashedPassword = password_hash($password, PASSWORD_DEFAULT);

    $stmt = db()->prepare("INSERT INTO kurir (nama_kurir, no_hp, alamat, username, password, status_aktif, created_at, updated_at) VALUES (?, ?, ?, ?, ?, ?, NOW(), NOW())");
    $stmt->execute([$nama, $no_hp, $alamat, $username, $hashedPassword, $status]);

    $_SESSION['flash'] = ['type' => 'success', 'message' => 'Kurir berhasil ditambahkan.'];
    header('Location: /aulaundry/pages/admin/data_kurir.php');
    exit;
}

header('Location: /aulaundry/pages/admin/data_kurir.php');
exit;

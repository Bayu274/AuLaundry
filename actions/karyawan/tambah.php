<?php
session_start();
require_once __DIR__ . '/../../config/database.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $nama     = trim($_POST['nama_karyawan'] ?? '');
    $posisi   = trim($_POST['posisi'] ?? '');
    $no_hp    = trim($_POST['no_hp'] ?? '');
    $alamat   = trim($_POST['alamat'] ?? '');
    $username = trim($_POST['username'] ?? '');
    $password = $_POST['password'] ?? '';
    $status   = $_POST['status_aktif'] ?? 'Aktif';

    if (empty($nama) || empty($posisi) || empty($no_hp) || empty($alamat)) {
        $_SESSION['flash'] = ['type' => 'danger', 'message' => 'Field wajib harus diisi.'];
        header('Location: /aulaundry/pages/admin/tambah_karyawan.php');
        exit;
    }

    $hashedPassword = !empty($password) ? password_hash($password, PASSWORD_DEFAULT) : null;

    $stmt = db()->prepare("INSERT INTO karyawan (nama_karyawan, posisi, no_hp, alamat, username, password, status_aktif, created_at, updated_at) VALUES (?, ?, ?, ?, ?, ?, ?, NOW(), NOW())");
    $stmt->execute([$nama, $posisi, $no_hp, $alamat, $username ?: null, $hashedPassword, $status]);

    $_SESSION['flash'] = ['type' => 'success', 'message' => 'Karyawan berhasil ditambahkan.'];
    header('Location: /aulaundry/pages/admin/data_karyawan.php');
    exit;
}

header('Location: /aulaundry/pages/admin/data_karyawan.php');
exit;

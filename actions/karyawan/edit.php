<?php
session_start();
require_once __DIR__ . '/../../config/database.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $id       = (int)($_POST['id_karyawan'] ?? 0);
    $nama     = trim($_POST['nama_karyawan'] ?? '');
    $posisi   = trim($_POST['posisi'] ?? '');
    $no_hp    = trim($_POST['no_hp'] ?? '');
    $alamat   = trim($_POST['alamat'] ?? '');
    $username = trim($_POST['username'] ?? '');
    $password = $_POST['password'] ?? '';
    $status   = $_POST['status_aktif'] ?? 'Aktif';

    if (!$id || empty($nama) || empty($posisi) || empty($no_hp)) {
        $_SESSION['flash'] = ['type' => 'danger', 'message' => 'Data tidak lengkap.'];
        header('Location: /aulaundry/pages/admin/data_karyawan.php');
        exit;
    }

    if (!empty($password)) {
        $hashedPassword = password_hash($password, PASSWORD_DEFAULT);
        $stmt = db()->prepare("UPDATE karyawan SET nama_karyawan = ?, posisi = ?, no_hp = ?, alamat = ?, username = ?, password = ?, status_aktif = ?, updated_at = NOW() WHERE id_karyawan = ?");
        $stmt->execute([$nama, $posisi, $no_hp, $alamat, $username ?: null, $hashedPassword, $status, $id]);
    } else {
        $stmt = db()->prepare("UPDATE karyawan SET nama_karyawan = ?, posisi = ?, no_hp = ?, alamat = ?, username = ?, status_aktif = ?, updated_at = NOW() WHERE id_karyawan = ?");
        $stmt->execute([$nama, $posisi, $no_hp, $alamat, $username ?: null, $status, $id]);
    }

    $_SESSION['flash'] = ['type' => 'success', 'message' => 'Data karyawan berhasil diperbarui.'];
    header('Location: /aulaundry/pages/admin/data_karyawan.php');
    exit;
}

header('Location: /aulaundry/pages/admin/data_karyawan.php');
exit;

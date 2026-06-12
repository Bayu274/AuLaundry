<?php
session_start();
require_once __DIR__ . '/../../config/database.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $id       = (int)($_POST['id_kurir'] ?? 0);
    $nama     = trim($_POST['nama_kurir'] ?? '');
    $no_hp    = trim($_POST['no_hp'] ?? '');
    $alamat   = trim($_POST['alamat'] ?? '');
    $username = trim($_POST['username'] ?? '');
    $password = $_POST['password'] ?? '';
    $status   = $_POST['status_aktif'] ?? 'Aktif';

    if (!$id || empty($nama) || empty($no_hp) || empty($username)) {
        $_SESSION['flash'] = ['type' => 'danger', 'message' => 'Data tidak lengkap.'];
        header('Location: /aulaundry/pages/admin/data_kurir.php');
        exit;
    }

    if (!empty($password)) {
        $hashedPassword = password_hash($password, PASSWORD_DEFAULT);
        $stmt = db()->prepare("UPDATE kurir SET nama_kurir = ?, no_hp = ?, alamat = ?, username = ?, password = ?, status_aktif = ?, updated_at = NOW() WHERE id_kurir = ?");
        $stmt->execute([$nama, $no_hp, $alamat, $username, $hashedPassword, $status, $id]);
    } else {
        $stmt = db()->prepare("UPDATE kurir SET nama_kurir = ?, no_hp = ?, alamat = ?, username = ?, status_aktif = ?, updated_at = NOW() WHERE id_kurir = ?");
        $stmt->execute([$nama, $no_hp, $alamat, $username, $status, $id]);
    }

    $_SESSION['flash'] = ['type' => 'success', 'message' => 'Data kurir berhasil diperbarui.'];
    header('Location: /aulaundry/pages/admin/data_kurir.php');
    exit;
}

header('Location: /aulaundry/pages/admin/data_kurir.php');
exit;

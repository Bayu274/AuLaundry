<?php
session_start();
require_once __DIR__ . '/../../config/database.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $id            = (int)($_POST['id_pelanggan'] ?? 0);
    $nama_pelanggan = trim($_POST['nama_pelanggan'] ?? '');
    $alamat        = trim($_POST['alamat'] ?? '');
    $no_hp         = trim($_POST['no_hp'] ?? '');
    $username      = trim($_POST['username'] ?? '');
    $password      = $_POST['password'] ?? '';

    if (!$id || empty($nama_pelanggan) || empty($alamat) || empty($no_hp) || empty($username)) {
        $_SESSION['flash'] = ['type' => 'danger', 'message' => 'Data tidak lengkap.'];
        header('Location: /aulaundry/pages/admin/data_pelanggan.php');
        exit;
    }

    // Cek username duplikat kecuali milik sendiri
    $stmt = db()->prepare("SELECT id_pelanggan FROM pelanggan WHERE username = ? AND id_pelanggan != ?");
    $stmt->execute([$username, $id]);
    if ($stmt->fetch()) {
        $_SESSION['flash'] = ['type' => 'danger', 'message' => 'Username sudah digunakan oleh pelanggan lain.'];
        header('Location: /aulaundry/pages/admin/edit_pelanggan.php?id=' . $id);
        exit;
    }

    if (!empty($password)) {
        $hashedPassword = password_hash($password, PASSWORD_DEFAULT);
        $stmt = db()->prepare("UPDATE pelanggan SET nama_pelanggan = ?, alamat = ?, no_hp = ?, username = ?, password = ?, updated_at = NOW() WHERE id_pelanggan = ?");
        $stmt->execute([$nama_pelanggan, $alamat, $no_hp, $username, $hashedPassword, $id]);
    } else {
        $stmt = db()->prepare("UPDATE pelanggan SET nama_pelanggan = ?, alamat = ?, no_hp = ?, username = ?, updated_at = NOW() WHERE id_pelanggan = ?");
        $stmt->execute([$nama_pelanggan, $alamat, $no_hp, $username, $id]);
    }

    $_SESSION['flash'] = ['type' => 'success', 'message' => 'Data pelanggan berhasil diperbarui.'];
    header('Location: /aulaundry/pages/admin/data_pelanggan.php');
    exit;
}

header('Location: /aulaundry/pages/admin/data_pelanggan.php');
exit;

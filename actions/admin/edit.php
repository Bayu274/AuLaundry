<?php
session_start();
require_once __DIR__ . '/../../config/database.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $id       = (int)($_POST['id_admin'] ?? 0);
    $nama     = trim($_POST['nama_admin'] ?? '');
    $username = trim($_POST['username'] ?? '');
    $password = $_POST['password'] ?? '';
    $level    = $_POST['level'] ?? '';

    if (!$id || empty($nama) || empty($username) || empty($level)) {
        $_SESSION['flash'] = ['type' => 'danger', 'message' => 'Data tidak lengkap.'];
        header('Location: /aulaundry/pages/admin/data_admin.php');
        exit;
    }

    // Cek username duplikat (kecuali milik sendiri)
    $stmt = db()->prepare("SELECT id_admin FROM admin WHERE username = ? AND id_admin != ?");
    $stmt->execute([$username, $id]);
    if ($stmt->fetch()) {
        $_SESSION['flash'] = ['type' => 'danger', 'message' => 'Username sudah digunakan oleh admin lain.'];
        header('Location: /aulaundry/pages/admin/edit_admin.php?id=' . $id);
        exit;
    }

    if (!empty($password)) {
        $hashedPassword = password_hash($password, PASSWORD_DEFAULT);
        $stmt = db()->prepare("UPDATE admin SET nama_admin = ?, username = ?, password = ?, level = ?, updated_at = NOW() WHERE id_admin = ?");
        $stmt->execute([$nama, $username, $hashedPassword, $level, $id]);
    } else {
        $stmt = db()->prepare("UPDATE admin SET nama_admin = ?, username = ?, level = ?, updated_at = NOW() WHERE id_admin = ?");
        $stmt->execute([$nama, $username, $level, $id]);
    }

    $_SESSION['flash'] = ['type' => 'success', 'message' => 'Data admin berhasil diperbarui.'];
    header('Location: /aulaundry/pages/admin/data_admin.php');
    exit;
}

header('Location: /aulaundry/pages/admin/data_admin.php');
exit;

<?php
session_start();
require_once __DIR__ . '/../../config/database.php';

$id = (int)($_GET['id'] ?? 0);

if (!$id) {
    $_SESSION['flash'] = ['type' => 'danger', 'message' => 'ID admin tidak valid.'];
    header('Location: /aulaundry/pages/admin/data_admin.php');
    exit;
}

// Jangan hapus admin utama (id = 1)
if ($id === 1) {
    $_SESSION['flash'] = ['type' => 'danger', 'message' => 'Admin utama tidak bisa dihapus.'];
    header('Location: /aulaundry/pages/admin/data_admin.php');
    exit;
}

$stmt = db()->prepare("DELETE FROM admin WHERE id_admin = ?");
$stmt->execute([$id]);

$_SESSION['flash'] = ['type' => 'success', 'message' => 'Admin berhasil dihapus.'];
header('Location: /aulaundry/pages/admin/data_admin.php');
exit;

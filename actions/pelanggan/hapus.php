<?php
session_start();
require_once __DIR__ . '/../../config/database.php';

$id = (int)($_GET['id'] ?? 0);

if (!$id) {
    $_SESSION['flash'] = ['type' => 'danger', 'message' => 'ID pelanggan tidak valid.'];
    header('Location: /aulaundry/pages/admin/data_pelanggan.php');
    exit;
}

$stmt = db()->prepare("DELETE FROM pelanggan WHERE id_pelanggan = ?");
$stmt->execute([$id]);

$_SESSION['flash'] = ['type' => 'success', 'message' => 'Pelanggan berhasil dihapus.'];
header('Location: /aulaundry/pages/admin/data_pelanggan.php');
exit;

<?php
session_start();
require_once __DIR__ . '/../../config/database.php';

$id = (int)($_GET['id'] ?? 0);

if (!$id) {
    $_SESSION['flash'] = ['type' => 'danger', 'message' => 'ID pesanan tidak valid.'];
    header('Location: /aulaundry/pages/admin/data_pesanan.php');
    exit;
}

$stmt = db()->prepare("DELETE FROM pesanan WHERE id_pesanan = ?");
$stmt->execute([$id]);

$_SESSION['flash'] = ['type' => 'success', 'message' => 'Pesanan berhasil dihapus.'];
header('Location: /aulaundry/pages/admin/data_pesanan.php');
exit;

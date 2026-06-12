<?php
session_start();
require_once __DIR__ . '/../../config/database.php';

$id = (int)($_GET['id'] ?? 0);

if (!$id) {
    $_SESSION['flash'] = ['type' => 'danger', 'message' => 'ID kurir tidak valid.'];
    header('Location: /aulaundry/pages/admin/data_kurir.php');
    exit;
}

$stmt = db()->prepare("DELETE FROM kurir WHERE id_kurir = ?");
$stmt->execute([$id]);

$_SESSION['flash'] = ['type' => 'success', 'message' => 'Kurir berhasil dihapus.'];
header('Location: /aulaundry/pages/admin/data_kurir.php');
exit;

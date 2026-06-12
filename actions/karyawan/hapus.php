<?php
session_start();
require_once __DIR__ . '/../../config/database.php';

$id = (int)($_GET['id'] ?? 0);

if (!$id) {
    $_SESSION['flash'] = ['type' => 'danger', 'message' => 'ID karyawan tidak valid.'];
    header('Location: /aulaundry/pages/admin/data_karyawan.php');
    exit;
}

$stmt = db()->prepare("DELETE FROM karyawan WHERE id_karyawan = ?");
$stmt->execute([$id]);

$_SESSION['flash'] = ['type' => 'success', 'message' => 'Karyawan berhasil dihapus.'];
header('Location: /aulaundry/pages/admin/data_karyawan.php');
exit;

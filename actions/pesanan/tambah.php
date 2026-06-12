<?php
session_start();
require_once __DIR__ . '/../../config/database.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $id_pelanggan   = (int)($_POST['id_pelanggan'] ?? 0);
    $jenis_layanan  = trim($_POST['jenis_layanan'] ?? '');
    $jenis_waktu    = trim($_POST['jenis_waktu'] ?? '');
    $berat          = (float)($_POST['berat'] ?? 0);
    $total_bayar    = (int)($_POST['total_bayar'] ?? 0);
    $status_laundry = $_POST['status_laundry'] ?? 'Menunggu';
    $status_piutang = $_POST['status_piutang'] ?? 'Belum Lunas';

    if (!$id_pelanggan || empty($jenis_layanan) || empty($jenis_waktu) || $berat <= 0) {
        $_SESSION['flash'] = ['type' => 'danger', 'message' => 'Data pesanan tidak lengkap.'];
        header('Location: /aulaundry/pages/admin/tambah_pesanan.php');
        exit;
    }

    // Generate no_pesanan
    $no_pesanan = 'AUL-' . date('Ymd') . '-' . strtoupper(substr(uniqid(), -5));

    $stmt = db()->prepare("INSERT INTO pesanan (no_pesanan, id_pelanggan, jenis_layanan, jenis_waktu, berat_kg, total_bayar, status_laundry, status_piutang, tgl_masuk, created_at, updated_at) VALUES (?, ?, ?, ?, ?, ?, ?, ?, NOW(), NOW(), NOW())");
    $stmt->execute([$no_pesanan, $id_pelanggan, $jenis_layanan, $jenis_waktu, $berat, $total_bayar, $status_laundry, $status_piutang]);

    $_SESSION['flash'] = ['type' => 'success', 'message' => 'Pesanan berhasil ditambahkan.'];
    header('Location: /aulaundry/pages/admin/data_pesanan.php');
    exit;
}

header('Location: /aulaundry/pages/admin/data_pesanan.php');
exit;

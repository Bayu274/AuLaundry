<?php
session_start();
require_once __DIR__ . '/../../config/database.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $id              = (int)($_POST['id_pesanan'] ?? 0);
    $id_pelanggan    = (int)($_POST['id_pelanggan'] ?? 0);
    $jenis_layanan   = trim($_POST['jenis_layanan'] ?? '');
    $jenis_waktu     = trim($_POST['jenis_waktu'] ?? '');
    $berat           = (float)($_POST['berat'] ?? 0);
    $total_bayar     = (int)($_POST['total_bayar'] ?? 0);
    $status_laundry  = $_POST['status_laundry'] ?? 'Menunggu';
    $status_piutang  = $_POST['status_piutang'] ?? 'Belum Lunas';
    $pesanan_diambil = isset($_POST['pesanan_diambil']) ? 1 : 0;

    if (!$id || !$id_pelanggan || empty($jenis_layanan)) {
        $_SESSION['flash'] = ['type' => 'danger', 'message' => 'Data tidak lengkap.'];
        header('Location: /aulaundry/pages/admin/data_pesanan.php');
        exit;
    }

    // Set tgl_selesai jika status = Selesai
    $tgl_selesai = ($status_laundry === 'Selesai') ? date('Y-m-d H:i:s') : null;

    $stmt = db()->prepare("UPDATE pesanan SET id_pelanggan = ?, jenis_layanan = ?, jenis_waktu = ?, berat_kg = ?, total_bayar = ?, status_laundry = ?, status_piutang = ?, tgl_selesai = COALESCE(?, tgl_selesai), pesanan_diambil = ?, updated_at = NOW() WHERE id_pesanan = ?");
    $stmt->execute([$id_pelanggan, $jenis_layanan, $jenis_waktu, $berat, $total_bayar, $status_laundry, $status_piutang, $tgl_selesai, $pesanan_diambil, $id]);

    $_SESSION['flash'] = ['type' => 'success', 'message' => 'Pesanan berhasil diperbarui.'];
    header('Location: /aulaundry/pages/admin/data_pesanan.php');
    exit;
}

header('Location: /aulaundry/pages/admin/data_pesanan.php');
exit;

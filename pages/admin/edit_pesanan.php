<?php
require_once __DIR__ . '/../../includes/auth.php';
checkRole('admin');

$baseUrl = '/aulaundry';

$id = (int)($_GET['id'] ?? 0);
if (!$id) {
    $_SESSION['flash'] = ['type' => 'danger', 'message' => 'ID pesanan tidak valid.'];
    header('Location: ' . $baseUrl . '/pages/admin/data_pesanan.php');
    exit;
}

// Ambil data pesanan
$stmt = db()->prepare("SELECT * FROM pesanan WHERE id_pesanan = ?");
$stmt->execute([$id]);
$pesanan = $stmt->fetch();

if (!$pesanan) {
    $_SESSION['flash'] = ['type' => 'danger', 'message' => 'Pesanan tidak ditemukan.'];
    header('Location: ' . $baseUrl . '/pages/admin/data_pesanan.php');
    exit;
}

// Ambil data pelanggan untuk dropdown
$pelangganList = db()->query("SELECT id_pelanggan, nama_pelanggan FROM pelanggan ORDER BY nama_pelanggan ASC")->fetchAll();

$pageTitle = 'Edit Pesanan';

// Daftar layanan
$daftarLayanan = [
    'Lengkap', 'Setrika', 'Cuci Kering', 'Cuci Basah',
    'Jas Lengkap', 'Jas Atasan', 'Sepatu Besar', 'Sepatu Anak-anak',
    'Bed Cover', 'Bantal Guling Besar', 'Bantal Guling Kecil',
    'Sprei/Selimut', 'Karpet Tebal', 'Karpet Tipis', 'Helm'
];

$daftarWaktu = [
    'Ekspres' => 'Ekspres (3 jam)',
    'Cepat'   => 'Cepat (6 jam)',
    'Reguler' => 'Reguler (1 hari)',
    'Hemat'   => 'Hemat (3 hari)',
];

include __DIR__ . '/../../includes/header.php';
include __DIR__ . '/../../includes/sidebar.php';
?>

<style>
    .main-content {
        margin-left: 250px;
        padding-top: 80px;
        padding-bottom: 30px;
        padding-left: 30px;
        padding-right: 30px;
        min-height: 100vh;
    }
    @media (max-width: 768px) {
        .main-content {
            margin-left: 0;
            padding-top: 70px;
            padding-left: 15px;
            padding-right: 15px;
        }
    }
</style>

<main class="main-content">
    <div class="container-fluid py-4">
        <h2 class="mb-1">Edit Pesanan</h2>
        <p class="text-muted">Perbarui data pesanan.</p>

        <!-- FLASH MESSAGE -->
        <?php if (isset($_SESSION['flash'])): ?>
            <div class="alert alert-<?= $_SESSION['flash']['type'] ?> alert-dismissible fade show">
                <?= $_SESSION['flash']['message'] ?>
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
            <?php unset($_SESSION['flash']); ?>
        <?php endif; ?>

        <div class="card p-4">
            <form action="<?= $baseUrl ?>/actions/pesanan/edit.php" method="POST" id="formPesanan">
                <input type="hidden" name="id_pesanan" value="<?= $pesanan['id_pesanan'] ?>">

                <div class="mb-3">
                    <label for="no_pesanan" class="form-label">No. Pesanan</label>
                    <input type="text" class="form-control" value="<?= htmlspecialchars($pesanan['no_pesanan']) ?>" disabled>
                </div>

                <div class="mb-3">
                    <label for="id_pelanggan" class="form-label">Pelanggan</label>
                    <select name="id_pelanggan" id="id_pelanggan" class="form-select" required>
                        <?php foreach ($pelangganList as $pel): ?>
                            <option value="<?= $pel['id_pelanggan'] ?>" <?= $pel['id_pelanggan'] == $pesanan['id_pelanggan'] ? 'selected' : '' ?>>
                                <?= htmlspecialchars($pel['nama_pelanggan']) ?>
                            </option>
                        <?php endforeach; ?>
                    </select>
                </div>

                <div class="mb-3">
                    <label for="jenis_layanan" class="form-label">Jenis Layanan</label>
                    <select name="jenis_layanan" id="jenis_layanan" class="form-select" required>
                        <?php foreach ($daftarLayanan as $layanan): ?>
                            <option value="<?= $layanan ?>" <?= $pesanan['jenis_layanan'] === $layanan ? 'selected' : '' ?>>
                                <?= $layanan ?>
                            </option>
                        <?php endforeach; ?>
                    </select>
                </div>

                <div class="mb-3">
                    <label for="jenis_waktu" class="form-label">Jenis Waktu</label>
                    <select name="jenis_waktu" id="jenis_waktu" class="form-select" required>
                        <?php foreach ($daftarWaktu as $key => $label): ?>
                            <option value="<?= $key ?>" <?= $pesanan['jenis_waktu'] === $key ? 'selected' : '' ?>>
                                <?= $label ?>
                            </option>
                        <?php endforeach; ?>
                    </select>
                </div>

                <div class="mb-3">
                    <label for="berat" class="form-label">Berat/Jumlah</label>
                    <input type="number" step="0.1" min="0.1" name="berat" id="berat" class="form-control" value="<?= htmlspecialchars($pesanan['berat_kg']) ?>" required>
                </div>

                <div class="mb-3">
                    <label for="total_bayar_display" class="form-label">Total Bayar (Rp)</label>
                    <input type="text" id="total_bayar_display" class="form-control" readonly>
                    <input type="hidden" name="total_bayar" id="total_bayar" value="<?= htmlspecialchars($pesanan['total_bayar']) ?>">
                </div>

                <div class="mb-3">
                    <label for="status_laundry" class="form-label">Status Laundry</label>
                    <select name="status_laundry" id="status_laundry" class="form-select" required>
                        <option value="Menunggu" <?= $pesanan['status_laundry'] === 'Menunggu' ? 'selected' : '' ?>>Menunggu</option>
                        <option value="Diproses" <?= $pesanan['status_laundry'] === 'Diproses' ? 'selected' : '' ?>>Diproses</option>
                        <option value="Selesai" <?= $pesanan['status_laundry'] === 'Selesai' ? 'selected' : '' ?>>Selesai</option>
                    </select>
                </div>

                <div class="mb-3">
                    <label for="status_piutang" class="form-label">Status Piutang</label>
                    <select name="status_piutang" id="status_piutang" class="form-select" required>
                        <option value="Belum Lunas" <?= $pesanan['status_piutang'] === 'Belum Lunas' ? 'selected' : '' ?>>Belum Lunas</option>
                        <option value="Lunas" <?= $pesanan['status_piutang'] === 'Lunas' ? 'selected' : '' ?>>Lunas</option>
                    </select>
                </div>

                <div class="mb-3">
                    <label for="pesanan_diambil" class="form-label">Status Pengambilan</label>
                    <div class="form-check">
                        <input type="checkbox" name="pesanan_diambil" id="pesanan_diambil" class="form-check-input" value="1" <?= $pesanan['pesanan_diambil'] ? 'checked' : '' ?>>
                        <label for="pesanan_diambil" class="form-check-label">Pesanan Sudah Diambil</label>
                    </div>
                </div>

                <button type="submit" class="btn btn-primary">Simpan Perubahan</button>
                <a href="<?= $baseUrl ?>/pages/admin/data_pesanan.php" class="btn btn-secondary">Batal</a>
            </form>
        </div>
    </div>
</main>

<?php include __DIR__ . '/../../includes/footer.php'; ?>

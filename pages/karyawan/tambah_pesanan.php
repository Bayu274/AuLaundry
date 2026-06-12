<?php
require_once __DIR__ . '/../../includes/auth.php';
checkRole('karyawan');

$baseUrl = '/aulaundry';
$pageTitle = 'Tambah Pesanan';

// Ambil data pelanggan untuk dropdown
$pelangganList = db()->query("SELECT id_pelanggan, nama_pelanggan FROM pelanggan ORDER BY nama_pelanggan ASC")->fetchAll();

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
        <h2 class="mb-1">Tambah Pesanan</h2>
        <p class="text-muted">Masukkan data pesanan baru.</p>

        <!-- FLASH MESSAGE -->
        <?php if (isset($_SESSION['flash'])): ?>
            <div class="alert alert-<?= $_SESSION['flash']['type'] ?> alert-dismissible fade show">
                <?= $_SESSION['flash']['message'] ?>
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
            <?php unset($_SESSION['flash']); ?>
        <?php endif; ?>

        <div class="card p-4">
            <form action="<?= $baseUrl ?>/actions/pesanan/tambah.php" method="POST" id="formPesanan">
                <div class="mb-3">
                    <label for="id_pelanggan" class="form-label">Pelanggan</label>
                    <select name="id_pelanggan" id="id_pelanggan" class="form-select" required>
                        <option value="">-- Pilih Pelanggan --</option>
                        <?php foreach ($pelangganList as $pel): ?>
                            <option value="<?= $pel['id_pelanggan'] ?>"><?= htmlspecialchars($pel['nama_pelanggan']) ?></option>
                        <?php endforeach; ?>
                    </select>
                </div>

                <div class="mb-3">
                    <label for="jenis_layanan" class="form-label">Jenis Layanan</label>
                    <select name="jenis_layanan" id="jenis_layanan" class="form-select" required>
                        <option value="">-- Pilih Jenis Layanan --</option>
                        <option value="Lengkap">Lengkap</option>
                        <option value="Setrika">Setrika</option>
                        <option value="Cuci Kering">Cuci Kering</option>
                        <option value="Cuci Basah">Cuci Basah</option>
                        <option value="Jas Lengkap">Jas Lengkap</option>
                        <option value="Jas Atasan">Jas Atasan</option>
                        <option value="Sepatu Besar">Sepatu Besar</option>
                        <option value="Sepatu Anak-anak">Sepatu Anak-anak</option>
                        <option value="Bed Cover">Bed Cover</option>
                        <option value="Bantal Guling Besar">Bantal Guling Besar</option>
                        <option value="Bantal Guling Kecil">Bantal Guling Kecil</option>
                        <option value="Sprei/Selimut">Sprei/Selimut</option>
                        <option value="Karpet Tebal">Karpet Tebal</option>
                        <option value="Karpet Tipis">Karpet Tipis</option>
                        <option value="Helm">Helm</option>
                    </select>
                </div>

                <div class="mb-3">
                    <label for="jenis_waktu" class="form-label">Jenis Waktu</label>
                    <select name="jenis_waktu" id="jenis_waktu" class="form-select" required>
                        <option value="">-- Pilih Jenis Waktu --</option>
                        <option value="Ekspres">Ekspres (3 jam)</option>
                        <option value="Cepat">Cepat (6 jam)</option>
                        <option value="Reguler">Reguler (1 hari)</option>
                        <option value="Hemat">Hemat (3 hari)</option>
                    </select>
                </div>

                <div class="mb-3">
                    <label for="berat" class="form-label">Berat/Jumlah</label>
                    <input type="number" step="0.1" min="0.1" name="berat" id="berat" class="form-control" required>
                </div>

                <div class="mb-3">
                    <label for="total_bayar_display" class="form-label">Total Bayar (Rp)</label>
                    <input type="text" id="total_bayar_display" class="form-control" readonly>
                    <input type="hidden" name="total_bayar" id="total_bayar">
                </div>

                <div class="mb-3">
                    <label for="status_laundry" class="form-label">Status Laundry</label>
                    <select name="status_laundry" id="status_laundry" class="form-select" required>
                        <option value="Menunggu">Menunggu</option>
                        <option value="Diproses">Diproses</option>
                        <option value="Selesai">Selesai</option>
                    </select>
                </div>

                <div class="mb-3">
                    <label for="status_piutang" class="form-label">Status Piutang</label>
                    <select name="status_piutang" id="status_piutang" class="form-select" required>
                        <option value="Belum Lunas">Belum Lunas</option>
                        <option value="Lunas">Lunas</option>
                    </select>
                </div>

                <button type="submit" class="btn btn-primary">Simpan Pesanan</button>
                <a href="<?= $baseUrl ?>/pages/admin/data_pesanan.php" class="btn btn-secondary">Batal</a>
            </form>
        </div>
    </div>
</main>

<?php include __DIR__ . '/../../includes/footer.php'; ?>

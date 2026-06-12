<?php
require_once __DIR__ . '/../../includes/auth.php';
checkRole('pelanggan');

$baseUrl = '/aulaundry';
$pageTitle = 'Buat Pesanan';

$id_pelanggan = $_SESSION['id_pelanggan'] ?? 0;

// Handle form submission
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $jenis_layanan = $_POST['jenis_layanan'] ?? '';
    $berat_kg      = $_POST['berat_kg'] ?? '';
    $jenis_waktu   = $_POST['jenis_waktu'] ?? '';
    $total_bayar   = $_POST['total_bayar'] ?? '';
    $metode_bayar  = $_POST['metode_bayar'] ?? '';

    if (empty($jenis_layanan) || empty($berat_kg) || empty($jenis_waktu) || empty($total_bayar) || empty($metode_bayar)) {
        $_SESSION['flash'] = ['type' => 'danger', 'message' => 'Semua field wajib diisi!'];
    } else {
        $no_pesanan = 'AUL' . time();

        $stmt = db()->prepare("INSERT INTO pesanan (no_pesanan, id_pelanggan, jenis_layanan, berat_kg, jenis_waktu, total_bayar, metode_bayar, status_laundry, status_piutang, tgl_masuk, created_at, updated_at) VALUES (?, ?, ?, ?, ?, ?, ?, 'Menunggu', 'Belum Lunas', NOW(), NOW(), NOW())");
        $stmt->execute([$no_pesanan, $id_pelanggan, $jenis_layanan, $berat_kg, $jenis_waktu, $total_bayar, $metode_bayar]);

        $_SESSION['flash'] = ['type' => 'success', 'message' => 'Pesanan berhasil dibuat!'];
        header('Location: ' . $baseUrl . '/pages/pelanggan/riwayat_pesanan.php');
        exit;
    }
}

// Daftar layanan dan harga
$daftarLayanan = [
    'Lengkap' => 12000,
    'Setrika' => 5000,
    'Cuci Kering' => 8000,
    'Cuci Basah' => 7000,
    'Jas Lengkap' => 25000,
    'Jas Atasan' => 18000,
    'Sepatu Besar' => 15000,
    'Sepatu Anak-anak' => 10000,
    'Bed Cover' => 20000,
    'Bantal Guling Besar' => 12000,
    'Bantal Guling Kecil' => 8000,
    'Sprei/Selimut' => 10000,
    'Karpet Tebal' => 25000,
    'Karpet Tipis' => 15000,
    'Helm' => 15000,
];

$daftarWaktu = [
    'Ekspres' => 'Ekspres (3 jam)',
    'Cepat' => 'Cepat (6 jam)',
    'Reguler' => 'Reguler (1 hari)',
    'Hemat' => 'Hemat (3 hari)',
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
        <h2 class="mb-1">Buat Pesanan</h2>
        <p class="text-muted">Buat pesanan laundry baru.</p>

        <?php if (isset($_SESSION['flash'])): ?>
            <div class="alert alert-<?= $_SESSION['flash']['type'] ?> alert-dismissible fade show">
                <?= $_SESSION['flash']['message'] ?>
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
            <?php unset($_SESSION['flash']); ?>
        <?php endif; ?>

        <div class="card p-4">
            <form method="POST">
                <div class="mb-3">
                    <label for="jenis_layanan" class="form-label">Jenis Layanan</label>
                    <select name="jenis_layanan" id="jenis_layanan" class="form-select" required>
                        <option value="">-- Pilih Layanan --</option>
                        <?php foreach ($daftarLayanan as $nama => $harga): ?>
                            <option value="<?= $nama ?>" data-harga="<?= $harga ?>"><?= $nama ?> (Rp <?= number_format($harga, 0, ',', '.') ?>/kg)</option>
                        <?php endforeach; ?>
                    </select>
                </div>

                <div class="mb-3">
                    <label for="jenis_waktu" class="form-label">Jenis Waktu</label>
                    <select name="jenis_waktu" id="jenis_waktu" class="form-select" required>
                        <option value="">-- Pilih Waktu --</option>
                        <?php foreach ($daftarWaktu as $key => $label): ?>
                            <option value="<?= $key ?>"><?= $label ?></option>
                        <?php endforeach; ?>
                    </select>
                </div>

                <div class="mb-3">
                    <label for="berat_kg" class="form-label">Berat (kg)</label>
                    <input type="number" step="0.1" min="0.1" name="berat_kg" id="berat_kg" class="form-control" required>
                </div>

                <div class="mb-3">
                    <label for="metode_bayar" class="form-label">Metode Bayar</label>
                    <select name="metode_bayar" id="metode_bayar" class="form-select" required>
                        <option value="">-- Pilih Metode --</option>
                        <option value="Cash">Cash</option>
                        <option value="E-Wallet">E-Wallet</option>
                    </select>
                </div>

                <div class="mb-3">
                    <label for="total_display" class="form-label">Total Bayar</label>
                    <input type="text" id="total_display" class="form-control" readonly value="Rp 0">
                    <input type="hidden" name="total_bayar" id="total_bayar" value="0">
                </div>

                <button type="submit" class="btn btn-primary">Kirim Pesanan</button>
                <a href="<?= $baseUrl ?>/pages/pelanggan/dashboard.php" class="btn btn-secondary">Batal</a>
            </form>
        </div>
    </div>
</main>

<script>
const hargaLayanan = <?= json_encode($daftarLayanan) ?>;

function hitungTotal() {
    const layanan = document.getElementById('jenis_layanan').value;
    const berat = parseFloat(document.getElementById('berat_kg').value) || 0;
    let total = 0;
    if (layanan && berat > 0) {
        total = hargaLayanan[layanan] * berat;
    }
    document.getElementById('total_bayar').value = total;
    document.getElementById('total_display').value = 'Rp ' + total.toLocaleString('id-ID');
}

document.getElementById('jenis_layanan').addEventListener('change', hitungTotal);
document.getElementById('berat_kg').addEventListener('input', hitungTotal);
</script>

<?php include __DIR__ . '/../../includes/footer.php'; ?>

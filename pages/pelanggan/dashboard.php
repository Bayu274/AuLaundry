<?php
require_once __DIR__ . '/../../includes/auth.php';
checkRole('pelanggan');

$baseUrl = '/aulaundry';
$pageTitle = 'Dashboard Pelanggan';

// Ambil ID pelanggan dari session (format: $_SESSION['id_pelanggan'])
$id_pelanggan = $_SESSION['id_pelanggan'] ?? 0;
$nama_pelanggan = $_SESSION['nama'] ?? 'Pelanggan';

// Ambil data pesanan pelanggan
$stmt = db()->prepare("SELECT * FROM pesanan WHERE id_pelanggan = ? ORDER BY created_at DESC");
$stmt->execute([$id_pelanggan]);
$pesanan = $stmt->fetchAll();

// Statistik
$totalPesanan = count($pesanan);
$pesananProses = count(array_filter($pesanan, fn($p) => $p['status_laundry'] === 'Diproses'));
$pesananSelesai = count(array_filter($pesanan, fn($p) => $p['status_laundry'] === 'Selesai'));
$pesananMenunggu = count(array_filter($pesanan, fn($p) => $p['status_laundry'] === 'Menunggu'));

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
        <h2 class="mb-1">Selamat Datang, <?= htmlspecialchars($nama_pelanggan) ?>!</h2>
        <p class="text-muted">Berikut ringkasan pesanan Anda.</p>

        <!-- FLASH MESSAGE -->
        <?php if (isset($_SESSION['flash'])): ?>
            <div class="alert alert-<?= $_SESSION['flash']['type'] ?> alert-dismissible fade show">
                <?= $_SESSION['flash']['message'] ?>
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
            <?php unset($_SESSION['flash']); ?>
        <?php endif; ?>

        <!-- STATISTIK CARDS -->
        <div class="row mb-4">
            <div class="col-md-3 mb-3">
                <div class="card border-0 shadow-sm">
                    <div class="card-body text-center">
                        <h3 class="text-primary"><?= $totalPesanan ?></h3>
                        <small class="text-muted">Total Pesanan</small>
                    </div>
                </div>
            </div>
            <div class="col-md-3 mb-3">
                <div class="card border-0 shadow-sm">
                    <div class="card-body text-center">
                        <h3 class="text-secondary"><?= $pesananMenunggu ?></h3>
                        <small class="text-muted">Menunggu</small>
                    </div>
                </div>
            </div>
            <div class="col-md-3 mb-3">
                <div class="card border-0 shadow-sm">
                    <div class="card-body text-center">
                        <h3 class="text-info"><?= $pesananProses ?></h3>
                        <small class="text-muted">Diproses</small>
                    </div>
                </div>
            </div>
            <div class="col-md-3 mb-3">
                <div class="card border-0 shadow-sm">
                    <div class="card-body text-center">
                        <h3 class="text-success"><?= $pesananSelesai ?></h3>
                        <small class="text-muted">Selesai</small>
                    </div>
                </div>
            </div>
        </div>

        <!-- TABEL PESANAN -->
        <h5 class="mb-3">Riwayat Pesanan</h5>
        <div class="table-responsive">
            <table class="table table-bordered table-hover align-middle">
                <thead class="table-dark">
                    <tr>
                        <th>No</th>
                        <th>No Pesanan</th>
                        <th>Jenis Layanan</th>
                        <th>Jenis Waktu</th>
                        <th>Berat (kg)</th>
                        <th>Total Bayar</th>
                        <th>Status Laundry</th>
                        <th>Status Piutang</th>
                        <th>Tgl Masuk</th>
                        <th>Tgl Selesai</th>
                        <th>Diambil</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if (count($pesanan) > 0): ?>
                        <?php $no = 1; foreach ($pesanan as $row): ?>
                            <tr>
                                <td><?= $no++ ?></td>
                                <td><?= htmlspecialchars($row['no_pesanan']) ?></td>
                                <td><?= htmlspecialchars($row['jenis_layanan']) ?></td>
                                <td><?= htmlspecialchars($row['jenis_waktu'] ?? '-') ?></td>
                                <td><?= htmlspecialchars($row['berat_kg']) ?></td>
                                <td>Rp <?= number_format($row['total_bayar'], 0, ',', '.') ?></td>
                                <td>
                                    <?php
                                    $badgeClass = match($row['status_laundry']) {
                                        'Selesai'   => 'bg-success',
                                        'Diproses'  => 'bg-info',
                                        'Menunggu'  => 'bg-secondary',
                                        default     => 'bg-secondary'
                                    };
                                    ?>
                                    <span class="badge <?= $badgeClass ?>"><?= htmlspecialchars($row['status_laundry']) ?></span>
                                </td>
                                <td>
                                    <?php
                                    $piutangClass = ($row['status_piutang'] === 'Lunas') ? 'bg-success' : 'bg-danger';
                                    ?>
                                    <span class="badge <?= $piutangClass ?>"><?= htmlspecialchars($row['status_piutang']) ?></span>
                                </td>
                                <td><?= date('d/m/Y', strtotime($row['tgl_masuk'])) ?></td>
                                <td><?= $row['tgl_selesai'] ? date('d/m/Y', strtotime($row['tgl_selesai'])) : '-' ?></td>
                                <td>
                                    <?php if ($row['pesanan_diambil']): ?>
                                        <span class="badge bg-success">Sudah</span>
                                    <?php else: ?>
                                        <span class="badge bg-warning text-dark">Belum</span>
                                    <?php endif; ?>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    <?php else: ?>
                        <tr>
                            <td colspan="11" class="text-center text-muted">Belum ada pesanan.</td>
                        </tr>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
    </div>
</main>

<?php include __DIR__ . '/../../includes/footer.php'; ?>

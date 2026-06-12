<?php
require_once __DIR__ . '/../../includes/auth.php';
checkRole('pelanggan');

$baseUrl = '/aulaundry';
$pageTitle = 'Riwayat Pesanan';

$id_pelanggan = $_SESSION['id_pelanggan'] ?? 0;

$stmt = db()->prepare("SELECT * FROM pesanan WHERE id_pelanggan = ? ORDER BY created_at DESC");
$stmt->execute([$id_pelanggan]);
$pesanan = $stmt->fetchAll();

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
        <h2 class="mb-1">Riwayat Pesanan</h2>
        <p class="text-muted">Semua pesanan laundry Anda.</p>

        <?php if (isset($_SESSION['flash'])): ?>
            <div class="alert alert-<?= $_SESSION['flash']['type'] ?> alert-dismissible fade show">
                <?= $_SESSION['flash']['message'] ?>
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
            <?php unset($_SESSION['flash']); ?>
        <?php endif; ?>

        <div class="table-responsive">
            <table class="table table-bordered table-hover align-middle">
                <thead class="table-dark">
                    <tr>
                        <th>No</th>
                        <th>No Pesanan</th>
                        <th>Layanan</th>
                        <th>Waktu</th>
                        <th>Berat</th>
                        <th>Total</th>
                        <th>Status Laundry</th>
                        <th>Status Bayar</th>
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
                                <td><?= $row['berat_kg'] ?> kg</td>
                                <td>Rp <?= number_format($row['total_bayar'], 0, ',', '.') ?></td>
                                <td>
                                    <?php
                                    $badgeClass = match($row['status_laundry']) {
                                        'Selesai'  => 'bg-success',
                                        'Diproses' => 'bg-info',
                                        'Menunggu' => 'bg-secondary',
                                        default    => 'bg-secondary'
                                    };
                                    ?>
                                    <span class="badge <?= $badgeClass ?>"><?= htmlspecialchars($row['status_laundry']) ?></span>
                                </td>
                                <td>
                                    <?php $piutangClass = ($row['status_piutang'] === 'Lunas') ? 'bg-success' : 'bg-danger'; ?>
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
                        <tr><td colspan="11" class="text-center text-muted">Belum ada pesanan.</td></tr>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
    </div>
</main>

<?php include __DIR__ . '/../../includes/footer.php'; ?>

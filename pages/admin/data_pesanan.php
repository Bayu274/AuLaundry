<?php
require_once __DIR__ . '/../../includes/auth.php';
checkRole('admin');

$baseUrl = '/aulaundry';

// ============================
// QUERY DATA PESANAN
// ============================
$pdo = db();

// Pencarian
$search = $_GET['search'] ?? '';
$searchQuery = '';
$params = [];

if (!empty($search)) {
    $searchQuery = "WHERE p.no_pesanan LIKE :search 
                    OR pel.nama_pelanggan LIKE :search 
                    OR p.jenis_layanan LIKE :search 
                    OR p.status_laundry LIKE :search";
    $params['search'] = "%{$search}%";
}

$sql = "SELECT p.*, pel.nama_pelanggan 
        FROM pesanan p 
        LEFT JOIN pelanggan pel ON p.id_pelanggan = pel.id_pelanggan 
        {$searchQuery} 
        ORDER BY p.created_at DESC";

$stmt = $pdo->prepare($sql);
$stmt->execute($params);
$pesanan = $stmt->fetchAll();

// Include header & sidebar
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
        <h2 class="mb-4">Data Pesanan</h2>

        <!-- SEARCH & TOMBOL TAMBAH -->
        <div class="d-flex justify-content-between align-items-center mb-3 flex-wrap gap-2">
            <form method="GET" class="d-flex gap-2">
                <input type="text" name="search" class="form-control" placeholder="Cari pesanan..." value="<?= htmlspecialchars($search) ?>">
                <button type="submit" class="btn btn-primary">Cari</button>
            </form>
            <a href="<?= $baseUrl ?>/pages/admin/tambah_pesanan.php" class="btn btn-success">
                <i class="fas fa-plus"></i> Tambah Pesanan
            </a>
        </div>

        <!-- FLASH MESSAGE -->
        <?php if (isset($_SESSION['flash'])): ?>
            <div class="alert alert-<?= $_SESSION['flash']['type'] ?> alert-dismissible fade show">
                <?= $_SESSION['flash']['message'] ?>
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
            <?php unset($_SESSION['flash']); ?>
        <?php endif; ?>

        <!-- TABEL PESANAN -->
        <div class="table-responsive">
            <table class="table table-bordered table-hover align-middle">
                <thead class="table-dark">
                    <tr>
                        <th>No</th>
                        <th>No Pesanan</th>
                        <th>Pelanggan</th>
                        <th>Jenis Layanan</th>
                        <th>Jenis Waktu</th>
                        <th>Berat (kg)</th>
                        <th>Total Bayar</th>
                        <th>Status Laundry</th>
                        <th>Status Piutang</th>
                        <th>Tgl Selesai</th>
                        <th>Diambil</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if (count($pesanan) > 0): ?>
                        <?php $no = 1; foreach ($pesanan as $row): ?>
                            <tr>
                                <td><?= $no++ ?></td>
                                <td><?= htmlspecialchars($row['no_pesanan']) ?></td>
                                <td><?= htmlspecialchars($row['nama_pelanggan'] ?? '-') ?></td>
                                <td><?= htmlspecialchars($row['jenis_layanan']) ?></td>
                                <td><?= htmlspecialchars($row['jenis_waktu'] ?? '-') ?></td>
                                <td><?= htmlspecialchars($row['berat_kg']) ?></td>
                                <td>Rp <?= number_format($row['total_bayar'], 0, ',', '.') ?></td>
                                <td>
                                    <?php
                                    $statusLaundry = strtolower($row['status_laundry']);
                                    $badgeClass = match($statusLaundry) {
                                        'selesai'   => 'bg-success',
                                        'proses'    => 'bg-info',
                                        'menunggu'  => 'bg-secondary',
                                        default     => 'bg-secondary'
                                    };
                                    ?>
                                    <span class="badge <?= $badgeClass ?>"><?= htmlspecialchars($row['status_laundry']) ?></span>
                                </td>
                                <td>
                                    <?php
                                    $statusPiutang = strtolower($row['status_piutang']);
                                    $piutangClass = ($statusPiutang === 'lunas') ? 'bg-success' : 'bg-danger';
                                    ?>
                                    <span class="badge <?= $piutangClass ?>"><?= htmlspecialchars($row['status_piutang']) ?></span>
                                </td>
                                <td><?= $row['tgl_selesai'] ? date('d/m/Y', strtotime($row['tgl_selesai'])) : '-' ?></td>
                                <td><?= htmlspecialchars($row['pesanan_diambil'] ?? '-') ?></td>
                                <td>
                                    <a href="<?= $baseUrl ?>/pages/admin/edit_pesanan.php?id=<?= $row['id_pesanan'] ?>" class="btn btn-sm btn-warning" title="Edit">
                                        <i class="fas fa-edit"></i>
                                    </a>
                                    <a href="<?= $baseUrl ?>/actions/pesanan/hapus.php?id=<?= $row['id_pesanan'] ?>" class="btn btn-sm btn-danger" title="Hapus" onclick="return confirm('Yakin ingin menghapus pesanan ini?')">
                                        <i class="fas fa-trash"></i>
                                    </a>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    <?php else: ?>
                        <tr>
                            <td colspan="12" class="text-center text-muted">Belum ada data pesanan.</td>
                        </tr>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
    </div>
</main>

<?php include __DIR__ . '/../../includes/footer.php'; ?>

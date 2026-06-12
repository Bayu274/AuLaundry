<?php
require_once __DIR__ . '/../../includes/auth.php';
checkRole('admin');

$baseUrl = '/aulaundry';
$pageTitle = 'Data Kurir';

// Ambil data kurir dari database
$kurir = db()->query("SELECT * FROM kurir ORDER BY nama_kurir ASC")->fetchAll();

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
        <h2 class="mb-1">Data Kurir</h2>
        <p class="text-muted">Kelola data kurir AuLaundry.</p>

        <!-- FLASH MESSAGE -->
        <?php if (isset($_SESSION['flash'])): ?>
            <div class="alert alert-<?= $_SESSION['flash']['type'] ?> alert-dismissible fade show">
                <?= $_SESSION['flash']['message'] ?>
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
            <?php unset($_SESSION['flash']); ?>
        <?php endif; ?>

        <!-- SEARCH & TOMBOL TAMBAH -->
        <div class="d-flex justify-content-between align-items-center mb-3 flex-wrap gap-2">
            <div class="search-box">
                <input type="text" id="searchTable" class="form-control" placeholder="Cari kurir...">
            </div>
            <a href="<?= $baseUrl ?>/pages/admin/tambah_kurir.php" class="btn btn-primary btn-sm">
                <i class="fa-solid fa-plus me-1"></i> Tambah Kurir
            </a>
        </div>

        <!-- TABEL KURIR -->
        <div class="table-responsive">
            <table class="table table-bordered table-striped table-hover align-middle">
                <thead class="table-dark">
                    <tr>
                        <th>No</th>
                        <th>Nama Kurir</th>
                        <th>No. HP</th>
                        <th>Alamat</th>
                        <th>Username</th>
                        <th>Status</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if (empty($kurir)): ?>
                        <tr><td colspan="7" class="text-center text-muted">Belum ada data kurir.</td></tr>
                    <?php else: ?>
                        <?php foreach ($kurir as $i => $k): ?>
                            <tr>
                                <td><?= $i + 1 ?></td>
                                <td><?= htmlspecialchars($k['nama_kurir']) ?></td>
                                <td><?= htmlspecialchars($k['no_hp']) ?></td>
                                <td><?= htmlspecialchars($k['alamat'] ?? '-') ?></td>
                                <td><code><?= htmlspecialchars($k['username']) ?></code></td>
                                <td>
                                    <?php
                                    $statusClass = (strtolower($k['status_aktif']) === 'aktif') ? 'bg-success' : 'bg-secondary';
                                    ?>
                                    <span class="badge <?= $statusClass ?>"><?= htmlspecialchars($k['status_aktif']) ?></span>
                                </td>
                                <td>
                                    <a href="<?= $baseUrl ?>/pages/admin/edit_kurir.php?id=<?= $k['id_kurir'] ?>" class="btn btn-sm btn-warning" title="Edit">
                                        <i class="fa-solid fa-pen-to-square"></i>
                                    </a>
                                    <a href="<?= $baseUrl ?>/actions/kurir/hapus.php?id=<?= $k['id_kurir'] ?>" class="btn btn-sm btn-danger" title="Hapus" onclick="return confirm('Hapus kurir <?= htmlspecialchars($k['nama_kurir']) ?>?')">
                                        <i class="fa-solid fa-trash"></i>
                                    </a>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
    </div>
</main>

<?php include __DIR__ . '/../../includes/footer.php'; ?>

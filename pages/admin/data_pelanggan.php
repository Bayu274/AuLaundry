<?php
require_once __DIR__ . '/../../includes/auth.php';
checkRole('admin');

$baseUrl = '/aulaundry';

$pageTitle = 'Data Pelanggan';

// Ambil data pelanggan dari database
$pelanggan = db()->query("SELECT * FROM pelanggan ORDER BY nama_pelanggan ASC")->fetchAll();

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
        <h2 class="mb-1">Data Pelanggan</h2>
        <p class="text-muted">Kelola data pelanggan AuLaundry.</p>

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
                <input type="text" id="searchTable" class="form-control" placeholder="Cari pelanggan...">
            </div>
            <a href="<?= $baseUrl ?>/pages/admin/tambah_pelanggan.php" class="btn btn-primary btn-sm">
                <i class="fa-solid fa-plus me-1"></i> Tambah Pelanggan
            </a>
        </div>

        <!-- TABEL PELANGGAN -->
        <div class="table-responsive">
            <table class="table table-bordered table-striped table-hover align-middle">
                <thead class="table-dark">
                    <tr>
                        <th>No</th>
                        <th>Nama</th>
                        <th>Alamat</th>
                        <th>No. HP</th>
                        <th>Username</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if (empty($pelanggan)): ?>
                        <tr>
                            <td colspan="6" class="text-center text-muted">Belum ada data pelanggan.</td>
                        </tr>
                    <?php else: ?>
                        <?php foreach ($pelanggan as $i => $p): ?>
                            <tr>
                                <td><?= $i + 1 ?></td>
                                <td><?= htmlspecialchars($p['nama_pelanggan']) ?></td>
                                <td><?= htmlspecialchars($p['alamat']) ?></td>
                                <td><?= htmlspecialchars($p['no_hp']) ?></td>
                                <td><code><?= htmlspecialchars($p['username']) ?></code></td>
                                <td>
                                    <a href="<?= $baseUrl ?>/pages/admin/edit_pelanggan.php?id=<?= $p['id_pelanggan'] ?>" class="btn btn-sm btn-warning" title="Edit">
                                        <i class="fa-solid fa-pen-to-square"></i>
                                    </a>
                                    <a href="<?= $baseUrl ?>/actions/pelanggan/hapus.php?id=<?= $p['id_pelanggan'] ?>" class="btn btn-sm btn-danger" title="Hapus" onclick="return confirm('Hapus pelanggan <?= htmlspecialchars($p['nama_pelanggan']) ?>?')">
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

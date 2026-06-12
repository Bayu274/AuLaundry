<?php
require_once __DIR__ . '/../../includes/auth.php';
checkRole('admin');

$baseUrl = '/aulaundry';
$pageTitle = 'Data Admin';

$admins = db()->query("SELECT * FROM admin ORDER BY nama_admin ASC")->fetchAll();

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
        <h2 class="mb-1">Data Admin</h2>
        <p class="text-muted">Kelola data admin sistem.</p>

        <!-- FLASH MESSAGE -->
        <?php if (isset($_SESSION['flash'])): ?>
            <div class="alert alert-<?= $_SESSION['flash']['type'] ?> alert-dismissible fade show">
                <?= $_SESSION['flash']['message'] ?>
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
            <?php unset($_SESSION['flash']); ?>
        <?php endif; ?>

        <!-- TOMBOL TAMBAH -->
        <div class="d-flex justify-content-between align-items-center mb-3">
            <a href="<?= $baseUrl ?>/pages/admin/tambah_admin.php" class="btn btn-primary btn-sm">
                <i class="fa-solid fa-plus me-1"></i> Tambah Admin
            </a>
        </div>

        <!-- TABEL ADMIN -->
        <div class="table-responsive">
            <table class="table table-bordered table-striped table-hover align-middle">
                <thead class="table-dark">
                    <tr>
                        <th>No</th>
                        <th>Nama Admin</th>
                        <th>Username</th>
                        <th>Level</th>
                        <th>Dibuat</th>
                        <th>Diupdate</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if (empty($admins)): ?>
                        <tr><td colspan="7" class="text-center text-muted">Belum ada data admin.</td></tr>
                    <?php else: ?>
                        <?php foreach ($admins as $i => $admin): ?>
                            <tr>
                                <td><?= $i + 1 ?></td>
                                <td><?= htmlspecialchars($admin['nama_admin']) ?></td>
                                <td><code><?= htmlspecialchars($admin['username']) ?></code></td>
                                <td><?= htmlspecialchars($admin['level']) ?></td>
                                <td><?= date('d M Y', strtotime($admin['created_at'])) ?></td>
                                <td><?= date('d M Y', strtotime($admin['updated_at'])) ?></td>
                                <td>
                                    <a href="<?= $baseUrl ?>/pages/admin/edit_admin.php?id=<?= $admin['id_admin'] ?>" class="btn btn-sm btn-warning" title="Edit">
                                        <i class="fa-solid fa-pen-to-square"></i>
                                    </a>
                                    <?php if ($admin['id_admin'] !== 1): ?>
                                        <a href="<?= $baseUrl ?>/actions/admin/hapus.php?id=<?= $admin['id_admin'] ?>" class="btn btn-sm btn-danger" title="Hapus" onclick="return confirm('Hapus admin <?= htmlspecialchars($admin['nama_admin']) ?>?')">
                                            <i class="fa-solid fa-trash"></i>
                                        </a>
                                    <?php else: ?>
                                        <button class="btn btn-sm btn-secondary" disabled title="Tidak bisa dihapus">
                                            <i class="fa-solid fa-lock"></i>
                                        </button>
                                    <?php endif; ?>
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

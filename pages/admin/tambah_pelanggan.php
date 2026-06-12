<?php
require_once __DIR__ . '/../../includes/auth.php';
checkRole('admin');

$baseUrl = '/aulaundry';
$pageTitle = 'Tambah Pelanggan';

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
        <h2 class="mb-1">Tambah Pelanggan</h2>
        <p class="text-muted">Masukkan data pelanggan baru.</p>

        <!-- FLASH MESSAGE -->
        <?php if (isset($_SESSION['flash'])): ?>
            <div class="alert alert-<?= $_SESSION['flash']['type'] ?> alert-dismissible fade show">
                <?= $_SESSION['flash']['message'] ?>
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
            <?php unset($_SESSION['flash']); ?>
        <?php endif; ?>

        <div class="card p-4">
            <form action="<?= $baseUrl ?>/actions/pelanggan/tambah.php" method="POST">
                <div class="mb-3">
                    <label for="nama_pelanggan" class="form-label">Nama Lengkap</label>
                    <input type="text" name="nama_pelanggan" id="nama_pelanggan" class="form-control" required>
                </div>
                <div class="mb-3">
                    <label for="alamat" class="form-label">Alamat</label>
                    <textarea name="alamat" id="alamat" class="form-control" rows="3" required></textarea>
                </div>
                <div class="mb-3">
                    <label for="no_hp" class="form-label">No. HP</label>
                    <input type="tel" name="no_hp" id="no_hp" class="form-control" required>
                </div>
                <div class="mb-3">
                    <label for="username" class="form-label">Username</label>
                    <input type="text" name="username" id="username" class="form-control" required>
                </div>
                <div class="mb-3">
                    <label for="password" class="form-label">Password</label>
                    <input type="password" name="password" id="password" class="form-control" required>
                </div>
                <button type="submit" class="btn btn-primary">Simpan</button>
                <a href="<?= $baseUrl ?>/pages/admin/data_pelanggan.php" class="btn btn-secondary">Batal</a>
            </form>
        </div>
    </div>
</main>

<?php include __DIR__ . '/../../includes/footer.php'; ?>

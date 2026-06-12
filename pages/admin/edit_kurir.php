<?php
require_once __DIR__ . '/../../includes/auth.php';
checkRole('admin');

$baseUrl = '/aulaundry';

$id = (int)($_GET['id'] ?? 0);
if (!$id) {
    $_SESSION['flash'] = ['type' => 'danger', 'message' => 'ID kurir tidak valid.'];
    header('Location: ' . $baseUrl . '/pages/admin/data_kurir.php');
    exit;
}

$stmt = db()->prepare("SELECT * FROM kurir WHERE id_kurir = ?");
$stmt->execute([$id]);
$kurir = $stmt->fetch();

if (!$kurir) {
    $_SESSION['flash'] = ['type' => 'danger', 'message' => 'Kurir tidak ditemukan.'];
    header('Location: ' . $baseUrl . '/pages/admin/data_kurir.php');
    exit;
}

$pageTitle = 'Edit Kurir';

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
        <h2 class="mb-1">Edit Kurir</h2>
        <p class="text-muted">Perbarui data kurir.</p>

        <?php if (isset($_SESSION['flash'])): ?>
            <div class="alert alert-<?= $_SESSION['flash']['type'] ?> alert-dismissible fade show">
                <?= $_SESSION['flash']['message'] ?>
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
            <?php unset($_SESSION['flash']); ?>
        <?php endif; ?>

        <div class="card p-4">
            <form action="<?= $baseUrl ?>/actions/kurir/edit.php" method="POST">
                <input type="hidden" name="id_kurir" value="<?= $kurir['id_kurir'] ?>">
                <div class="mb-3">
                    <label for="nama_kurir" class="form-label">Nama Kurir</label>
                    <input type="text" name="nama_kurir" id="nama_kurir" class="form-control" value="<?= htmlspecialchars($kurir['nama_kurir']) ?>" required>
                </div>
                <div class="mb-3">
                    <label for="no_hp" class="form-label">No. HP</label>
                    <input type="tel" name="no_hp" id="no_hp" class="form-control" value="<?= htmlspecialchars($kurir['no_hp']) ?>" required>
                </div>
                <div class="mb-3">
                    <label for="alamat" class="form-label">Alamat</label>
                    <textarea name="alamat" id="alamat" class="form-control" rows="3" required><?= htmlspecialchars($kurir['alamat'] ?? '') ?></textarea>
                </div>
                <div class="mb-3">
                    <label for="username" class="form-label">Username</label>
                    <input type="text" name="username" id="username" class="form-control" value="<?= htmlspecialchars($kurir['username']) ?>" required>
                </div>
                <div class="mb-3">
                    <label for="password" class="form-label">Password <small class="text-muted">(Kosongkan jika tidak diubah)</small></label>
                    <input type="password" name="password" id="password" class="form-control">
                </div>
                <div class="mb-3">
                    <label for="status_aktif" class="form-label">Status</label>
                    <select name="status_aktif" id="status_aktif" class="form-select" required>
                        <option value="Aktif" <?= $kurir['status_aktif'] === 'Aktif' ? 'selected' : '' ?>>Aktif</option>
                        <option value="Tidak Aktif" <?= $kurir['status_aktif'] === 'Tidak Aktif' ? 'selected' : '' ?>>Tidak Aktif</option>
                    </select>
                </div>
                <button type="submit" class="btn btn-primary">Simpan Perubahan</button>
                <a href="<?= $baseUrl ?>/pages/admin/data_kurir.php" class="btn btn-secondary">Batal</a>
            </form>
        </div>
    </div>
</main>

<?php include __DIR__ . '/../../includes/footer.php'; ?>

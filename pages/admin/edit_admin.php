<?php
require_once __DIR__ . '/../../includes/auth.php';
checkRole('admin');

$baseUrl = '/aulaundry';

$id = (int)($_GET['id'] ?? 0);
if (!$id) {
    $_SESSION['flash'] = ['type' => 'danger', 'message' => 'ID admin tidak valid.'];
    header('Location: ' . $baseUrl . '/pages/admin/data_admin.php');
    exit;
}

$stmt = db()->prepare("SELECT * FROM admin WHERE id_admin = ?");
$stmt->execute([$id]);
$admin = $stmt->fetch();

if (!$admin) {
    $_SESSION['flash'] = ['type' => 'danger', 'message' => 'Admin tidak ditemukan.'];
    header('Location: ' . $baseUrl . '/pages/admin/data_admin.php');
    exit;
}

$pageTitle = 'Edit Admin';
$levels = ['owner', 'admin', 'superadmin'];

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
        <h2 class="mb-1">Edit Admin</h2>
        <p class="text-muted">Perbarui data admin.</p>

        <?php if (isset($_SESSION['flash'])): ?>
            <div class="alert alert-<?= $_SESSION['flash']['type'] ?> alert-dismissible fade show">
                <?= $_SESSION['flash']['message'] ?>
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
            <?php unset($_SESSION['flash']); ?>
        <?php endif; ?>

        <div class="card p-4">
            <form action="<?= $baseUrl ?>/actions/admin/edit.php" method="POST">
                <input type="hidden" name="id_admin" value="<?= $admin['id_admin'] ?>">
                <div class="mb-3">
                    <label for="nama_admin" class="form-label">Nama Admin</label>
                    <input type="text" name="nama_admin" id="nama_admin" class="form-control" value="<?= htmlspecialchars($admin['nama_admin']) ?>" required>
                </div>
                <div class="mb-3">
                    <label for="username" class="form-label">Username</label>
                    <input type="text" name="username" id="username" class="form-control" value="<?= htmlspecialchars($admin['username']) ?>" required>
                </div>
                <div class="mb-3">
                    <label for="password" class="form-label">Password <small class="text-muted">(Kosongkan jika tidak diubah)</small></label>
                    <input type="password" name="password" id="password" class="form-control">
                </div>
                <div class="mb-3">
                    <label for="level" class="form-label">Level</label>
                    <select name="level" id="level" class="form-select" required>
                        <?php foreach ($levels as $level): ?>
                            <option value="<?= $level ?>" <?= $admin['level'] === $level ? 'selected' : '' ?>><?= ucfirst($level) ?></option>
                        <?php endforeach; ?>
                    </select>
                </div>
                <button type="submit" class="btn btn-primary">Simpan Perubahan</button>
                <a href="<?= $baseUrl ?>/pages/admin/data_admin.php" class="btn btn-secondary">Batal</a>
            </form>
        </div>
    </div>
</main>

<?php include __DIR__ . '/../../includes/footer.php'; ?>

<?php
require_once __DIR__ . '/../../includes/auth.php';
checkRole('admin');

$baseUrl = '/aulaundry';

$id = (int)($_GET['id'] ?? 0);
if (!$id) {
    $_SESSION['flash'] = ['type' => 'danger', 'message' => 'ID karyawan tidak valid.'];
    header('Location: ' . $baseUrl . '/pages/admin/data_karyawan.php');
    exit;
}

$stmt = db()->prepare("SELECT * FROM karyawan WHERE id_karyawan = ?");
$stmt->execute([$id]);
$karyawan = $stmt->fetch();

if (!$karyawan) {
    $_SESSION['flash'] = ['type' => 'danger', 'message' => 'Karyawan tidak ditemukan.'];
    header('Location: ' . $baseUrl . '/pages/admin/data_karyawan.php');
    exit;
}

$pageTitle = 'Edit Karyawan';
$daftarPosisi = ['Staff', 'Kasir', 'Pencuci', 'Setrika', 'Packing', 'Supervisor', 'Manager'];

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
        <h2 class="mb-1">Edit Karyawan</h2>
        <p class="text-muted">Perbarui data karyawan.</p>

        <?php if (isset($_SESSION['flash'])): ?>
            <div class="alert alert-<?= $_SESSION['flash']['type'] ?> alert-dismissible fade show">
                <?= $_SESSION['flash']['message'] ?>
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
            <?php unset($_SESSION['flash']); ?>
        <?php endif; ?>

        <div class="card p-4">
            <form action="<?= $baseUrl ?>/actions/karyawan/edit.php" method="POST">
                <input type="hidden" name="id_karyawan" value="<?= $karyawan['id_karyawan'] ?>">
                <div class="mb-3">
                    <label for="nama_karyawan" class="form-label">Nama Karyawan</label>
                    <input type="text" name="nama_karyawan" id="nama_karyawan" class="form-control" value="<?= htmlspecialchars($karyawan['nama_karyawan']) ?>" required>
                </div>
                <div class="mb-3">
                    <label for="posisi" class="form-label">Posisi</label>
                    <select name="posisi" id="posisi" class="form-select" required>
                        <?php foreach ($daftarPosisi as $pos): ?>
                            <option value="<?= $pos ?>" <?= $karyawan['posisi'] === $pos ? 'selected' : '' ?>><?= $pos ?></option>
                        <?php endforeach; ?>
                    </select>
                </div>
                <div class="mb-3">
                    <label for="no_hp" class="form-label">No. HP</label>
                    <input type="tel" name="no_hp" id="no_hp" class="form-control" value="<?= htmlspecialchars($karyawan['no_hp']) ?>" required>
                </div>
                <div class="mb-3">
                    <label for="alamat" class="form-label">Alamat</label>
                    <textarea name="alamat" id="alamat" class="form-control" rows="3" required><?= htmlspecialchars($karyawan['alamat'] ?? '') ?></textarea>
                </div>
                <div class="mb-3">
                    <label for="username" class="form-label">Username <small class="text-muted">(Opsional)</small></label>
                    <input type="text" name="username" id="username" class="form-control" value="<?= htmlspecialchars($karyawan['username'] ?? '') ?>">
                </div>
                <div class="mb-3">
                    <label for="password" class="form-label">Password <small class="text-muted">(Kosongkan jika tidak diubah)</small></label>
                    <input type="password" name="password" id="password" class="form-control">
                </div>
                <div class="mb-3">
                    <label for="status_aktif" class="form-label">Status</label>
                    <select name="status_aktif" id="status_aktif" class="form-select" required>
                        <option value="Aktif" <?= $karyawan['status_aktif'] === 'Aktif' ? 'selected' : '' ?>>Aktif</option>
                        <option value="Tidak Aktif" <?= $karyawan['status_aktif'] === 'Tidak Aktif' ? 'selected' : '' ?>>Tidak Aktif</option>
                    </select>
                </div>
                <button type="submit" class="btn btn-primary">Simpan Perubahan</button>
                <a href="<?= $baseUrl ?>/pages/admin/data_karyawan.php" class="btn btn-secondary">Batal</a>
            </form>
        </div>
    </div>
</main>

<?php include __DIR__ . '/../../includes/footer.php'; ?>

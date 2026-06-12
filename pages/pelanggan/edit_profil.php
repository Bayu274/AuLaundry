<?php
require_once __DIR__ . '/../../includes/auth.php';
checkRole('pelanggan');

$baseUrl = '/aulaundry';
$pageTitle = 'Edit Profil';

$id_pelanggan = $_SESSION['id_pelanggan'] ?? 0;

$stmt = db()->prepare("SELECT * FROM pelanggan WHERE id_pelanggan = ?");
$stmt->execute([$id_pelanggan]);
$pelanggan = $stmt->fetch();

if (!$pelanggan) {
    $_SESSION['flash'] = ['type' => 'danger', 'message' => 'Data tidak ditemukan.'];
    header('Location: ' . $baseUrl . '/pages/pelanggan/dashboard.php');
    exit;
}

// Proses form
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $nama   = trim($_POST['nama_pelanggan'] ?? '');
    $alamat = trim($_POST['alamat'] ?? '');
    $no_hp  = trim($_POST['no_hp'] ?? '');
    $password = $_POST['password'] ?? '';

    if (empty($nama) || empty($alamat) || empty($no_hp)) {
        $_SESSION['flash'] = ['type' => 'danger', 'message' => 'Nama, alamat, dan no HP wajib diisi.'];
        header('Location: ' . $baseUrl . '/pages/pelanggan/edit_profil.php');
        exit;
    }

    if (!empty($password)) {
        $hashed = password_hash($password, PASSWORD_DEFAULT);
        $stmt = db()->prepare("UPDATE pelanggan SET nama_pelanggan = ?, alamat = ?, no_hp = ?, password = ?, updated_at = NOW() WHERE id_pelanggan = ?");
        $stmt->execute([$nama, $alamat, $no_hp, $hashed, $id_pelanggan]);
    } else {
        $stmt = db()->prepare("UPDATE pelanggan SET nama_pelanggan = ?, alamat = ?, no_hp = ?, updated_at = NOW() WHERE id_pelanggan = ?");
        $stmt->execute([$nama, $alamat, $no_hp, $id_pelanggan]);
    }

    $_SESSION['nama'] = $nama;
    $_SESSION['flash'] = ['type' => 'success', 'message' => 'Profil berhasil diperbarui.'];
    header('Location: ' . $baseUrl . '/pages/pelanggan/edit_profil.php');
    exit;
}

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
        <h2 class="mb-1">Edit Profil</h2>
        <p class="text-muted">Perbarui data profil Anda.</p>

        <?php if (isset($_SESSION['flash'])): ?>
            <div class="alert alert-<?= $_SESSION['flash']['type'] ?> alert-dismissible fade show">
                <?= $_SESSION['flash']['message'] ?>
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
            <?php unset($_SESSION['flash']); ?>
        <?php endif; ?>

        <div class="card p-4">
            <form method="POST">
                <div class="mb-3">
                    <label for="nama_pelanggan" class="form-label">Nama Lengkap</label>
                    <input type="text" name="nama_pelanggan" id="nama_pelanggan" class="form-control" value="<?= htmlspecialchars($pelanggan['nama_pelanggan']) ?>" required>
                </div>
                <div class="mb-3">
                    <label class="form-label">Username</label>
                    <input type="text" class="form-control" value="<?= htmlspecialchars($pelanggan['username']) ?>" disabled>
                    <small class="text-muted">Username tidak dapat diubah.</small>
                </div>
                <div class="mb-3">
                    <label for="alamat" class="form-label">Alamat</label>
                    <textarea name="alamat" id="alamat" class="form-control" rows="3" required><?= htmlspecialchars($pelanggan['alamat']) ?></textarea>
                </div>
                <div class="mb-3">
                    <label for="no_hp" class="form-label">No. HP</label>
                    <input type="tel" name="no_hp" id="no_hp" class="form-control" value="<?= htmlspecialchars($pelanggan['no_hp']) ?>" required>
                </div>
                <div class="mb-3">
                    <label for="password" class="form-label">Password Baru <small class="text-muted">(Kosongkan jika tidak diubah)</small></label>
                    <input type="password" name="password" id="password" class="form-control">
                </div>
                <button type="submit" class="btn btn-primary">Simpan Perubahan</button>
                <a href="<?= $baseUrl ?>/pages/pelanggan/dashboard.php" class="btn btn-secondary">Batal</a>
            </form>
        </div>
    </div>
</main>

<?php include __DIR__ . '/../../includes/footer.php'; ?>

<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

require_once __DIR__ . '/../../includes/auth.php';
requireLogin();

// Pastikan hanya admin/karyawan yang bisa akses
if (!in_array($_SESSION['role'], ['admin', 'karyawan'])) {
    header('Location: ' . getBaseUrl() . '/login.php');
    exit;
}

$db = db();

if (!isset($_GET['id']) || empty($_GET['id'])) {
    $_SESSION['flash'] = ['type' => 'danger', 'message' => 'ID pelanggan tidak ditemukan.'];
    header('Location: data_pelanggan.php');
    exit;
}

$id_pelanggan = $_GET['id'];

// Ambil data pelanggan
$stmt = $db->prepare("SELECT * FROM pelanggan WHERE id_pelanggan = :id");
$stmt->execute(['id' => $id_pelanggan]);
$pelanggan = $stmt->fetch();

if (!$pelanggan) {
    $_SESSION['flash'] = ['type' => 'danger', 'message' => 'Data pelanggan tidak ditemukan.'];
    header('Location: data_pelanggan.php');
    exit;
}

$error = '';
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $nama_pelanggan = trim($_POST['nama_pelanggan'] ?? '');
    $username       = trim($_POST['username'] ?? '');
    $no_hp          = trim($_POST['no_hp'] ?? '');
    $alamat         = trim($_POST['alamat'] ?? '');
    $password_baru  = trim($_POST['password'] ?? '');

    // Validasi wajib
    if ($nama_pelanggan === '' || $username === '' || $no_hp === '') {
        $error = 'Nama, Username, dan No. HP wajib diisi!';
    } else {
        // Cek username unik (kecuali untuk pelanggan ini sendiri)
        $cekUsername = $db->prepare("SELECT id_pelanggan FROM pelanggan WHERE username = :username AND id_pelanggan != :id");
        $cekUsername->execute(['username' => $username, 'id' => $id_pelanggan]);
        if ($cekUsername->fetch()) {
            $error = 'Username sudah digunakan pelanggan lain!';
        } else {
            // Siapkan query update
            if ($password_baru !== '') {
                $password_hash = md5($password_baru);
                $sql = "UPDATE pelanggan SET 
                        nama_pelanggan = :nama, 
                        username = :username, 
                        password = :password, 
                        no_hp = :no_hp, 
                        alamat = :alamat,
                        updated_at = NOW()
                        WHERE id_pelanggan = :id";
                $params = [
                    'nama'     => $nama_pelanggan,
                    'username' => $username,
                    'password' => $password_hash,
                    'no_hp'    => $no_hp,
                    'alamat'   => $alamat,
                    'id'       => $id_pelanggan,
                ];
            } else {
                $sql = "UPDATE pelanggan SET 
                        nama_pelanggan = :nama, 
                        username = :username, 
                        no_hp = :no_hp, 
                        alamat = :alamat,
                        updated_at = NOW()
                        WHERE id_pelanggan = :id";
                $params = [
                    'nama'     => $nama_pelanggan,
                    'username' => $username,
                    'no_hp'    => $no_hp,
                    'alamat'   => $alamat,
                    'id'       => $id_pelanggan,
                ];
            }

            $update = $db->prepare($sql);
            $update->execute($params);

            $_SESSION['flash'] = ['type' => 'success', 'message' => 'Data pelanggan berhasil diperbarui!'];
            header('Location: data_pelanggan.php');
            exit;
        }
    }

    // Jika error, isi ulang data form dengan input user
    $pelanggan['nama_pelanggan'] = $nama_pelanggan;
    $pelanggan['username']       = $username;
    $pelanggan['no_hp']          = $no_hp;
    $pelanggan['alamat']         = $alamat;
}

$pageTitle = 'Edit Pelanggan';
require_once __DIR__ . '/../../includes/header.php';
require_once __DIR__ . '/../../includes/sidebar.php';
?>

<div id="content">
    <div class="container-fluid">
        <h2 class="mb-4"><i class="fa-solid fa-user-pen me-2"></i>Edit Pelanggan</h2>

        <?php if ($error): ?>
            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                <i class="fa-solid fa-circle-exclamation me-2"></i><?= htmlspecialchars($error) ?>
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
        <?php endif; ?>

        <form method="POST" action="edit_pelanggan.php?id=<?= htmlspecialchars($id_pelanggan) ?>">
            <div class="mb-3">
                <label for="nama_pelanggan" class="form-label fw-semibold">Nama Pelanggan <span class="text-danger">*</span></label>
                <input type="text" class="form-control" id="nama_pelanggan" name="nama_pelanggan" required
                       value="<?= htmlspecialchars($pelanggan['nama_pelanggan']) ?>">
            </div>

            <div class="mb-3">
                <label for="username" class="form-label fw-semibold">Username <span class="text-danger">*</span></label>
                <input type="text" class="form-control" id="username" name="username" required
                       value="<?= htmlspecialchars($pelanggan['username']) ?>">
            </div>

            <div class="mb-3">
                <label for="password" class="form-label fw-semibold">Password <small class="text-muted">(Kosongkan jika tidak ingin mengubah)</small></label>
                <input type="password" class="form-control" id="password" name="password" placeholder="Masukkan password baru...">
            </div>

            <div class="mb-3">
                <label for="no_hp" class="form-label fw-semibold">No. HP <span class="text-danger">*</span></label>
                <input type="text" class="form-control" id="no_hp" name="no_hp" required
                       value="<?= htmlspecialchars($pelanggan['no_hp']) ?>">
            </div>

            <div class="mb-3">
                <label for="alamat" class="form-label fw-semibold">Alamat</label>
                <textarea class="form-control" id="alamat" name="alamat" rows="3"><?= htmlspecialchars($pelanggan['alamat']) ?></textarea>
            </div>

            <button type="submit" class="btn btn-primary">
                <i class="fa-solid fa-save me-2"></i>Simpan Perubahan
            </button>
            <a href="data_pelanggan.php" class="btn btn-secondary ms-2">
                <i class="fa-solid fa-arrow-left me-2"></i>Batal
            </a>
        </form>
    </div>
</div>

<?php require_once __DIR__ . '/../../includes/footer.php'; ?>

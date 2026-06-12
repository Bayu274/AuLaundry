<?php
// Aktifkan error reporting untuk debugging (bisa dimatikan di produksi)
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

require_once __DIR__ . '/../../includes/auth.php';
requireLogin();

// Pastikan hanya karyawan yang bisa akses dashboard ini
if ($_SESSION['role'] !== 'karyawan') {
    header('Location: ' . getBaseUrl() . '/login.php');
    exit;
}

$pageTitle = 'Dashboard Karyawan';
require_once __DIR__ . '/../../includes/header.php';
require_once __DIR__ . '/../../includes/sidebar.php';

// Koneksi database
$db = db();

// Statistik pesanan berdasarkan status
$pesananMenunggu = $db->query("SELECT COUNT(*) FROM pesanan WHERE status_laundry = 'Menunggu'")->fetchColumn();
$pesananDiproses = $db->query("SELECT COUNT(*) FROM pesanan WHERE status_laundry = 'Diproses'")->fetchColumn();
$pesananSelesai = $db->query("SELECT COUNT(*) FROM pesanan WHERE status_laundry = 'Selesai'")->fetchColumn();
$belumDiambil = $db->query("SELECT COUNT(*) FROM pesanan WHERE status_laundry = 'Selesai' AND pesanan_diambil = 0")->fetchColumn();

// Ambil 5 pesanan terbaru untuk ditampilkan
$pesananTerbaru = $db->query("
    SELECT p.*, pel.nama_pelanggan 
    FROM pesanan p 
    JOIN pelanggan pel ON p.id_pelanggan = pel.id_pelanggan 
    ORDER BY p.tgl_masuk DESC 
    LIMIT 5
")->fetchAll();

?>

<div id="content">
    <div class="container-fluid">
        <h2 class="mb-4"><i class="fa-solid fa-tasks me-2"></i>Dashboard Karyawan Laundry</h2>

        <!-- Statistik Utama -->
        <div class="row g-3 mb-4">
            <div class="col-md-3">
                <div class="card shadow-sm h-100 border-warning border-3">
                    <div class="card-body d-flex align-items-center">
                        <div class="me-3 p-3 rounded-circle bg-warning bg-opacity-10">
                            <i class="fa-solid fa-clock fa-2xl text-warning"></i>
                        </div>
                        <div>
                            <div class="text-muted small">Pesanan Menunggu</div>
                            <div class="fs-4 fw-bold"><?= number_format($pesananMenunggu) ?></div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-3">
                <div class="card shadow-sm h-100 border-primary border-3">
                    <div class="card-body d-flex align-items-center">
                        <div class="me-3 p-3 rounded-circle bg-primary bg-opacity-10">
                            <i class="fa-solid fa-spinner fa-2xl text-primary"></i>
                        </div>
                        <div>
                            <div class="text-muted small">Pesanan Diproses</div>
                            <div class="fs-4 fw-bold"><?= number_format($pesananDiproses) ?></div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-3">
                <div class="card shadow-sm h-100 border-success border-3">
                    <div class="card-body d-flex align-items-center">
                        <div class="me-3 p-3 rounded-circle bg-success bg-opacity-10">
                            <i class="fa-solid fa-check-circle fa-2xl text-success"></i>
                        </div>
                        <div>
                            <div class="text-muted small">Pesanan Selesai</div>
                            <div class="fs-4 fw-bold"><?= number_format($pesananSelesai) ?></div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-3">
                <div class="card shadow-sm h-100 border-info border-3">
                    <div class="card-body d-flex align-items-center">
                        <div class="me-3 p-3 rounded-circle bg-info bg-opacity-10">
                            <i class="fa-solid fa-box fa-2xl text-info"></i>
                        </div>
                        <div>
                            <div class="text-muted small">Belum Diambil</div>
                            <div class="fs-4 fw-bold"><?= number_format($belumDiambil) ?></div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Tabel Pesanan Terbaru -->
        <div class="card shadow-sm">
            <div class="card-header d-flex justify-content-between align-items-center bg-white">
                <h5 class="mb-0"><i class="fa-solid fa-clock-rotate-left me-2"></i>Pesanan Terbaru</h5>
                <a href="data_pesanan.php" class="btn btn-sm btn-outline-primary">Lihat Semua</a>
            </div>
            <div class="card-body p-0">
                <div class="table-responsive">
                    <table class="table table-hover align-middle mb-0">
                        <thead class="table-light">
                            <tr>
                                <th>No. Pesanan</th>
                                <th>Pelanggan</th>
                                <th>Layanan</th>
                                <th>Status</th>
                                <th>Tanggal Masuk</th>
                                <th>Estimasi Selesai</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php if (empty($pesananTerbaru)): ?>
                                <tr>
                                    <td colspan="6" class="text-center py-4 text-muted">Belum ada pesanan.</td>
                                </tr>
                            <?php else: ?>
                                <?php foreach ($pesananTerbaru as $pesanan): ?>
                                    <tr>
                                        <td><code><?= htmlspecialchars($pesanan['no_pesanan']) ?></code></td>
                                        <td><?= htmlspecialchars($pesanan['nama_pelanggan']) ?></td>
                                        <td><?= htmlspecialchars($pesanan['jenis_layanan']) ?></td>
                                        <td>
                                            <span class="badge 
                                                <?php if ($pesanan['status_laundry'] === 'Menunggu') echo 'bg-warning text-dark'; ?>
                                                <?php if ($pesanan['status_laundry'] === 'Diproses') echo 'bg-primary'; ?>
                                                <?php if ($pesanan['status_laundry'] === 'Selesai') echo 'bg-success'; ?>
                                            ">
                                                <?= htmlspecialchars($pesanan['status_laundry']) ?>
                                            </span>
                                        </td>
                                        <td><?= date('d M Y', strtotime($pesanan['tgl_masuk'])) ?></td>
                                        <td><?= $pesanan['tgl_selesai'] ? date('d M Y', strtotime($pesanan['tgl_selesai'])) : '-' ?></td>
                                    </tr>
                                <?php endforeach; ?>
                            <?php endif; ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>

<?php require_once __DIR__ . '/../../includes/footer.php'; ?>

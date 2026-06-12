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

$pageTitle = 'Dashboard Admin';
require_once __DIR__ . '/../../includes/header.php';
require_once __DIR__ . '/../../includes/sidebar.php';

// Koneksi database
$db = db();

// Statistik
$totalPelanggan = $db->query("SELECT COUNT(*) FROM pelanggan")->fetchColumn();
$totalPesanan = $db->query("SELECT COUNT(*) FROM pesanan")->fetchColumn();
$totalPendapatan = $db->query("SELECT COALESCE(SUM(total_bayar), 0) FROM pesanan WHERE status_piutang = 'Lunas'")->fetchColumn();
$pesananMenunggu = $db->query("SELECT COUNT(*) FROM pesanan WHERE status_laundry = 'Menunggu'")->fetchColumn();
$pesananDiproses = $db->query("SELECT COUNT(*) FROM pesanan WHERE status_laundry = 'Diproses'")->fetchColumn();
$pesananSelesai = $db->query("SELECT COUNT(*) FROM pesanan WHERE status_laundry = 'Selesai'")->fetchColumn();
$belumDiambil = $db->query("SELECT COUNT(*) FROM pesanan WHERE status_laundry = 'Selesai' AND pesanan_diambil = 0")->fetchColumn();
$piutangBelumLunas = $db->query("SELECT COALESCE(SUM(total_bayar), 0) FROM pesanan WHERE status_piutang = 'Belum Lunas'")->fetchColumn();

// Pendapatan bulan ini
$bulanIni = date('Y-m');
$stmtBulan = $db->prepare("SELECT COALESCE(SUM(total_bayar), 0) FROM pesanan WHERE status_piutang = 'Lunas' AND DATE_FORMAT(tgl_masuk, '%Y-%m') = :bulan");
$stmtBulan->execute(['bulan' => $bulanIni]);
$pendapatanBulanIni = $stmtBulan->fetchColumn();

// Pesanan terbaru (5 terakhir)
$pesananTerbaru = $db->query("SELECT p.*, pel.nama_pelanggan FROM pesanan p JOIN pelanggan pel ON p.id_pelanggan = pel.id_pelanggan ORDER BY p.tgl_masuk DESC LIMIT 5")->fetchAll();

$user = currentUser();
?>

<div id="content">
    <div class="page-header mb-4">
        <h1>Dashboard</h1>
        <p>Selamat datang, <strong><?= htmlspecialchars($user['nama_admin'] ?? 'Admin') ?></strong>! Berikut ringkasan data AuLaundry.</p>
    </div>

    <?php include __DIR__ . '/../../includes/flash.php'; ?>

    <!-- Statistik Utama -->
    <div class="row g-3 mb-4">
        <div class="col-lg-3 col-md-6">
            <div class="card border-0 shadow-sm h-100">
                <div class="card-body d-flex align-items-center">
                    <div class="rounded-circle bg-primary bg-opacity-10 p-3 me-3">
                        <i class="fa-solid fa-users fa-lg text-primary"></i>
                    </div>
                    <div>
                        <div class="text-muted small">Total Pelanggan</div>
                        <div class="fw-bold fs-4"><?= number_format($totalPelanggan) ?></div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-lg-3 col-md-6">
            <div class="card border-0 shadow-sm h-100">
                <div class="card-body d-flex align-items-center">
                    <div class="rounded-circle bg-success bg-opacity-10 p-3 me-3">
                        <i class="fa-solid fa-file-invoice-dollar fa-lg text-success"></i>
                    </div>
                    <div>
                        <div class="text-muted small">Total Pesanan</div>
                        <div class="fw-bold fs-4"><?= number_format($totalPesanan) ?></div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-lg-3 col-md-6">
            <div class="card border-0 shadow-sm h-100">
                <div class="card-body d-flex align-items-center">
                    <div class="rounded-circle bg-warning bg-opacity-10 p-3 me-3">
                        <i class="fa-solid fa-money-bill-wave fa-lg text-warning"></i>
                    </div>
                    <div>
                        <div class="text-muted small">Pendapatan Bulan Ini</div>
                        <div class="fw-bold fs-5">Rp <?= number_format($pendapatanBulanIni, 0, ',', '.') ?></div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-lg-3 col-md-6">
            <div class="card border-0 shadow-sm h-100">
                <div class="card-body d-flex align-items-center">
                    <div class="rounded-circle bg-danger bg-opacity-10 p-3 me-3">
                        <i class="fa-solid fa-exclamation-triangle fa-lg text-danger"></i>
                    </div>
                    <div>
                        <div class="text-muted small">Piutang Belum Lunas</div>
                        <div class="fw-bold fs-5">Rp <?= number_format($piutangBelumLunas, 0, ',', '.') ?></div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Status Pesanan -->
    <div class="row g-3 mb-4">
        <div class="col-lg-3 col-md-6">
            <div class="card border-0 shadow-sm h-100 border-start border-warning border-4">
                <div class="card-body text-center">
                    <div class="text-muted small">Menunggu</div>
                    <div class="fw-bold fs-3 text-warning"><?= $pesananMenunggu ?></div>
                </div>
            </div>
        </div>
        <div class="col-lg-3 col-md-6">
            <div class="card border-0 shadow-sm h-100 border-start border-primary border-4">
                <div class="card-body text-center">
                    <div class="text-muted small">Diproses</div>
                    <div class="fw-bold fs-3 text-primary"><?= $pesananDiproses ?></div>
                </div>
            </div>
        </div>
        <div class="col-lg-3 col-md-6">
            <div class="card border-0 shadow-sm h-100 border-start border-success border-4">
                <div class="card-body text-center">
                    <div class="text-muted small">Selesai</div>
                    <div class="fw-bold fs-3 text-success"><?= $pesananSelesai ?></div>
                </div>
            </div>
        </div>
        <div class="col-lg-3 col-md-6">
            <div class="card border-0 shadow-sm h-100 border-start border-info border-4">
                <div class="card-body text-center">
                    <div class="text-muted small">Belum Diambil</div>
                    <div class="fw-bold fs-3 text-info"><?= $belumDiambil ?></div>
                </div>
            </div>
        </div>
    </div>

    <!-- Pesanan Terbaru -->
    <div class="card border-0 shadow-sm">
        <div class="card-header bg-white d-flex justify-content-between align-items-center">
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
                            <th>Total</th>
                            <th>Status</th>
                            <th>Pengambilan</th>
                            <th>Tanggal</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php if (empty($pesananTerbaru)): ?>
                            <tr>
                                <td colspan="7" class="text-center py-4 text-muted">Belum ada pesanan.</td>
                            </tr>
                        <?php else: ?>
                            <?php foreach ($pesananTerbaru as $p): ?>
                                <tr>
                                    <td><code><?= htmlspecialchars($p['no_pesanan']) ?></code></td>
                                    <td><?= htmlspecialchars($p['nama_pelanggan']) ?></td>
                                    <td><?= htmlspecialchars($p['jenis_layanan']) ?></td>
                                    <td>Rp <?= number_format($p['total_bayar'], 0, ',', '.') ?></td>
                                    <td>
                                        <?php
                                        $badgeClass = 'bg-secondary';
                                        if ($p['status_laundry'] === 'Menunggu') $badgeClass = 'bg-warning text-dark';
                                        elseif ($p['status_laundry'] === 'Diproses') $badgeClass = 'bg-primary';
                                        elseif ($p['status_laundry'] === 'Selesai') $badgeClass = 'bg-success';
                                        ?>
                                        <span class="badge <?= $badgeClass ?>">
                                            <?= htmlspecialchars($p['status_laundry']) ?>
                                        </span>
                                    </td>
                                    <td>
                                        <span class="badge <?= $p['pesanan_diambil'] ? 'bg-success' : 'bg-secondary' ?>">
                                            <?= $p['pesanan_diambil'] ? 'Sudah' : 'Belum' ?>
                                        </span>
                                    </td>
                                    <td><?= date('d M Y', strtotime($p['tgl_masuk'])) ?></td>
                                </tr>
                            <?php endforeach; ?>
                        <?php endif; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

<?php require_once __DIR__ . '/../../includes/footer.php'; ?>
